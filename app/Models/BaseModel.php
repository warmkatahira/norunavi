<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    // 主キーで検索するスコープ（共通）
    public function scopeByPk($query, $id)
    {
        return $query->whereKey($id);
    }
}