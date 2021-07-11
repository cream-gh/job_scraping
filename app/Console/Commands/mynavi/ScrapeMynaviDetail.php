<?php

namespace App\Console\Commands\mynavi;

use App\JobUrls;
use App\JobContents;
use Illuminate\Support\Facades\DB;
use App\Consts\Consts;

    /**
     * 求人の詳細情報取得
     */
    function saveJobs() 
    {
        foreach (JobUrls::all() as $index => $mynaviUrl) {
            $url = Consts::MYNAVI_HOST . $mynaviUrl->url;
            // 該当urlでクローラーを行う
            $crawler = \Goutte::request('GET', $url);

            // insert処理
            JobContents::create([
                'url' => $url,
                'title' => getTitle($crawler),
                'company_name' => getCompanyName($crawler),
                'features' => getFeatures($crawler),
                'site_type' => '1',
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
        return $crawler->filter('.occName')->text();
    }

    /**
     * 詳細画面の会社名取得
     */
    function getCompanyName($crawler) {
        return $crawler->filter('.companyName')->text();
    }

    /**
     * 詳細画面の特徴取得
     */
    function getFeatures($crawler) {
        $features = $crawler->filter('.cassetteRecruit__attribute.cassetteRecruit__attribute-jobinfo .cassetteRecruit__attributeLabel span')
        ->each(function ($node) {
            return $node->text();
        });
        return implode(',', $features);
    }