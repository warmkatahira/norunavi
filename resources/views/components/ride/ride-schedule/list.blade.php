<div class="disable_scrollbar flex flex-grow overflow-scroll">
    <div class="ride_schedule_list bg-white overflow-x-auto overflow-y-auto border border-gray-600">
        <table class="text-xs">
            <thead>
                <tr class="text-left text-white bg-black whitespace-nowrap sticky top-0">
                    <th class="font-thin py-1 px-2 text-center">操作</th>
                    <th class="font-thin py-1 px-2 text-center">送迎日</th>
                    <th class="font-thin py-1 px-2 text-center">送迎ステータス</th>
                    <th class="font-thin py-1 px-2 text-center">ルート区分</th>
                    <th class="font-thin py-1 px-2 text-center">ルート名</th>
                    <th class="font-thin py-1 px-2 text-center">ドライバー</th>
                    <th class="font-thin py-1 px-2 text-center">車両種別</th>
                    <th class="font-thin py-1 px-2 text-center">送迎メモ</th>
                    <th class="font-thin py-1 px-2 text-center">定員</th>
                    <th class="font-thin py-1 px-2 text-center">利用者数</th>
                    <th class="font-thin py-1 px-2 text-center">残り座席数</th>
                    <th class="font-thin py-1 px-2 text-center">最終更新日時</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($rides as $ride)
                    @php
                        // 変数を初期化
                        $seats_remaining_class = '';
                        // 総座席数を取得
                        $total_vehicle_capacity = $ride->confirmed_driver_candidates->sum(fn($candidate) => $candidate->vehicle->vehicle_capacity ?? 0);
                        // 残り座席数
                        $seats_remaining = $total_vehicle_capacity - $ride->ride_details->sum(fn($detail) => $detail->ride_users->count());
                        // 残り座席数に応じてクラスを設定
                        if($seats_remaining < 0){
                            $seats_remaining_class = 'text-red-500';
                        }elseif($seats_remaining > 0){
                            $seats_remaining_class = 'text-blue-500';
                        }else{
                            $seats_remaining_class = 'text-gray-500';
                        }
                        // 記号を取得
                        $sign = $seats_remaining > 0 ? '+' : '';
                    @endphp
                    <tr class="text-left cursor-default whitespace-nowrap hover:bg-theme-sub group">
                        <td class="py-1 px-2 border">
                            <div class="flex flex-row gap-5">
                                <button type="button" class="btn ride_toggle_components_btn bg-btn-open text-white py-1 px-2">送迎詳細を表示</button>
                                <div class="dropdown-operation">
                                    <button class="dropdown-operation-btn"><i class="las la-ellipsis-v la-lg"></i></button>
                                    <div class="dropdown-operation-content">
                                        <a href="{{ route('ride_schedule_update.index', ['ride_id' => $ride->ride_id]) }}" class="dropdown-operation-content-element"><i class="las la-edit la-lg mr-1"></i>送迎予定を更新</a>
                                        <button type="button" class="dropdown-operation-content-element ride_schedule_delete_enter" data-ride-id="{{ $ride->ride_id }}"><i class="las la-trash la-lg mr-1"></i>削除</button>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-1 px-2 border text-center schedule_date">{{ CarbonImmutable::parse($ride->schedule_date)->isoFormat('YYYY年MM月DD日(ddd)') }}</td>
                        <td class="py-1 px-2 border text-center">
                            <x-list.ride-status :ride="$ride" />
                        </td>
                        <td class="py-1 px-2 border text-center">{{ $ride->route_type->route_type }}</td>
                        <td class="py-1 px-2 border text-center route_name">{{ $ride->route_name }}</td>
                        <td class="py-1 px-2 border">
                            @foreach($ride->confirmed_driver_candidates as $candidate)
                                <div>
                                    ・{{ $candidate->user->full_name }}
                                    @if($candidate->vehicle)
                                        / {{ $candidate->vehicle->vehicle_name }}
                                    @endif
                                </div>
                            @endforeach
                        </td>
                        <td class="py-1 px-2 border text-center">{{ $ride->vehicle_category->vehicle_category }}</td>
                        <td class="py-1 px-2 border">{{ $ride->ride_memo }}</td>
                        <td class="py-1 px-2 border text-right">{{ number_format($total_vehicle_capacity) }}</td>
                        <td class="py-1 px-2 border text-right">{{ number_format($ride->ride_details->sum(fn($detail) => $detail->ride_users->count())) }}</td>
                        <td class="py-1 px-2 border text-center">
                            @if($seats_remaining > 0)
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-600">
                                    余席 {{ $seats_remaining }}
                                </span>
                            @elseif($seats_remaining < 0)
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-red-100 text-red-600">
                                    超過 {{ abs($seats_remaining) }}
                                </span>
                            @else
                                <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                                    満席
                                </span>
                            @endif
                        </td>
                        <td class="py-1 px-2 border">{{ CarbonImmutable::parse($ride->updated_at)->isoFormat('YYYY年MM月DD日(ddd) HH時mm分ss秒').'('.CarbonImmutable::parse($ride->updated_at)->diffForHumans().')' }}</td>
                    </tr>
                    <tr class="ride_detail_components hidden">
                        <td colspan="11" class="p-0">
                            <div class="inline-block">
                                <table class="text-xs border border-gray-300 mb-3">
                                    <thead>
                                        <tr class="text-left bg-black text-white whitespace-nowrap">
                                            <th class="font-thin py-1 px-2 border border-black text-center">場所名</th>
                                            <th class="font-thin py-1 px-2 border border-black text-center">場所名メモ</th>
                                            <th class="font-thin py-1 px-2 border border-black text-center">停車順番</th>
                                            <th class="font-thin py-1 px-2 border border-black text-center">着 → 発</th>
                                            <th class="font-thin py-1 px-2 border border-black text-center">次の地点まで</th>
                                            <th class="font-thin py-1 px-2 border border-black text-center">利用者数</th>
                                            <th class="font-thin py-1 px-2 border border-black text-center">利用者</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach($ride->ride_details as $ride_detail)
                                            @php
                                                // 出発時刻を取得
                                                $dep = $ride_detail->departure_time ? CarbonImmutable::parse($ride_detail->departure_time)->format('H:i') : null;
                                                // 到着時刻を取得
                                                $arr = $ride_detail->arrival_time ? CarbonImmutable::parse($ride_detail->arrival_time)->format('H:i') : null;
                                            @endphp
                                            <tr class="hover:bg-theme-sub whitespace-nowrap">
                                                <td class="py-1 px-2 border border-black">{{ $ride_detail->location_name }}</td>
                                                <td class="py-1 px-2 border border-black">{{ $ride_detail->location_memo }}</td>
                                                <td class="py-1 px-2 border border-black text-right">{{ $ride_detail->stop_order }}</td>
                                                <td class="py-1 px-2 border border-black text-center">
                                                    @if($arr && $dep)
                                                        <span class="text-orange-700 font-medium">{{ $arr }} 着</span>
                                                        <span class="mx-1">→</span>
                                                        <span class="text-blue-700 font-medium">{{ $dep }} 発</span>
                                                    @elseif($arr)
                                                        <span class="text-orange-700 font-medium">{{ $arr }} 着</span>
                                                    @elseif($dep)
                                                        <span class="text-blue-700 font-medium">{{ $dep }} 発</span>
                                                    @else
                                                        <span class="text-gray-400">—</span>
                                                    @endif
                                                </td>
                                                <td class="py-1 px-2 border border-black text-center">
                                                    @if($ride_detail->required_minutes !== null)
                                                        <span class="inline-flex justify-center items-center bg-blue-100 text-blue-700 border border-blue-400 rounded px-2 py-0.5 text-xs w-12 tabular-nums">
                                                            {{ $ride_detail->required_minutes }} 分
                                                        </span>
                                                    @else
                                                        <span class="text-gray-400">—</span>
                                                    @endif
                                                </td>
                                                <td class="py-1 px-2 border border-black text-right">{{ number_format($ride_detail->ride_users->count()) }}</td>
                                                <td class="py-1 px-2 border border-black">
                                                    <div class="flex flex-row flex-wrap gap-2 justify-start">
                                                        @foreach($ride_detail->ride_users as $ride_user)
                                                            <span class="inline-flex items-center gap-1 bg-gray-200 border border-gray-300 rounded-full px-2 py-0.5 text-xs whitespace-nowrap writing-horizontal" style="flex: 0 0 calc(12% - 0.5rem);">
                                                                <span class="tippy_ride_user cursor-default text-center w-full" data-full-name="{{ $ride_user->user->full_name }}">
                                                                    {{ $ride_user->user->last_name }}
                                                                </span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<form method="POST" action="{{ route('ride_schedule_delete.delete') }}" id="ride_schedule_delete_form" class="hidden">
    @csrf
    <input type="hidden" id="ride_id" name="ride_id">
</form>