<x-app-layout>
    <x-page-back :url="session('back_url_1')" />
    <div class="mt-5">
        <div class="flex flex-col gap-3">
            <div class="flex flex-col gap-3 w-1/2 bg-white p-3 border border-gray-400">
                <x-ride.ride-schedule.info-div label="送迎日" :value="CarbonImmutable::parse($ride->ride_schedule)->isoFormat('YYYY年MM月DD日')" />
                <x-ride.ride-schedule.info-div label="送迎ステータス" :value="$ride->ride_status->ride_status" />
                <x-ride.ride-schedule.info-div label="ルート区分" :value="$ride->route_type->route_type" />
                <x-ride.ride-schedule.info-div label="ルート名" :value="$ride->route_name" />
                <x-ride.ride-schedule.info-div label="車両種別" :value="$ride->vehicle_category->vehicle_category" />
                <x-ride.ride-schedule.info-div label="乗降場所数" :value="$ride->ride_details->count()" />
            </div>
            <form method="POST" action="{{ route('ride_driver_candidate_update.update') }}" id="ride_driver_candidate_form">
                @csrf
                <div class="grid grid-cols-12 gap-3">
                    @foreach($ride->ride_driver_candidates as $ride_driver_candidate)
                        <x-ride.ride-driver-candidate.update-div :rideDriverCandidate="$ride_driver_candidate" :vehicles="$vehicles" :driverStatuses="$driver_statuses" />
                    @endforeach
                </div>
                <input type="hidden" name="ride_id" value="{{ $ride->ride_id }}">
                <button type="button" id="ride_driver_candidate_update_enter" class="btn bg-btn-enter p-3 text-white w-56 ml-auto mt-3"><i class="las la-check la-lg mr-1"></i>更新</button>
            </form>
        </div>
    </div>
</x-app-layout>
@vite(['resources/js/ride/ride_driver_candidate/ride_driver_candidate.js'])