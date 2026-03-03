@props([
    'rideDriverCandidate' => null,
    'vehicles',
    'driverStatuses',
    'drivers',
    'index' => null,
])

<div class="ride_driver_candidate_div col-span-3 flex flex-col border border-gray-400 divide-y divide-gray-400 mb-2 bg-white">
    <div class="flex flex-col bg-white py-2 px-3">
        <button id="delete_ride_driver_candidate_btn" type="button" class="btn bg-btn-cancel text-white px-2 py-0.5 ml-auto">削除</button>
        <label class="text-gray-800 py-2.5 pl-3 relative">ドライバー</label>
        <select {{ $rideDriverCandidate ? '' : 'name=user_no[]' }} class="w-full text-sm border border-gray-400 {{ $rideDriverCandidate ? 'bg-gray-200' : '' }}" {{ $rideDriverCandidate ? 'disabled' : '' }}>
            <option value=""></option>
            @foreach($drivers as $driver)
                <option value="{{ $driver->user_no }}" @selected((string)old("user_no.{$index}", $rideDriverCandidate?->user_no) === (string)$driver->user_no)>{{ $driver->full_name }}</option>
            @endforeach
        </select>
        @if($rideDriverCandidate)
            <input type="hidden" name="user_no[]" value="{{ $rideDriverCandidate?->user_no }}">
        @endif
    </div>
    <div class="flex flex-col bg-white py-2 px-3">
        <label class="text-gray-800 py-2.5 pl-3 relative">使用車両</label>
        <select name="use_vehicle_id[]" class="w-full text-sm border border-gray-400">
            <option value=""></option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->vehicle_id }}" @selected((string)old("use_vehicle_id.{$index}", $rideDriverCandidate?->use_vehicle_id) === (string)$vehicle->vehicle_id)>{{ $vehicle->vehicle_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col bg-white py-2 px-3">
        <label class="text-gray-800 py-2.5 pl-3 relative">ドライバーステータス</label>
        <select name="driver_status_id[]" class="w-full text-sm border border-gray-400">
            <option value=""></option>
            @foreach($driverStatuses as $driver_status)
                <option value="{{ $driver_status->driver_status_id }}" @selected((string)old("driver_status_id.{$index}", $rideDriverCandidate?->driver_status_id) === (string)$driver_status->driver_status_id)>{{ $driver_status->driver_status }}</option>
            @endforeach
        </select>
    </div>
    <div class="flex flex-col bg-white py-2 px-3">
        <label class="text-gray-800 py-2.5 pl-3">ドライバーメモ</label>
        <input type="text" name="driver_memo[]" class="pl-3 w-full text-sm py-2.5 border border-gray-400" value='{{ old("driver_memo.{$index}", $rideDriverCandidate?->driver_memo) }}' autocomplete="off">
    </div>
</div>