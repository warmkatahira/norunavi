<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverStatus extends BaseModel
{
    // 主キーカラムを変更
    protected $primaryKey = 'driver_status_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'driver_status',
        'sort_order',
    ];
}
