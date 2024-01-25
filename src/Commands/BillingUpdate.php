<?php

namespace Denngarr\Seat\Billing\Commands;

use Denngarr\Seat\Billing\Jobs\GenerateInvoices;
use Denngarr\Seat\Billing\Jobs\UpdateBills;
use Illuminate\Console\Command;


class BillingUpdate extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'billing:update {--F|force} {--N|now}  {year?} {month?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This records the bills for the previous month if one doesn\'t exist.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        //ensure we update the last month
        $year = date('Y', strtotime('-1 month'));
        $month = date('n', strtotime('-1 month'));
        $historical = false;

        if (($this->argument('month')) && ($this->argument('year'))) {
            $year = $this->argument('year');
            $month = $this->argument('month');
            $historical = true;
        }

        $year = intval($year);
        $month = intval($month);

        if($this->option('now')){
            UpdateBills::dispatchSync($this->option('force') || !$historical, $year, $month);
            GenerateInvoices::dispatchSync($year, $month);
        } else {
            UpdateBills::withChain([
                new GenerateInvoices($year, $month)
            ])->dispatch($this->option('force') || !$historical, $year, $month);
        }
    }


}
