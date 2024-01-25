<?php

namespace Denngarr\Seat\Billing\Observers;

use Denngarr\Seat\Billing\Jobs\ProcessTaxPayment;

class CorporationWalletJournalObserver
{
    public static function created($journal_entry): void
    {
        if($journal_entry->ref_type === "player_donation" && substr(trim($journal_entry->reason),0,3) === "tax"){
            logger()->debug("scheduling tax processing");
            ProcessTaxPayment::dispatch($journal_entry);
        }
    }
}