@props([
    'rideDriverCandidate',
    'vehicles',
    'driverStatuses',
])

<div class="col-span-3 flex flex-col border border-gray-400 divide-y divide-gray-400 mb-2">
    <div class="flex flex-col bg-white py-2 px-3">
        <label class="text-gray-800 py-2.5 pl-3">ドライバー</label>
        <p class="pl-3 w-full border border-gray-400 text-sm py-2.5 bg-gray-200">{{ $rideDriverCandidate->user->full_name }}</p>
    </div>
    <div class="flex flex-col bg-white py-2 px-3">
        <label class="text-gray-800 py-2.5 pl-3 relative">使用車両</label>
        <select name="use_vehicle_id[{{ $rideDriverCandidate->ride_driver_candidate_id }}]" class="w-full text-sm border border-gray-400">
            <option value=""></option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->vehicle_id }}" @selected((string)old("use_vehicle_id.{$rideDriverCandidate->ride_driver_candidate_id}", $rideDriverCandidate->use_vehicle_id) === (string)$vehicle->vehicle_id)>{{ $vehicle->vehicle_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col bg-white py-2 px-3">
        <label class="text-gray-800 py-2.5 pl-3 relative">ドライバーステータス</label>
        <div class="flex flex-wrap gap-3">
            @foreach($driverStatuses as $driver_status)
                <label class="cursor-pointer">
                    <input 
                        type="radio"
                        name="driver_status_id[{{ $rideDriverCandidate->ride_driver_candidate_id }}]"
                        value="{{ $driver_status->driver_status_id }}"
                        class="hidden peer"
                        @checked(
                            old("driver_status_id.{$rideDriverCandidate->ride_driver_candidate_id}", 
                                $rideDriverCandidate->driver_status_id
                            ) == $driver_status->driver_status_id
                        )
                    >
                    <span class="px-4 py-1 border text-sm peer-checked:bg-theme-main peer-checked:text-white peer-checked:border-theme-main hover:bg-gray-100 border-black">
                        {{ $driver_status->driver_status }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>
</div>
<input type="hidden" name="ride_driver_candidate_id[{{ $rideDriverCandidate->ride_driver_candidate_id }}]" value="{{ $rideDriverCandidate->ride_driver_candidate_id }}">