<?php

namespace App\Console\Commands\rikunabi;

use App\JobContents;
use Illuminate\Support\Facades\DB;
use App\Consts\Consts;

    /**
     * 求人の詳細情報をcsvへ保存
     */
    function exportCsv()
    {
        // ファイルを作成して開く
        $file = fopen(storage_path(Consts::FILE_PATH), 'w');
        if (!$file) {
            throw new \Exception('ファイルの作成に失敗しました');
        }

        // ファイルにヘッダー情報を書き込む
        if (!fputcsv($file, ['id', 'url', 'title', 'company_name', 'features', 'site_type'])) {
            throw new \Exception('ヘッダーの書き込みに失敗しました');
        }

        // ファイルにボディー情報を書き込む
        foreach (JobContents::all() as $job) {
            if (!fputcsv($file, [$job->id, $job->url, $job->title, $job->company_name, $job->features, $job->site_type])) {
                throw new \Exception('ボディーの書き込みに失敗しました');
            }
        }

        // ファイルを閉じる
        fclose($file);
    }