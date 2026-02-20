<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// モデル
use App\Models\DriverStatus;

class DriverStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DriverStatus::create([
            'driver_status'     => '手上げ中',
            'sort_order'        => 1,
        ]);
        DriverStatus::create([
            'driver_status'     => '確定',
            'sort_order'        => 2,
        ]);
        DriverStatus::create([
            'driver_status'     => '管理者却下',
            'sort_order'        => 3,
        ]);
        DriverStatus::create([
            'driver_status'     => '本人辞退',
            'sort_order'        => 4,
        ]);
    }
}