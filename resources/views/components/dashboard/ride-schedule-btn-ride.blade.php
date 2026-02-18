@php
    // 自分が参加している ride_detail を取得
    $joinedRideDetail = $ride->ride_details
        ->firstWhere(fn ($detail) =>
            $detail->ride_users->pluck('user_no')->contains(Auth::user()->user_no)
        );
    // 帰り（route_type_id = 2）の場合は「最初の出発時刻」を取得
    $firstDeparture = null;
    if($ride->route_type_id == RouteTypeEnum::KAERI){
        $firstDeparture = $ride->ride_details->min('departure_time');
    }
    // ボタンの背景色を指定
    $btn_bg = 'bg-gray-300 text-black border border-black';
    $border_color = 'border-black';
    // 乗降車予定の送迎の場合
    if($joinedRideDetail){
        $btn_bg = 'bg-theme-main text-white';
        $border_color = 'border-white group-hover:border-black';
    }
@endphp
<button type="button" data-ride-id="{{ $ride->ride_id }}" data-route-type-id="{{ $ride->route_type_id }}" data-join-ride-detail-id="{{ $joinedRideDetail->ride_detail_id ?? '' }}" class="{{ $btn_bg }} col-span-12 xl:col-span-3 ride_schedule_select_modal_open shadow-md rounded-md py-3 pl-3 pr-5 hover:bg-theme-sub hover:text-black group">
    <div class="flex flex-row justify-start items-center">
        @if($joinedRideDetail)
            <i class="las la-star text-yellow-400 group-hover:text-pink-500 mr-1 relative -top-0.5"></i>
        @endif
        {{ $ride->route_name }}
    </div>
    @if($joinedRideDetail)
        <div class="flex flex-row justify-start items-center mt-1 border-t {{ $border_color }} pt-1 pl-3">
            @if($ride->route_type_id == RouteTypeEnum::KAERI && $firstDeparture)
                <div class="flex items-center justify-start w-1/2">
                    <i class="las la-clock mr-1"></i>
                    {{ CarbonImmutable::parse($firstDeparture)->format('H:i') . ' 発' }}
                </div>
                <div class="flex items-center justify-start w-1/2">
                    <i class="las la-map-pin mr-1 relative -top-0.7"></i>
                    {{ $joinedRideDetail->location_name.' 降車' }}
                </div>
            @else
                <div class="flex flex-row w-full">
                    <div class="flex items-center justify-start w-1/2">
                        <i class="las la-clock mr-1"></i>
                        {{ CarbonImmutable::parse($joinedRideDetail->departure_time)->format('H:i') . ' 発' }}
                    </div>
                    <div class="flex items-center justify-start w-1/2">
                        <i class="las la-map-pin mr-1 relative -top-0.7"></i>
                        {{ $joinedRideDetail->location_name.' 乗車' }}
                    </div>
                </div>
            @endif
        </div>
    @endif
    @if($ride->user)
        <div class="flex flex-row justify-start items-center mt-1 border-t {{ $border_color }} pt-1 pl-3">
            <i class="las la-car-side mr-1 relative -top-0.7"></i>{{ $ride->user->full_name .'('. $ride->vehicle?->vehicle_name . $ride->vehicle?->vehicle_number .')' }}
        </div>
    @endif
</button>