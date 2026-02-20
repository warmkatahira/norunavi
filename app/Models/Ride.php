<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends BaseModel
{
    // 主キーカラムを変更
    protected $primaryKey = 'ride_id';
    // 操作可能なカラムを定義
    protected $fillable = [
        'route_type_id',
        'vehicle_category_id',
        'schedule_date',
        'route_name',
        'driver_user_no',
        'use_vehicle_id',
        'ride_memo',
        'is_active',
    ];
    // 有効なレコードを取得
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    // 運行状況の文字列を返すアクセサ
    public function getIsActiveTextAttribute()
    {
        return $this->is_active ? '運行決定' : '運行未定';
    }
    // route_typesテーブルとのリレーション
    public function route_type()
    {
        return $this->belongsTo(RouteType::class, 'route_type_id', 'route_type_id');
    }
    // vehicle_categoriesテーブルとのリレーション
    public function vehicle_category()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id', 'vehicle_category_id');
    }
    // vehiclesテーブルとのリレーション
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'use_vehicle_id', 'vehicle_id');
    }
    // usersテーブルとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'driver_user_no', 'user_no');
    }
    // ride_detailsテーブルとのリレーション
    public function ride_details()
    {
        return $this->hasMany(RideDetail::class, 'ride_id', 'ride_id');
    }
    // ride_driver_candidatesテーブルとのリレーション(全て)
    public function ride_driver_candidates()
    {
        return $this->hasMany(RideDriverCandidate::class, 'ride_id', 'ride_id');
    }
    // ride_driver_candidatesテーブルとのリレーション(確定したドライバーのみを取得)
    public function confirmed_driver_candidates()
    {
        return $this->hasMany(RideDriverCandidate::class, 'ride_id', 'ride_id')
                    ->where('driver_status_id', 2);
    }
    // ダウンロード時のヘッダーを定義
    public static function downloadHeader()
    {
        return [
            '運行状況',
            'ルート区分',
            'ルート名',
            '送迎日',
            'ドライバー',
            '車両種別',
            '使用車両',
            '送迎メモ',
            '最終更新日時',
            '場所名',
            '場所メモ',
            '停車順番',
            '着　→　発',
            '次の地点まで',
            '利用者数',
            '利用者',
        ];
    }
}
