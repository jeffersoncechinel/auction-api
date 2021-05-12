<?php

namespace App\Console\Commands;

use App\Services\UserAutoBidding\Actions\SetBidsForAllItems;
use Illuminate\Console\Command;

class AutoBid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'autobid:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs auto bidding process.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        while(true) {
            (new SetBidsForAllItems())->execute();
            sleep(3);
        }
    }
}
