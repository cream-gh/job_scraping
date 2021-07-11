<?php

namespace App\Console\Commands\mynavi;

use Illuminate\Console\Command;

class ScrapeMynavi extends Command
{
    /**
     * The name and signature of the console command.
     * コマンド名（php artisan scrape:mynavi）
     * @var string
     */
    protected $signature = 'scrape:mynavi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'scrape mynavi';

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
     * コマンド実行後ここが実行される
     * @return int
     */
    public function handle()
    {
        dump("マイナビ求人情報の取得開始いたします。");
        truncateTables();
        saveUrls();
        saveJobs();
        exportCsv();
        dump("マイナビ求人情報の取得終了いたします。");
    }
}
