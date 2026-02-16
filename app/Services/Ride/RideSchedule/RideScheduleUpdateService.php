<?php

namespace App\Services\Ride\RideSchedule;

// モデル
use App\Models\Ride;

class RideScheduleUpdateService
{
    // 送迎予定を更新
    public function updateRideSchedule($request)
    {
        // 送迎予定を取得
        $ride = Ride::byPk($request->ride_id)->lockForUpdate()->firstOrFail();
        // 送迎予定を更新
        $ride->update([
            'route_name'            => $request->route_name,
            'schedule_date'         => $request->schedule_date,
            'driver_user_no'        => $request->driver_user_no,
            'use_vehicle_id'        => $request->use_vehicle_id,
            'ride_memo'             => $request->ride_memo,
            'is_active'             => $request->is_active,
        ]);
    }
}