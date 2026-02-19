<?php

namespace App\Http\Controllers\Admin\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// モデル
use App\Models\User;
use App\Models\VehicleType;
use App\Models\VehicleCategory;
// 列挙
use App\Enums\RoleEnum;
use App\Enums\VehicleTypeEnum;
// サービス
use App\Services\Admin\Vehicle\VehicleCreateService;
// リクエスト
use App\Http\Requests\Admin\Vehicle\VehicleCreateRequest;
// その他
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VehicleCreateController extends Controller
{
    public function index(Request $request)
    {
        // ページヘッダーをセッションに格納
        session(['page_header' => '車両追加']);
        // ドライバーユーザーを取得
        // プロフィールからの追加の場合は、自身のみを指定
        $users = User::where('is_driver_eligible', true)
                    ->when($request->from_profile ?? false, function ($query) {
                        $query->where('user_no', Auth::user()->user_no);
                    })
                    ->get();
        // 車両区分を取得
        $vehicle_types = VehicleType::ordered()
                            ->when($request->boolean('from_profile'), function ($query) {
                                $query->where('vehicle_type_id', VehicleTypeEnum::PRIVATE_CAR);
                            })
                            ->get();
        // 車両種別を取得
        $vehicle_categories = VehicleCategory::ordered()->get();
        return view('admin.vehicle.create')->with([
            'users' => $users,
            'vehicle_types' => $vehicle_types,
            'vehicle_categories' => $vehicle_categories,
            'from_profile' => isset($request->from_profile) ? true : false,
        ]);
    }

    public function create(VehicleCreateRequest $request)
    {
        try {
            DB::transaction(function () use ($request){
                // インスタンス化
                $VehicleCreateService = new VehicleCreateService;
                // 車両を追加
                $VehicleCreateService->createVehicle($request);
            });
        } catch (\Exception $e){
            return redirect()->back()->with([
                'alert_type' => 'error',
                'alert_message' => $e->getMessage(),
            ]);
        }
        return redirect(session('back_url_1'))->with([
            'alert_type' => 'success',
            'alert_message' => '車両を追加しました。',
        ]);
    }
}