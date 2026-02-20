<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RideDriverCandidate extends BaseModel
{
    // 主キーカラムを変更
    protected $primaryKey = 'ride_driver_candidate_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'ride_id',
        'user_no',
        'use_vehicle_id',
        'driver_status_id',
    ];
    // usersテーブルとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'user_no', 'user_no');
    }
    // vehiclesテーブルとのリレーション
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'use_vehicle_id', 'vehicle_id');
    }
}
