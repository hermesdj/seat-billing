<?php

namespace Denngarr\Seat\Billing\Helpers;

use Denngarr\Seat\Billing\Http\Controllers\BillingController;
use Denngarr\Seat\Billing\Models\CharacterBill;
use Denngarr\Seat\Billing\Models\CorporationBill;
use Illuminate\Support\Facades\DB;
use Seat\Services\Exceptions\SettingException;
use Seat\Services\Models\UserSetting;
use Seat\Web\Models\User;
use Illuminate\Support\Collection;

use Illuminate\Database\Eloquent\Builder;
use Seat\Eveapi\Models\Corporation\CorporationMemberTracking;

trait BillingHelper
{
    /**
     * @throws SettingException
     */
    public function getCharacterBilling($corporation_id, $year, $month): Collection
    {
        $refineRate = setting("refinerate", true);
        $miningTax = setting('oretaxrate', true);

        if($this->isEligibleForIncentivesRates($corporation_id)){
            $incentiveModifier =  setting("ioretaxmodifier",true) ?? 100;
            $valuation = setting('ioremodifier', true) ?? 100;
        } else {
            $incentiveModifier = 100;
            $valuation = setting('oremodifier', true) ?? 100;
        }

        $price_source = setting("price_source",true);
        if($price_source === null || !in_array($price_source,BillingController::ALLOWED_PRICE_SOURCES)){
            // old default value
            $price_source = "average_price";
        }

        if (setting("pricevalue", true) == "m") {
            $ledger = DB::table('character_minings')
                ->select('character_minings.character_id as main_character_id','character_infos.name','users.id as user_id')
                ->selectRaw("SUM(IFNULL((character_minings.quantity / 100) * (invTypeMaterials.quantity * ? / 100),character_minings.quantity) * market_prices.$price_source * (?/100)) as mining_value", [$refineRate,$valuation])
                ->selectRaw("SUM(IFNULL((character_minings.quantity / 100) * (invTypeMaterials.quantity * ? / 100),character_minings.quantity) * market_prices.$price_source * (?/100) * IFNULL(seat_billing_ore_tax.tax_rate/100, ?/100) * (?/100)) as mining_tax", [$refineRate,$valuation,$miningTax,$incentiveModifier])
                ->leftJoin('invTypeMaterials', 'character_minings.type_id', 'invTypeMaterials.typeID')
                ->join('market_prices', DB::RAW('IFNULL(invTypeMaterials.materialTypeID,character_minings.type_id)'), 'market_prices.type_id')
                ->join('character_affiliations', 'character_minings.character_id', 'character_affiliations.character_id')
                ->join('character_infos','character_minings.character_id','character_infos.character_id')
                ->join('invTypes','character_minings.type_id','invTypes.typeID')
                ->join('refresh_tokens','refresh_tokens.character_id','character_minings.character_id')
                ->join('users', 'users.id', 'refresh_tokens.user_id')
                ->leftJoin('seat_billing_ore_tax','invTypes.groupID','seat_billing_ore_tax.group_id')
                ->where('year', $year)
                ->where('month', $month)
                ->where('character_affiliations.corporation_id', $corporation_id)
                ->groupBy('character_minings.character_id','character_infos.name','users.id')
                ->get();
        } else {
            $ledger = DB::table('character_minings')
                ->select('character_minings.character_id as main_character_id','character_infos.name','users.id as user_id')
                ->selectRaw("SUM(character_minings.quantity * market_prices.$price_source * (?/100)) as mining_value",[$valuation])
                ->selectRaw("SUM(character_minings.quantity * market_prices.$price_source * (?/100) * IFNULL(seat_billing_ore_tax.tax_rate/100, ?/100) * (?/100)) as mining_tax",[$valuation,$miningTax, $incentiveModifier])
                ->join('market_prices', 'character_minings.type_id', 'market_prices.type_id')
                ->join('character_affiliations', 'character_minings.character_id', 'character_affiliations.character_id')
                ->join('character_infos','character_minings.character_id','character_infos.character_id')
                ->join('invTypes','character_minings.type_id','invTypes.typeID')
                ->join('refresh_tokens','refresh_tokens.character_id','character_minings.character_id')
                ->join('users', 'users.id', 'refresh_tokens.user_id')
                ->leftJoin('seat_billing_ore_tax','invTypes.groupID','seat_billing_ore_tax.group_id')
                ->where('year', $year)
                ->where('month', $month)
                ->where('character_affiliations.corporation_id', $corporation_id)
                ->groupBy('character_minings.character_id','character_infos.name','users.id')
                ->get();
        }

        return $ledger;
    }

