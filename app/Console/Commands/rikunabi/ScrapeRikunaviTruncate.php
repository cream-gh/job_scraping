<?php

namespace App\Console\Commands\rikunabi;

use Illuminate\Support\Facades\DB;

    /**
     * テーブルの削除処理
     */
    function truncateTables() 
    {
        DB::table('job_urls')->truncate();
        DB::table('job_contents')->truncate();
    }