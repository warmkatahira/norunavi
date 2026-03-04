<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// モデル
use App\Models\Vehicle;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'vehicle_type_id'       => 1,
            'vehicle_category_id'   => 1,
            'vehicle_name'          => '社用車バス',
            'vehicle_color'         => '白',
            'vehicle_number'        => '2025',
            'vehicle_capacity'      => 15,
            'vehicle_memo'          => null,
        ]);
        Vehicle::create([
            'vehicle_type_id'       => 1,
            'vehicle_category_id'   => 2,
            'vehicle_name'          => '社用車フリード',
            'vehicle_color'         => 'オレンジ',
            'vehicle_number'        => '2021',
            'vehicle_capacity'      => 5,
            'vehicle_memo'          => '本社管理',
        ]);
        Vehicle::create([
            'user_no'               => 1,
            'vehicle_type_id'       => 2,
            'vehicle_category_id'   => 2,
            'vehicle_name'          => 'フォレスター',
            'vehicle_color'         => 'シルバー',
            'vehicle_number'        => '4319',
            'vehicle_capacity'      => 2,
            'vehicle_memo'          => null,
        ]);
        Vehicle::create([
            'user_no'               => 2,
            'vehicle_type_id'       => 2,
            'vehicle_category_id'   => 2,
            'vehicle_name'          => 'プリウス',
            'vehicle_color'         => 'ブラック',
            'vehicle_number'        => '1111',
            'vehicle_capacity'      => 3,
            'vehicle_memo'          => null,
        ]);
        Vehicle::create([
            'user_no'               => 3,
            'vehicle_type_id'       => 2,
            'vehicle_category_id'   => 2,
            'vehicle_name'          => 'ステップワゴン',
            'vehicle_color'         => 'ブラック',
            'vehicle_number'        => '2222',
            'vehicle_capacity'      => 5,
            'vehicle_memo'          => null,
        ]);
        Vehicle::create([
            'vehicle_type_id'       => 1,
            'vehicle_category_id'   => 2,
            'vehicle_name'          => '社用車フリード',
            'vehicle_color'         => 'オレンジ',
            'vehicle_number'        => '2022',
            'vehicle_capacity'      => 5,
            'vehicle_memo'          => 'ロジポート管理',
        ]);
    }
}