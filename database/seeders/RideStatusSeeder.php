<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// モデル
use App\Models\RideStatus;

class RideStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RideStatus::create([
            'ride_status'   => '下書き',
            'sort_order'    => 1,
        ]);
        RideStatus::create([
            'ride_status'   => '募集中',
            'sort_order'    => 2,
        ]);
        RideStatus::create([
            'ride_status'   => '締め切り',
            'sort_order'    => 3,
        ]);
        RideStatus::create([
            'ride_status'   => '中止',
            'sort_order'    => 4,
        ]);
    }
}