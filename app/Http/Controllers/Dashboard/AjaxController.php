<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Ride;
use App\Models\RideDetail;
// その他
use Illuminate\Support\Facades\Auth;
use Carbon\CarbonImmutable;

class ajaxController extends Controller
{
    public function get_ride_schedule_select_info(Request $request)
    {
        // 送迎予定を取得
        $ride = Ride::byPk($request->ride_id)->with('vehicle')->first();
        // 送迎詳細を取得
        $ride_details = RideDetail::where('ride_id', $request->ride_id)->with('ride_users.user')->get();
        // 自分が登録しているride_detailsを取得
        $my_ride_detail = $ride_details->filter(function($ride_detail) {
            return $ride_detail->ride_users->contains('user_no', Auth::user()->user_no);
        });
        // 送迎日を変換して取得
        $schedule_date = CarbonImmutable::parse($ride->schedule_date)->isoFormat('YYYY年MM月DD日(ddd)');
        return response()->json([
            'ride' => $ride,
            'ride_details' => $ride_details,
            'my_ride_detail' => $my_ride_detail,
            'schedule_date' => $schedule_date,
        ]);
    }
}