<div class="flex flex-col gap-3">
    @foreach($dates as $date)
        <div class="border p-3 mb-2 bg-white shadow-md rounded-md">
            <div class="font-bold text-base">{{ CarbonImmutable::parse($date)->isoFormat('YYYY年MM月DD日(ddd)') }}</div>
            @if(isset($rides[$date->toDateString()]))
                <div>
                    <span class="text-base font-semibold block my-2">行き</span>
                    <div class="grid grid-cols-12 pl-3 gap-5">
                        @foreach($rides[$date->toDateString()]->where('route_type_id', RouteTypeEnum::IKI) as $ride)
                            <x-dashboard.ride-schedule :ride="$ride" />
                        @endforeach
                    </div>
                </div>
                <div>
                    <span class="text-base font-semibold block my-2">帰り</span>
                    <div class="grid grid-cols-12 pl-3 gap-5">
                        @foreach($rides[$date->toDateString()]->where('route_type_id', RouteTypeEnum::KAERI) as $ride)
                            <x-dashboard.ride-schedule :ride="$ride" />
                        @endforeach
                    </div>
                </div>
            @else
                <div class="grid grid-cols-12 text-gray-400 text-sm p-3">
                    <span class="col-span-12 xl:col-span-3 text-center rounded-md py-3 pl-3 pr-5 bg-black text-white">送迎予定なし</span>
                </div>
            @endif
        </div>
    @endforeach
</div>