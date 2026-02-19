@props([
    'vehicles',
])

@foreach($vehicles as $index => $vehicle)
    <div class="flex flex-col bg-white pb-2 px-3 w-full md:w-form-div">
        <div class="flex flex-row items-center mt-5 mb-2">
            <div class="text-gray-800 pl-3 w-full">{{ '登録車両 '.$index + 1 }}</div>
            <div class="flex w-full bg-white">
                <a href="{{ route('vehicle_update.index', ['from_profile' => 'true', 'vehicle_id' => $vehicle->vehicle_id]) }}" class="btn ml-auto text-xs py-1.5 px-5 text-white rounded-md bg-btn-enter">更新</a>
            </div>
        </div>
        <div class="flex flex-col border border-gray-400 text-sm pl-3 w-full">
            <x-profile.vehicle-info-div icon="la-toggle-on" label="利用可否" :value="$vehicle->is_active_text" />
            <x-profile.vehicle-info-div icon="la-car-side" label="車両名" :value="$vehicle->vehicle_name" />
            <x-profile.vehicle-info-div icon="la-palette" label="車両色" :value="$vehicle->vehicle_color" />
            <x-profile.vehicle-info-div icon="la-id-card" label="車両ナンバー" :value="$vehicle->vehicle_number" />
            <x-profile.vehicle-info-div icon="la-user-friends" label="定員" :value="$vehicle->vehicle_capacity.'人'" />
            <x-profile.vehicle-info-div icon="la-pen" label="車両メモ" :value="$vehicle->vehicle_memo ?? 'なし'" />
        </div>
    </div>
@endforeach