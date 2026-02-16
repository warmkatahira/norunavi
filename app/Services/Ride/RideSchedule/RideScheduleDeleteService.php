<?php

namespace App\Services\Ride\RideSchedule;

// モデル
use App\Models\Ride;

class RideScheduleDeleteService
{
    // 送迎予定を削除
    public function deleteRideSchedule($request)
    {
        // 送迎予定を取得
        $ride = Ride::byPk($request->ride_id)->lockForUpdate()->firstOrFail();
        // 削除
        $ride->delete();
    }
}