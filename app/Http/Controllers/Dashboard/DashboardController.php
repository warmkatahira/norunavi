<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Ride;
// その他
use Carbon\CarbonImmutable;

class DashboardController extends Controller
{
    public function index()
    {
        // ページヘッダーをセッションに格納
        session(['page_header' => 'ダッシュボード']);
        // 表示対象の日付を格納するコレクションを作成
        $dates = collect();
        // 今日の日付を基準にする
        $cursor = CarbonImmutable::today();
        // 土日を除いた「今日を含む10日分」の日付を作成
        while($dates->count() < 10){
            // 土日でなければコレクションに追加
            if(!$cursor->isWeekend()){
                $dates->push($cursor);
            }
            // 次の日へ進める
            $cursor = $cursor->addDay();
        }
        // 指定された期間の送迎予定を取得
        $rides = Ride::active()
                    ->whereIn('schedule_date', $dates->map->toDateString())
                    ->orderBy('schedule_date')
                    ->with(['route_type', 'ride_details.ride_users'])
                    ->get()
                    // 最小の出発時刻で並び替え
                    ->sortBy(function ($ride) {
                        return optional(
                            $ride->ride_details->min('departure_time')
                        );
                    })
                    // 日付をキーにしてグループ化
                    ->groupBy(fn ($ride) => $ride->schedule_date);
        return view('dashboard')->with([
            'dates' => $dates,
            'rides' => $rides,
        ]);
    }
}