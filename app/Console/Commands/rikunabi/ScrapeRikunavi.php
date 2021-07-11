<?php

namespace App\Console\Commands\rikunabi;

use Illuminate\Console\Command;

class ScrapeRikunavi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:rikunavi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scrape rikunavi';

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
        dump("リクナビ求人情報の取得開始いたします。");
        truncateTables();
        saveUrls();
        saveJobs();
        exportCsv();
        dump("リクナビ求人情報の取得終了いたします。");
    }
}
