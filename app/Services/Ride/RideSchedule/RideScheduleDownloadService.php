<?php

namespace App\Services\Ride\RideSchedule;

// モデル
use App\Models\Ride;
// その他
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\CarbonImmutable;
// 列挙
use App\Enums\SystemEnum;

class RideScheduleDownloadService
{
    // ダウンロードするデータを取得
    public function getDownloadData($ride_schedule)
    {
        // チャンクサイズを指定
        $chunk_size = 1000;
        $response = new StreamedResponse(function () use ($ride_schedule, $chunk_size){
            // ハンドルを取得
            $handle = fopen('php://output', 'wb');
            // BOMを書き込む
            fwrite($handle, "\xEF\xBB\xBF");
            // システムに定義してあるヘッダーを取得し、書き込む
            $header = Ride::downloadHeader();
            fputcsv($handle, $header);
            // レコードをチャンクごとに書き込む
            $ride_schedule->chunk($chunk_size)->each(function ($ride_schedule) use ($handle) {
                // ルートの分だけループ処理
                foreach($ride_schedule as $ride){
                    // ドライバーと使用車両を取得
                    $drivers = $ride->confirmed_driver_candidates
                                    ->map(function ($candidate) {
                                        $name = $candidate->user->full_name ?? '';
                                        $vehicle = $candidate->vehicle?->vehicle_name;

                                        return $vehicle
                                            ? "{$name} / {$vehicle}"
                                            : $name;
                                    })
                                    ->join(' | ');
                    // ルート詳細の分だけループ処理
                    foreach($ride->ride_details as $ride_detail){
                        // 出発時刻を取得
                        $dep = $ride_detail->departure_time ? CarbonImmutable::parse($ride_detail->departure_time)->format('H:i') : null;
                        // 到着時刻を取得
                        $arr = $ride_detail->arrival_time ? CarbonImmutable::parse($ride_detail->arrival_time)->format('H:i') : null;
                        // 情報があるものに合わせて変数に格納
                        if($arr && $dep){
                            $dep_arr = $arr.' 着 → '. $dep. ' 発';
                        }elseif($arr){
                            $dep_arr = $arr.' 着';
                        }elseif($dep){
                            $dep_arr = $dep. ' 発';
                        }else{
                            $dep_arr = '—';
                        }
                        // 次の地点までの時間を取得
                        if($ride_detail->required_minutes !== null){
                            $next_time = $ride_detail->required_minutes.' 分';
                        }else{
                            $next_time = '—';
                        }
                        // 利用者を変数に格納
                        $users = $ride_detail->ride_users->pluck('user.full_name')->join(' / ');
                        // 変数に情報を格納
                        $row = [
                            $ride->schedule_date,
                            $ride->ride_status->ride_status,
                            $ride->route_type->route_type,
                            $ride->route_name,
                            $drivers,
                            $ride->vehicle_category->vehicle_category,
                            $ride->ride_memo,
                            CarbonImmutable::parse($ride->updated_at)->isoFormat('Y年MM月DD日(ddd) HH:mm:ss'),
                            $ride_detail->location_name,
                            $ride_detail->location_memo,
                            $ride_detail->stop_order,
                            $dep_arr,
                            $next_time,
                            $ride_detail->ride_users->count(),
                            $users,
                        ];
                        // 書き込む
                        fputcsv($handle, $row);
                    }
                };
            });
            // ファイルを閉じる
            fclose($handle);
        });
        return $response;
    }
}