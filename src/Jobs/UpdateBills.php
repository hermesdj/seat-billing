<?php

namespace Denngarr\Seat\Billing\Jobs;

use Denngarr\Seat\Billing\BillingSettings;
use Denngarr\Seat\Billing\Helpers\BillingHelper;
use Denngarr\Seat\Billing\Models\CharacterBill;
use Denngarr\Seat\Billing\Models\CorporationBill;
use Denngarr\Seat\Billing\Models\TaxInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Services\Exceptions\SettingException;

class UpdateBills implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, BillingHelper;

    private $force;
    private $year;
    private $month;

    /**
     * @param $force
     * @param $year
     * @param $month
     */
    public function __construct($force, $year, $month)
    {
        $this->force = $force;
        $this->year = $year;
        $this->month = $month;
    }

    public function tags(): array
    {
        return ["seat-billing", "bill",];
    }


    /**
     * @throws SettingException
     */
    public function handle(): void
    {
        $force = $this->force;
        $year = $this->year;
        $month = $this->month;

        if ($force) {
            CorporationBill::where('month', $month)
                ->where('year', $year)
                ->delete();
        }
        // See if corps already have a bill.  If not, generate one.

        $corps = CorporationInfo::all();
        foreach ($corps as $corp) {
            $bill = CorporationBill::where('corporation_id', $corp->corporation_id)
                ->where('year', $year)
                ->where('month', $month)
                ->get();


            if ($bill===null || $force) {
                $isIncentivisedRatesEligible = $this->isEligibleForIncentivesRates($corp->corporation_id);

                $bill = new CorporationBill();
                $bill->corporation_id = $corp->corporation_id;
                $bill->year = $year;
                $bill->month = $month;

                //mining data
                $mining_data = $this->getCorporationMiningTotal($corp->corporation_id, $year, $month);
                $bill->mining_total = $mining_data["mining_total"];
                $bill->mining_tax = $mining_data["mining_tax"];

                //bounty data
                $bounties = 0;
                $pve_data = $this->getBountyTotal($year, $month)
                    ->where('corporation_wallet_journals.corporation_id',$corp->corporation_id)
                    ->first();
                if ($pve_data && $pve_data->bounties){
                    $bounties = $pve_data->bounties;
                }

                $bill->pve_total = $bounties;
                $pve_tax = (setting('bountytaxrate', true) ?? 0) / 100;
                if($isIncentivisedRatesEligible){
                    $pve_tax = $pve_tax * (setting("ibountytaxmodifier",true) ?? 100) / 100;
                }
                $bill->pve_tax = $bounties * $pve_tax;

                //TODO remove when removing it from the db
                $bill->mining_taxrate = 0; // legacy fields
                $bill->mining_modifier = 0; // legacy fields
                $bill->pve_taxrate = $pve_tax * 10;

                //save corporation bill
                $bill->save();

                //character bill
                $summary = $this->getUserBilling($corp->corporation_id, $year, $month);
                foreach ($summary as $character) {
                    $bill = CharacterBill::where('character_id', $character['id'])
                        ->where('year', $year)
                        ->where('month', $month)
                        ->first();

                    $recompute = $bill===null || $force;

                    $bill = $bill ?? new CharacterBill();
                    if ($recompute) {
                        $bill->character_id = $character['id'];
                        $bill->corporation_id = $corp->corporation_id;
                        $bill->year = $year;
                        $bill->month = $month;
                        $bill->mining_total = $character['mining_total'];
                        $bill->mining_tax = $character['mining_tax'];
                        $bill->mining_modifier = 0;//legacy
                        $bill->mining_taxrate = 0;//legacy
                        $bill->user_id = $character["user_id"];
                        $bill->tax_invoice_id = $bill->tax_invoice_id ?? null; // keep the old invoice ID, or there will be duplicate invoices
                        $bill->save();
                    }
                }
            }
        }
    }
}