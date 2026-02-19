<?php

namespace App\Services\Admin\Vehicle;

// モデル
use App\Models\Vehicle;
use App\Models\Ride;

class VehicleUpdateService
{
    // 車両を更新
    public function updateVehicle($request)
    {
        // 車両を取得
        $vehicle = Vehicle::byPk($request->vehicle_id)->lockForUpdate()->first();
        // 利用可否が「利用不可」に更新されようとしている場合
        if($vehicle->is_active && $request->boolean('is_active') === false){
            // 今日を含む未来の送迎で使用予定があるかを取得
            $exists = Ride::where('use_vehicle_id', $vehicle->vehicle_id)
                        ->whereDate('schedule_date', '>=', now()->toDateString())
                        ->exists();
            // 使用予定がある場合
            if($exists){
                throw new \RuntimeException('使用予定の車両のため、利用不可に更新できません。');
            }
        }
        // 更新
        $vehicle->update([
            'user_no'               => $request->owner,
            'vehicle_type_id'       => $request->vehicle_type_id,
            'vehicle_category_id'   => $request->vehicle_category_id,
            'vehicle_name'          => $request->vehicle_name,
            'vehicle_color'         => $request->vehicle_color,
            'vehicle_number'        => $request->vehicle_number,
            'vehicle_capacity'      => $request->vehicle_capacity,
            'vehicle_memo'          => $request->vehicle_memo,
            'is_active'             => $request->is_active,
        ]);
    }
}