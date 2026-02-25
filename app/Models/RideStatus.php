<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RideStatus extends BaseModel
{
    // 主キーカラムを変更
    protected $primaryKey = 'ride_status_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'ride_status',
        'sort_order',
    ];
    // 並び替えて取得
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
}
