<x-app-layout>
    @if(Auth::user()->role_id === RoleEnum::PART)
        <x-dashboard.ride-display :dates="$dates" :rides="$rides" />
    @else
        <x-dashboard.driver-display :dates="$dates" :myDriverRideSchedules="$my_driver_ride_schedules" :recruitingRideSchedules="$recruiting_ride_schedules" />
    @endif
</x-app-layout>
<x-dashboard.ride-schedule-select-modal />
<x-dashboard.ride-schedule-check-modal />
@vite(['resources/js/dashboard/ride_schedule_select.js', 'resources/js/dashboard/ride_schedule_check.js', 'resources/js/dashboard/driver_display.js', 'resources/js/dashboard/driver_recruiting.js'])