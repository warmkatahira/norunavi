<?php

namespace App\Services\Ride\RideDriverCandidate;

// モデル
use App\Models\RideDriverCandidate;

class RideDriverCandidateUpdateService
{
    // 送迎ドライバーを更新
    public function updateRideDriverCandidate($request)
    {
        // 各情報を変数に格納
        $ride_driver_candidate_ids = $request->input('ride_driver_candidate_id', []);
        $use_vehicle_ids = $request->input('use_vehicle_id', []);
        $driver_status_ids = $request->input('driver_status_id', []);
        $driver_memos = $request->input('driver_memo', []);
        // 情報の分だけループ処理
        foreach($ride_driver_candidate_ids as $index => $value){
            // 送迎ドライバーを取得
            $ride_driver_candidate = RideDriverCandidate::ByPk($ride_driver_candidate_ids[$index])->lockForUpdate()->first();
            // 更新
            $ride_driver_candidate->update([
                'use_vehicle_id'    => $use_vehicle_ids[$index],
                'driver_status_id'  => $driver_status_ids[$index],
                'driver_memo'       => $driver_memos[$index],
            ]);
        }
    }
}