<?php

namespace App\Console\Commands\rikunabi;

use App\JobUrls;
use App\JobContents;
use Illuminate\Support\Facades\DB;
use App\Consts\Consts;
use Illuminate\Support\Str;

    /**
     * 求人の詳細情報取得
     */
    function saveJobs() 
    {
        foreach (JobUrls::all() as $index => $mynaviUrl) {
            $url = Consts::RIKUNAVI_HOST . $mynaviUrl->url;
            // 該当urlでクローラーを行う
            $crawler = \Goutte::request('GET', $url);

            // insert処理
            JobContents::create([
                'url' => $url,
                'title' => getTitle($crawler),
                'company_name' => getCompanyName($url),
                'features' => getFeatures($crawler),
                'site_type' => '2',
            ]);
            // 全取得すると時間かかるので、3つ取得
            if ($index > 3) {
                break;
            }
            // 30秒スリープ
            sleep(30);
        }
    }

    /**
     * 詳細画面のタイトル取得
     */
    function getTitle($crawler) {
        return $crawler->filter('.rn3-companyOfferHeader__heading')->text();
    }

    /**
     * 詳細画面の会社名取得
     */
    function getCompanyName($url) {
        // 文字列置換（nx1→nx2）
        $replace = str_replace('nx1', 'nx2', $url);
        // 該当urlでクローラーを行う
        $crawler = \Goutte::request('GET', $replace);
        return $crawler->filter('.rn3-companyOfferCompany__text > a')->text();
    }

    /**
     * 詳細画面の特徴取得
     */
    function getFeatures($crawler) {
        return $crawler->filter('.rn3-companyOfferHeader__text')->text();
    }