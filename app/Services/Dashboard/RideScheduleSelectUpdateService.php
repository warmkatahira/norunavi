<?php

namespace App\Services\Dashboard;

// モデル
use App\Models\Ride;
use App\Models\RideDetail;
use App\Models\RideUser;
// その他
use Illuminate\Support\Facades\Auth;

class RideScheduleSelectUpdateService
{
    // 送迎選択を更新
    public function updateRideScheduleSelect($request)
    {
        // 送迎予定を取得
        $ride = Ride::byPk($request->ride_id)->lockForUpdate()->firstOrFail();
        // 送迎日を取得
        $schedule_date = $ride->schedule_date;
        // ルート区分を取得
        $route_type_id = $ride->route_type_id;
        // ユーザーNoを取得
        $user_no = Auth::user()->user_no;
        // 現在登録されている同じ日×同じルート区分の送迎選択を削除
        RideUser::where('user_no', $user_no)
                ->whereIn(
                    'ride_detail_id',
                    RideDetail::whereHas('ride', function ($q) use ($schedule_date, $route_type_id) {
                        $q->where('schedule_date', $schedule_date)
                        ->where('route_type_id', $route_type_id);
                    })->pluck('ride_detail_id')
                )
                ->delete();
        // 追加
        RideUser::create([
            'ride_detail_id'    => $request->ride_detail_id,
            'user_no'           => Auth::user()->user_no,
        ]);
    }
}