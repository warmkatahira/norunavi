<?php

namespace App\Services\Ride\RideDriverCandidate;

// モデル
use App\Models\Ride;
use App\Models\RideDriverCandidate;
// 列挙
use App\Enums\DriverStatusEnum;
use App\Enums\RideStatusEnum;

class RideDriverCandidateUpdateService
{
    // 既存の送迎ドライバーを削除
    public function deleteRideDriverCandidate($ride_id)
    {
        RideDriverCandidate::where('ride_id', $ride_id)->delete();
    }

    // 送迎ドライバーを追加
    public function createRideDriverCandidate($request)
    {
        // ride_idを取得
        $ride_id = $request->ride_id;
        // 送迎予定を取得
        $ride = Ride::ByPk($ride_id)->lockForUpdate()->first();
        // 各情報を変数に格納
        $user_nos = $request->input('user_no', []);
        $use_vehicle_ids = $request->input('use_vehicle_id', []);
        $driver_status_ids = $request->input('driver_status_id', []);
        $driver_memos = $request->input('driver_memo', []);
        // intに変換
        $driver_status_ids = array_map('intval', $driver_status_ids);
        // driver_status_id に 2(確定)が含まれているか
        if(in_array(DriverStatusEnum::CONFIRMED, $driver_status_ids, true)){
            // 送迎ステータスを締め切りに更新
            $ride->update([
                'ride_status_id' => RideStatusEnum::CLOSED,
            ]);
        }
        // ユーザーの分だけループ処理
        foreach($user_nos as $key => $user_no){
            // 追加
            RideDriverCandidate::create([
                'ride_id'          => $ride_id,
                'user_no'          => $user_no,
                'use_vehicle_id'   => $use_vehicle_ids[$key] ?? null,
                'driver_status_id' => $driver_status_ids[$key],
                'driver_memo'      => $driver_memos[$key] ?? null,
            ]);
        }
    }
}