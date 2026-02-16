<?php

namespace App\Http\Controllers\Ride\RideSchedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// サービス
use App\Services\Ride\RideSchedule\RideScheduleSearchService;
use App\Services\Ride\RideSchedule\RideScheduleDownloadService;
// その他
use Carbon\CarbonImmutable;
// 列挙
use App\Enums\SystemEnum;

class RideScheduleDownloadController extends Controller
{
    public function download()
    {
        // インスタンス化
        $RideScheduleSearchService = new RideScheduleSearchService;
        $RideScheduleDownloadService = new RideScheduleDownloadService;
        // 検索結果を取得
        $result = $RideScheduleSearchService->getSearchResult();
        $result = $RideScheduleSearchService->getRequiredMinutes($result->get());
        // ダウンロードするデータを取得
        $response = $RideScheduleDownloadService->getDownloadData($result);
        // ダウンロード処理
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=【'.SystemEnum::getSystemTitle().'】送迎予定_' . CarbonImmutable::now()->isoFormat('Y年MM月DD日HH時mm分ss秒') . '.csv');
        return $response;
    }
}