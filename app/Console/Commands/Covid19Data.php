<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
 


class Covid19Data extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid-19:minute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve updated covid-19 data';

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
     * @return int
     */
    public function handle()
    {
        
        $response = Http::get('https://hpb.health.gov.lk/api/get-current-statistical');
        return $response;
    }
}
