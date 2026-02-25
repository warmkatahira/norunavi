<?php

namespace App\Http\Requests\Ride\RideSchedule;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class RideScheduleUpdateRequest extends BaseRequest
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
            'ride_id'               => 'required|exists:rides,ride_id',
            'route_name'            => 'required|string|max:20',
            'schedule_date'         => 'required|date',
            'ride_memo'             => 'nullable|string|max:50',
            'ride_status_id'        => 'required|exists:ride_statuses,ride_status_id',
        ];
    }

    public function messages()
    {
        return parent::messages();
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'is_active'      => '運行状況',
        ]);
    }
}