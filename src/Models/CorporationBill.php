<?php

namespace Denngarr\Seat\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Seat\Eveapi\Models\Corporation\CorporationInfo;
use Seat\Eveapi\Models\Wallet\CorporationWalletJournal;

class CorporationBill extends Model
{
    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $table = 'seat_billing_corp_bill';

    /**
     * @var array
     */
    protected $fillable = [
        'id', 'corporation_id', 'month', 'year', 'pve_bill', 'mining_bill',
        'pve_taxrate', 'mining_taxrate', 'mining_modifier'];

    /**
     * @return BelongsTo
     */
    public function corporation(): BelongsTo
    {
        return $this->belongsTo(CorporationInfo::class, 'corporation_id', 'corporation_id')
            ->withDefault(function () {
                return new CorporationInfo([
                    'name' => 'Unknown',
                ]);
            });
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        $pve_amount = $this->pve_bill * ($this->pve_taxrate / 100);
        $mined_amount = $this->mining_bill * ($this->mining_modifier / 100) * ($this->mining_taxrate / 100);
        $searched_amount = $pve_amount + $mined_amount;
        return $this->computeIsPaid($searched_amount);
    }

    /**
     * @return bool
     */
    public function isPvePaid(): bool
    {
        $searched_amount = $this->pve_bill * ($this->pve_taxrate / 100);
        return $this->computeIsPaid($searched_amount);
    }

    /**
     * @return bool
     */
    public function isMiningPaid(): bool
    {
        $searched_amount = $this->mining_bill * ($this->mining_modifier / 100) * ($this->mining_taxrate / 100);
        return $this->computeIsPaid($searched_amount);
    }

    private function computeIsPaid(float $searched_amount): bool
    {
        $start_date = carbon(sprintf('%d-%d-01', $this->year, $this->month))->addMonth()->startOfMonth();
        $end_date = carbon(sprintf('%d-%d-01', $this->year, $this->month))->addMonth()->endOfMonth();

        $journal_id = $this->getPaidBillFromJournal(round($searched_amount, 0), $start_date->toDateString(), $end_date->toDateString())
            ->get();

        return !$journal_id->isEmpty();
    }

    /**
     * @param int $searched_amount
     * @param string $start_date
     * @param string $end_date
     * @return mixed
     */
    private function getPaidBillFromJournal(int $searched_amount, string $start_date, string $end_date): mixed
    {
        $min_amount = ($searched_amount + 1) * -1;
        $max_amount = ($searched_amount - 1) * -1;

        return CorporationWalletJournal::where('corporation_id', $this->corporation_id)
            ->whereIn('ref_type', ['player_donation', 'contract_price_payment_corp'])
            ->whereBetween('date', [$start_date, $end_date])
            ->whereBetween('amount', [$min_amount, $max_amount]);
    }
}
