<div class="grid grid-cols-12 gap-3 mb-2">
    <button type="button" id="my_driver_ride_schedule" class="btn switch_tab col-span-6 md:col-span-2 bg-theme-main text-white rounded-md px-5 py-2">自分の送迎</button>
    <button type="button" id="driver_recruiting_ride_schedule_" class="btn switch_tab col-span-6 md:col-span-2 bg-white text-black rounded-md px-5 py-2">手上げ可能送迎</button>
</div>
<x-dashboard.my-driver-ride-schedule :dates="$dates" :myDriverRideSchedules="$myDriverRideSchedules" />
<x-dashboard.driver-recruiting-ride-schedule :dates="$dates" :recruitingRideSchedules="$recruitingRideSchedules" />