    /**
     * @throws SettingException
     */
    public function getUserBilling($corporation_id, $year = null, $month = null): array
    {
        if (is_null($year)) {
            $year = date('Y');
        }
        if (is_null($month)) {
            $month = date('n');
        }

        $summary = [];

        $ledger = $this->getCharacterBilling($corporation_id, $year, $month);

        foreach ($ledger as $entry) {

            if (!isset($summary[$entry->main_character_id])) {
                $summary[$entry->main_character_id]['mining_total'] = 0;
                $summary[$entry->main_character_id]['mining_tax'] = 0;
            }

            $summary[$entry->main_character_id]['mining_total'] += $entry->mining_value;
            $summary[$entry->main_character_id]['mining_tax'] += $entry->mining_tax;
            $summary[$entry->main_character_id]['id'] = $entry->main_character_id;
            $summary[$entry->main_character_id]['name'] = $entry->name;
            $summary[$entry->main_character_id]['user_id'] = $entry->user_id;
        }
        return $summary;
    }

    /**
     * @throws SettingException
     */
    public function isEligibleForIncentivesRates($corporation_id): bool
    {
        $total_chars = CorporationMemberTracking::where('corporation_id', $corporation_id)->count();
        if ($total_chars == 0) {
            return false;
        }

        $reg_chars = DB::table("corporation_member_trackings")
            ->where("corporation_id",$corporation_id)
            ->join('refresh_tokens', function ($join) {
                $join->on('corporation_member_trackings.character_id', '=', 'refresh_tokens.character_id')
                    ->whereNull('deleted_at');
            })
            ->count();

        return ($reg_chars / $total_chars) >= (setting('irate', true) / 100);
    }

    /**
     * @throws SettingException
     */
    private function getCorporationMiningTotal($corporation_id, $year, $month): array
    {
        $ledgers = $this->getCharacterBilling($corporation_id, $year, $month);

        return [
            "mining_total"=>$ledgers->sum('mining_value'),
            "mining_tax"=>$ledgers->sum('mining_tax')
        ];
    }

    private function getCorporationBillingMonths()
    {
        return CorporationBill::select(DB::raw('DISTINCT month, year'))
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }


    private function getCharacterBillByMonth($corporation_id, $year, $month): \Illuminate\Database\Eloquent\Collection|array
    {
        return CharacterBill::query()
            ->select("users.main_character_id as character_id", "character_infos.name as character_name")
            ->selectRaw("SUM(mining_tax) as mining_tax")
            ->selectRaw("SUM(mining_total) as mining_total")
            ->where("seat_billing_character_bill.corporation_id", $corporation_id)
            ->where("month", $month)
            ->where("year", $year)
            ->where("character_affiliations.corporation_id",$corporation_id)
            ->join('users', 'users.id', 'user_id')
            ->join('character_infos','users.main_character_id','character_infos.character_id')
            ->join('character_affiliations', 'users.main_character_id', 'character_affiliations.character_id')
            ->groupBy("character_infos.character_id","character_infos.name",'users.main_character_id')
            ->get();
    }

    private function getBountyTotal($year, $month): \Illuminate\Database\Query\Builder
    {
        return DB::table('corporation_wallet_journals')
            ->select("corporation_wallet_journals.corporation_id")
            ->selectRaw('SUM(amount) / corporation_infos.tax_rate as bounties')
            ->join('corporation_infos', 'corporation_infos.corporation_id', '=', 'corporation_wallet_journals.corporation_id')
            ->whereIn('corporation_wallet_journals.ref_type', ['bounty_prizes', 'bounty_prize', 'ess_escrow_transfer'])
            ->where(DB::raw('YEAR(corporation_wallet_journals.date)'), !is_null($year) ? $year : date('Y'))
            ->where(DB::raw('MONTH(corporation_wallet_journals.date)'), !is_null($month) ? $month : date('m'))
            ->groupBy('corporation_wallet_journals.corporation_id','corporation_infos.tax_rate');
    }

}
