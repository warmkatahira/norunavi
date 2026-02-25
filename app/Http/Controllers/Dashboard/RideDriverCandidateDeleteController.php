<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\RideDriverCandidate;
// その他
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RideDriverCandidateDeleteController extends Controller
{
    public function delete(Request $request)
    {
        // 削除
        $deletedCount = RideDriverCandidate::where('ride_id', $request->ride_id)
                                ->where('user_no', Auth::user()->user_no)
                                ->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}