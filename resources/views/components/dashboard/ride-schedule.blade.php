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
    // 乗降車予定の送迎の場合
    if($joinedRideDetail){
        $btn_bg = 'bg-theme-main text-white ';
    }
@endphp
<button type="button" data-ride-id="{{ $ride->ride_id }}" data-route-type-id="{{ $ride->route_type_id }}" data-join-ride-detail-id="{{ $joinedRideDetail->ride_detail_id ?? '' }}" class="{{ $btn_bg }} col-span-12 xl:col-span-3 ride_schedule_select_modal_open shadow-md rounded-md py-3 pl-3 pr-5 hover:bg-theme-sub hover:text-black group">
    @if($joinedRideDetail)
        <i class="las la-star text-yellow-400 group-hover:text-pink-500 la-lg"></i>
    @endif
    {{ '【'.$ride->route_type->route_type.'】'.$ride->route_name }}
    @if($joinedRideDetail)
        @if($ride->route_type_id == RouteTypeEnum::KAERI && $firstDeparture)
            {{ '【' . CarbonImmutable::parse($firstDeparture)->format('H:i') . ' 発】' }}
            <br>
            {{ $joinedRideDetail->location_name.' 降車' }}
        @else
            {{ '【' . CarbonImmutable::parse($joinedRideDetail->departure_time)->format('H:i') . ' 発】' }}
            <br>
            {{ $joinedRideDetail->location_name.' 乗車' }}
        @endif
    @endif
</button>