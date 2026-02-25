@php
    // 「最初の出発時刻」を取得
    $firstDeparture = $firstDeparture = $ride->ride_details->min('departure_time');
    // ボタンの背景色を指定
    $btn_bg = 'bg-gray-300 text-black border border-black';
    $border_color = 'border-black';
    // 自分の送迎ドライバー候補者レコードを取得
    $myRideDriverCandidate = $ride->ride_driver_candidates->firstWhere('user_no', Auth::user()->user_no);
    // 手上げドライバー数を取得
    $hands_up_driver_count = $ride->ride_driver_candidates->count();
    // 手上げ済みの送迎の場合
    if($myRideDriverCandidate ){
        $btn_bg = 'bg-theme-main text-white';
        $border_color = 'border-white group-hover:border-black';
    }
@endphp
<button type="button" data-ride-id="{{ $ride->ride_id }}" class="{{ $btn_bg }} @if($myRideDriverCandidate) driver_recruiting_hands_down @else driver_recruiting_hands_up @endif col-span-12 xl:col-span-3 shadow-md rounded-md py-2 pl-3 pr-5 hover:bg-theme-sub hover:text-black group">
    <div class="flex flex-row justify-start items-center">
        @if($myRideDriverCandidate)
            <i class="las la-star text-yellow-400 group-hover:text-pink-500 mr-1 relative -top-0.5"></i>
        @endif
        {{ $ride->route_name }}
    </div>
    <div class="flex flex-row justify-start items-center mt-1 border-t {{ $border_color }} pt-1 pl-3">
        <div class="flex items-center justify-start w-full">
            <i class="las la-clock mr-1"></i>
            {{ CarbonImmutable::parse($firstDeparture)->format('H:i') . ' 発' }}
        </div>
    </div>
    <div class="flex flex-row justify-start items-center mt-1 border-t {{ $border_color }} pt-1 pl-3">
        <div class="flex items-center justify-start w-full">
            <i class="las la-hand-paper mr-1"></i>
            <span class="hands-up-count">
                {{ $hands_up_driver_count }}
            </span>人
        </div>
    </div>
    <div class="flex flex-row justify-start items-center mt-1 border-t {{ $border_color }} pt-1 pl-3">
        <div class="flex items-center justify-start w-full">
            <i class="las la-comment mr-1"></i>
            {{ $ride->ride_memo ?? 'なし' }}
        </div>
    </div>
</button>