<x-app-layout>
    <x-page-back :url="session('back_url_1')" />
    <div class="flex flex-col gap-3 mt-5">
        <div class="flex flex-col gap-3 w-1/2 bg-white p-3 border border-gray-400">
            <x-admin.route-detail.info-div label="ルート区分" :value="$route->route_type->route_type" />
            <x-admin.route-detail.info-div label="車両種別" :value="$route->vehicle_category->vehicle_category" />
            <x-admin.route-detail.info-div label="ルート名" :value="$route->route_name" />
        </div>
    </div>
    <div class="flex mt-3">
        <button id="add_route_detail_btn" type="button" class="btn bg-green-600 text-white p-3 ml-left"><i class="las la-plus la-lg mr-1"></i>ルート詳細追加</button>
    </div>
    <form method="POST" action="{{ route('route_detail_update.update') }}" id="route_detail_update_form">
        @csrf
        <div id="route_detail_wrapper">
            @foreach($route->route_details as $index => $route_detail)
                <div class="route_detail_div p-5 bg-white mt-3">
                    <div class="flex justify-between items-center">
                        <p class="text-base">ルート詳細 {{ $index + 1 }}</p>
                    </div>
                    <div class="flex flex-row text-xs gap-5 mt-3">
                        <div class="flex flex-row w-10/12 gap-2">
                            <x-admin.route-detail.select label="乗降場所" name="boarding_location_id" :index="$index" :items="$boarding_locations" optionValue="boarding_location_id" optionText="location_name" :value="$route_detail->boarding_location_id" />
                            <x-admin.route-detail.input type="tel" label="停車順番" name="stop_order" :index="$index" :value="$route_detail->stop_order" />
                            <x-admin.route-detail.input type="time" label="到着時刻" name="arrival_time" :index="$index" :value="$route_detail->arrival_time ? CarbonImmutable::parse($route_detail->arrival_time)->format('H:i'): null" />
                            <x-admin.route-detail.input type="time" label="出発時刻" name="departure_time" :index="$index" :value="$route_detail->departure_time ? CarbonImmutable::parse($route_detail->departure_time)->format('H:i'): null" />
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($route->route_details->isEmpty())
                <div class="route_detail_div p-5 bg-white mt-3">
                    <div class="flex justify-between items-center">
                        <p class="text-base">ルート詳細 1</p>
                    </div>
                    <div class="flex flex-row text-xs gap-5 mt-3">
                        <div class="flex flex-row w-10/12 gap-2">
                            <x-admin.route-detail.select label="乗降場所" name="boarding_location_id" :items="$boarding_locations" optionValue="boarding_location_id" optionText="location_name" />
                            <x-admin.route-detail.input type="tel" label="停車順番" name="stop_order" />
                            <x-admin.route-detail.input type="time" label="到着時刻" name="arrival_time" />
                            <x-admin.route-detail.input type="time" label="出発時刻" name="departure_time" />
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <input type="hidden" id="route_id" name="route_id" value="{{ $route->route_id }}">
        <button type="button" id="route_detail_update_enter" class="btn bg-btn-enter p-3 text-white w-56 mt-3"><i class="las la-check la-lg mr-1"></i>更新</button>
    </form>
</x-app-layout>
@vite(['resources/js/admin/route_detail/route_detail.js'])