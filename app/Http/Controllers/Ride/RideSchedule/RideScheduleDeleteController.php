<?php

namespace App\Http\Controllers\Ride\RideSchedule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// サービス
use App\Services\Ride\RideSchedule\RideScheduleDeleteService;
// リクエスト
use App\Http\Requests\Ride\RideSchedule\RideScheduleDeleteRequest;
// その他
use Illuminate\Support\Facades\DB;

class RideScheduleDeleteController extends Controller
{
    public function delete(RideScheduleDeleteRequest $request)
    {
        try {
            DB::transaction(function () use ($request){
                // インスタンス化
                $RideScheduleDeleteService = new RideScheduleDeleteService;
                // 送迎予定を削除
                $RideScheduleDeleteService->deleteRideSchedule($request);
            });
        } catch (\Exception $e){
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        return redirect(session('back_url_1'))->with([
            'alert_type' => 'success',
            'alert_message' => '送迎予定を削除しました。',
        ]);
    }
}