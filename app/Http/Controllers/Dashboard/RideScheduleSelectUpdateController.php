<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// サービス
use App\Services\Dashboard\RideScheduleSelectUpdateService;
// リクエスト
use App\Http\Requests\Dashboard\RideScheduleSelectUpdateRequest;
// その他
use Illuminate\Support\Facades\DB;

class RideScheduleSelectUpdateController extends Controller
{
    public function update(RideScheduleSelectUpdateRequest $request)
    {
        try {
            DB::transaction(function () use ($request){
                // インスタンス化
                $RideScheduleSelectUpdateService = new RideScheduleSelectUpdateService;
                // 送迎選択を更新
                $RideScheduleSelectUpdateService->updateRideScheduleSelect($request);
            });
        } catch (\Exception $e){
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        return redirect()->route('dashboard.index')->with([
            'alert_type' => 'success',
            'alert_message' => '送迎選択を更新しました。',
        ]);
    }
}