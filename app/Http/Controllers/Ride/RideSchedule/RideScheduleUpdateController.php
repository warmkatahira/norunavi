<?php

namespace App\Http\Controllers\Ride\RideSchedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Ride;
use App\Models\Vehicle;
use App\Models\User;
// サービス
use App\Services\Ride\RideSchedule\RideScheduleUpdateService;
// リクエスト
use App\Http\Requests\Ride\RideSchedule\RideScheduleUpdateRequest;
// その他
use Illuminate\Support\Facades\DB;

class RideScheduleUpdateController extends Controller
{
    public function index(Request $request)
    {
        // ページヘッダーをセッションに格納
        session(['page_header' => '送迎予定更新']);
        // 送迎予定を取得
        $ride = Ride::byPk($request->ride_id)->with('ride_details.ride_users', 'route_type', 'vehicle_category', 'vehicle', 'user')->first();
        // 車両を取得
        $vehicles = Vehicle::active()->ofVehicleCategory($ride->vehicle_category_id)->ordered()->get();
        // ドライバーユーザーを取得
        $drivers = User::driverEligible()->active()->ordered()->get();
        return view('ride.ride_schedule.update')->with([
            'ride' => $ride,
            'vehicles' => $vehicles,
            'drivers' => $drivers,
        ]);
    }

    public function update(RideScheduleUpdateRequest $request)
    {
        try {
            DB::transaction(function () use ($request){
                // インスタンス化
                $RideScheduleUpdateService = new RideScheduleUpdateService;
                // 送迎予定を更新
                $RideScheduleUpdateService->updateRideSchedule($request);
            });
        } catch (\Exception $e){
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        return redirect(session('back_url_1'))->with([
            'alert_type' => 'success',
            'alert_message' => '送迎予定を更新しました。',
        ]);
    }
}