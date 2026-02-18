@php
    // 送迎人数を取得
    $ride_user_count = $ride->ride_details->flatMap->ride_users->count();
    // 「最初の出発時刻」を取得
    $firstDeparture = $firstDeparture = $ride->ride_details->min('departure_time');
    // ボタンの背景色を指定
    $btn_bg = 'bg-gray-300 text-black border border-black';
    $border_color = 'border-black';
    // 送迎する人がいる場合
    if($ride_user_count > 0){
        $btn_bg = 'bg-theme-main text-white';
        $border_color = 'border-white group-hover:border-black';
    }
@endphp
<button type="button" data-ride-id="{{ $ride->ride_id }}" data-route-type-id="{{ $ride->route_type_id }}" data-join-ride-detail-id="{{ $joinedRideDetail->ride_detail_id ?? '' }}" class="{{ $btn_bg }} col-span-12 xl:col-span-3 ride_schedule_check_modal_open shadow-md rounded-md py-3 pl-3 pr-5 hover:bg-theme-sub hover:text-black group">
    <div class="flex flex-row justify-start items-center">
        @if($ride_user_count > 0)
            <i class="las la-star text-yellow-400 group-hover:text-pink-500 mr-1 relative -top-0.5"></i>
        @endif
        {{ $ride->route_name }}
        @if($ride_user_count > 0)
            <span class="text-xs ml-1">{{ '('.$ride_user_count.'人)' }}</span>
        @endif
    </div>
    <div class="flex flex-row justify-start items-center mt-1 border-t {{ $border_color }} pt-1 pl-3">
        <div class="flex items-center justify-start w-full">
            <i class="las la-clock mr-1"></i>
            {{ CarbonImmutable::parse($firstDeparture)->format('H:i') . ' 発' }}
        </div>
    </div>
    @if($ride->ride_memo)
        <div class="flex flex-row justify-start items-center mt-1 border-t {{ $border_color }} pt-1 pl-3">
            <div class="flex items-center justify-start w-full">
                <i class="las la-comment mr-1"></i>
                {{ $ride->ride_memo }}
            </div>
        </div>
    @endif
</button>