<x-app-layout>
    @if(Auth::user()->role_id === RoleEnum::PART)
        <x-dashboard.ride-display :dates="$dates" :rides="$rides" />
    @else
        {{-- <x-dashboard.driver-display :dates="$dates" :myDriverRideSchedules="$my_driver_ride_schedules" /> --}}
        <x-dashboard.ride-display :dates="$dates" :rides="$rides" />
    @endif
</x-app-layout>
<x-dashboard.ride-schedule-select-modal />
@vite(['resources/js/dashboard/dashboard.js'])