<?php

namespace App\Http\Requests\Ride\RideDriverCandidate;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
// 列挙
use App\Enums\DriverStatusEnum;
// モデル
use App\Models\RideDriverCandidate;

class RideDriverCandidateUpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_no.*'                     => 'required|exists:users,user_no',
            'use_vehicle_id.*'              => 'nullable|exists:vehicles,vehicle_id',
            'driver_status_id.*'            => 'required|exists:driver_statuses,driver_status_id',
            'driver_memo.*'                 => 'nullable|string|max:20',
        ];
    }

    public function withValidator($validator): void
    {
        // 確定時は車両必須
        $validator->after(function ($validator) {
            // リクエストから配列を取得
            $driverStatusIds = $this->input('driver_status_id', []);
            $useVehicleIds   = $this->input('use_vehicle_id', []);
            // 各ドライバーのステータスをインデックスごとに検証
            foreach($driverStatusIds as $index => $statusId){
                // ドライバーステータスが「確定」かつ使用車両が未指定の場合はエラー
                if((int)$statusId === DriverStatusEnum::CONFIRMED && empty($useVehicleIds[$index])){
                    $validator->errors()->add(
                        "use_vehicle_id.{$index}",
                        "ドライバーステータスが「確定」の場合、使用車両は必須です。"
                    );
                }
            }
        });
        // user_no 重複チェック
        $validator->after(function ($validator) {
            // 各情報を変数に格納
            $user_nos = $this->input('user_no', []);
            // 空除外
            $filtered = array_filter($user_nos);
            // 重複チェック
            if(count($filtered) !== count(array_unique($filtered))){
                $validator->errors()->add(
                    'user_no',
                    '同じドライバーが複数選択されています。'
                );
            }
        });
        // use_vehicle_id 重複チェック
        $validator->after(function ($validator) {
            // 各情報を変数に格納
            $use_vehicle_ids = $this->input('use_vehicle_id', []);
            // 空除外
            $filtered = array_filter($use_vehicle_ids);
            // 重複チェック
            if(count($filtered) !== count(array_unique($filtered))){
                $validator->errors()->add(
                    'user_no',
                    '同じ車両が複数選択されています。'
                );
            }
        });
    }

    public function messages()
    {
        return parent::messages();
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'use_vehicle_id.*'              => '使用車両',
            'driver_status_id.*'            => 'ドライバーステータス',
            'driver_memo.*'                 => 'ドライバーメモ',
            'user_no.*'                     => 'ドライバー',
        ]);
    }
}