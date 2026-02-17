<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Ride;
// その他
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

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
        // 共通クエリを定義
        $baseQuery = Ride::active()
                        ->whereIn('schedule_date', $dates->map->toDateString())
                        ->orderBy('schedule_date')
                        ->with(['route_type', 'ride_details.ride_users', 'user']);
        // 指定された期間の送迎予定を取得
        $rides = (clone $baseQuery)
                    ->get()
                    ->sortBy(fn ($ride) => optional($ride->ride_details->min('departure_time')))
                    ->groupBy(fn ($ride) => $ride->schedule_date);
        // 指定された期間の自分がドライバーの送迎予定を取得
        $my_driver_ride_schedules = (clone $baseQuery)
                                        ->where('driver_user_no', Auth::user()->user_no)
                                        ->get()
                                        ->sortBy(fn ($ride) => optional($ride->ride_details->min('departure_time')))
                                        ->groupBy(fn ($ride) => $ride->schedule_date);
        return view('dashboard')->with([
            'dates' => $dates,
            'rides' => $rides,
            'my_driver_ride_schedules' => $my_driver_ride_schedules,
        ]);
    }
}