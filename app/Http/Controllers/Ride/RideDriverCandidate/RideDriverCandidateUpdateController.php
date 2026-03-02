<?php

namespace App\Http\Controllers\Ride\RideDriverCandidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\Ride;
use App\Models\RideDriverCandidate;
use App\Models\Vehicle;
use App\Models\DriverStatus;
// サービス
use App\Services\Ride\RideDriverCandidate\RideDriverCandidateUpdateService;
// リクエスト
use App\Http\Requests\Ride\RideDriverCandidate\RideDriverCandidateUpdateRequest;
// その他
use Illuminate\Support\Facades\DB;

class RideDriverCandidateUpdateController extends Controller
{
    public function index(Request $request)
    {
        // ページヘッダーをセッションに格納
        session(['page_header' => 'ドライバー更新']);
        // 送迎予定を取得
        $ride = Ride::byPk($request->ride_id)->with(['ride_driver_candidates.user', 'ride_driver_candidates.vehicle', 'ride_driver_candidates.driver_status'])->first();
        // 車両を取得
        $vehicles = Vehicle::active()->ofVehicleCategory($ride->vehicle_category_id)->get();
        // ドライバーステータスを取得
        $driver_statuses = DriverStatus::ordered()->get();
        return view('ride.ride_driver_candidate.update')->with([
            'ride' => $ride,
            'vehicles' => $vehicles,
            'driver_statuses' => $driver_statuses,
        ]);
    }

    public function update(RideDriverCandidateUpdateRequest $request)
    {
        try {
            DB::transaction(function () use ($request){
                // インスタンス化
                $RideDriverCandidateUpdateService = new RideDriverCandidateUpdateService;
                // 送迎ドライバーを更新
                $RideDriverCandidateUpdateService->updateRideDriverCandidate($request);
            });
        } catch (\Exception $e){
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        return redirect(session('back_url_1'))->with([
            'alert_type' => 'success',
            'alert_message' => '送迎ドライバーを更新しました。',
        ]);
    }
}