<?php

namespace App\Http\Requests\Ride\RideDriverCandidate;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
// 列挙
use App\Enums\DriverStatusEnum;

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
            'ride_driver_candidate_id.*'    => 'required|exists:ride_driver_candidates,ride_driver_candidate_id',
            'use_vehicle_id.*'              => 'nullable|exists:vehicles,vehicle_id',
            'driver_status_id.*'            => 'required|exists:driver_statuses,driver_status_id',
            'driver_memo.*'                 => 'nullable|string|max:20',
        ];
    }

    public function withValidator($validator): void
    {
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
    }

    public function messages()
    {
        return parent::messages();
    }

    public function attributes()
    {
        return parent::attributes();
    }
}