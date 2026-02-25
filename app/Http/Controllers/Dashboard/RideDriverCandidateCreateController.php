<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\RideDriverCandidate;
// 列挙
use App\Enums\DriverStatusEnum;
// その他
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RideDriverCandidateCreateController extends Controller
{
    public function create(Request $request)
    {
        // 追加
        RideDriverCandidate::create([
            'ride_id'           => $request->ride_id,
            'user_no'           => Auth::user()->user_no,
            'driver_status_id'  => DriverStatusEnum::PENNDING,
        ]);
        return response()->json([
            'success' => true,
        ]);
    }
}