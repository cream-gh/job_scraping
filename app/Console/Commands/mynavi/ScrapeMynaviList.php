<?php

namespace App\Console\Commands\mynavi;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Consts\Consts;

    /**
     * 求人の一覧のurl取得処理
     */
    function saveUrls() 
    {
        foreach (range(1, Consts::PAGE_NUM) as $num) {
            $url = Consts::MYNAVI_HOST . '/list/pg' . $num . '/';
            // 該当urlでクローラーを行う
            $crawler = \Goutte::request('GET', $url);
            $urls = $crawler->filter('.cassetteRecruit__copy > a')->each
            (function ($node) {
                // aタグのhrefを取得
                $href = $node->attr('href');
                return [
                    // insert処理の結果を変数に格納
                    'url' => substr($href, 0, strpos($href, '/', 1) + 1),
                    'site_type' => '1',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            });
            // insert処理
            DB::table('job_urls')->insert($urls);
            // 30秒スリープ
            sleep(30);
        }
    }