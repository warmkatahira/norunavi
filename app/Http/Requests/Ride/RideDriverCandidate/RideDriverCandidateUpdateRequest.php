<?php

namespace App\Http\Requests\Ride\RideDriverCandidate;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

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
        ];
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