// クリックイベント
$(document).on('click', function(e){
    // クリックされた要素にモーダルを閉じるクラス名が設定されていれば、モーダルを閉じる
    if(e.target.classList.contains('ride_schedule_check_modal_close')){
        $('#ride_schedule_check_modal').addClass('hidden');
    }
    // モーダルを開く
    const $btn = $(e.target).closest('.ride_schedule_check_modal_open');
    if($btn.length){
        // ルート区分IDを取得
        const route_type_id = $btn.data('route-type-id');
        // 送迎IDを取得
        const ride_id = $btn.data('ride-id');
        // 参加している送迎詳細IDを取得
        const join_ride_detail_id = $btn.data('join-ride-detail-id');
        // 送迎予定の選択肢を作成
        create_ride_schedule_check(route_type_id, ride_id, join_ride_detail_id);
        // 送迎IDを更新
        $('#ride_id').val(ride_id);
    }
});

// 送迎予定の選択肢を作成
function create_ride_schedule_check(route_type_id, ride_id, join_ride_detail_id){
    // AJAX通信のURLをセット
    const ajax_url = '/ajax/get_ride_schedule_select_info';
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'GET',
        data: {
            ride_id: ride_id,
        },
        dataType: 'json',
        success: function(data){
            try {
                // まず既存のテーブルをクリア
                $('#ride_schedule_check_div').empty();
                /*
                =========================
                    PC用テーブル作成
                =========================
                */

                let $tableWrapper = $('<div class="hidden md:block overflow-x-auto w-full"></div>');
                let scheduleHtml = `<div class="mb-3 text-xl"><i class="las la-calendar la-lg mr-1"></i>${data['schedule_date']}</div>`;
                let rideMemoHtml = `<div class="mb-3 text-base"><i class="las la-comment la-lg mr-1"></i>${data['ride']['ride_memo']}</div>`;
                let $schedule_date_pc = $(scheduleHtml);
                let $schedule_date_sp = $(scheduleHtml);
                let $ride_memo_pc = $(rideMemoHtml);
                let $ride_memo_sp = $(rideMemoHtml);
                let $table = $('<table class="text-sm w-full border-collapse"></table>');

                let $thead = $(`
                    <thead>
                        <tr class="text-left text-white bg-black whitespace-nowrap sticky top-0">
                            <th class="py-1 px-2 font-thin text-center">場所名</th>
                            <th class="py-1 px-2 font-thin text-center">場所メモ</th>
                            <th class="py-1 px-2 font-thin text-center">停車順番</th>
                            <th class="py-1 px-2 font-thin text-center">着 → 発</th>
                            <th class="py-1 px-2 font-thin text-center">利用者</th>
                        </tr>
                    </thead>
                `);
                // tbody作成
                let $tbody = $('<tbody class="bg-white"></tbody>');
                /*
                =========================
                    SP用カードエリア
                =========================
                */

                let $cardArea = $('<div class="md:hidden space-y-2 w-full"></div>');

                /*
                =========================
                    ループ処理
                =========================
                */
                
                $cardArea.append($schedule_date_sp);
                $cardArea.append($ride_memo_sp);
                data['ride_details'].forEach(function(ride_detail){
                    let timeHtml = get_arr_dep_info(ride_detail);


                    /*
                    =========================
                        PCテーブル行
                    =========================
                    */

                    // ユーザー表示HTMLを作る
                    let usersHtml = '';

                    if (ride_detail.ride_users && ride_detail.ride_users.length > 0) {

                        ride_detail.ride_users.forEach(function(ride_user){

                            usersHtml += `
                                <span class="inline-flex items-center gap-1 bg-gray-200 border border-gray-300 rounded-full px-2 py-0.5 text-xs whitespace-nowrap writing-horizontal"
                                    style="flex: 0 0 calc(12% - 0.5rem);">
                                    <span class="tippy_ride_user cursor-default text-center w-full"
                                        data-full-name="${ride_user.user.last_name}">
                                        ${ride_user.user.last_name}
                                    </span>
                                </span>
                            `;
                        });

                    }

                    let $tr = $(`
                        <tr
                            class="border hover:bg-theme-sub whitespace-nowrap">
                            <td class="py-1 px-2">${ride_detail.location_name}</td>
                            <td class="py-1 px-2">${ride_detail.location_memo ?? ''}</td>
                            <td class="py-1 px-2 text-right">${ride_detail.stop_order ?? ''}</td>
                            <td class="py-1 px-2 text-center">${timeHtml}</td>
                            <td class="py-1 px-2 text-center">
                                <div class="flex flex-row flex-wrap gap-2 justify-start">
                                    ${usersHtml}
                                </div>
                            </td>
                        </tr>
                    `);

                    $tbody.append($tr);

                    /*
                    =========================
                        SPカード
                    =========================
                    */

                    let $card = $(`
                        <div
                            class="bg-white w-full ride-card border rounded-xl p-3 shadow-sm">
                            <div class="font-semibold">
                                ${ride_detail.location_name}
                                <span class="text-sm text-gray-600">${ride_detail.location_memo ?? ''}</span>
                            </div>
                            <div class="text-sm text-center mt-2 font-medium">
                                ${timeHtml}
                            </div>
                            <div class="text-sm text-left mt-2 font-medium space-y-2">
                                ${usersHtml}
                            </div>
                        </div>
                    `);
                    
                    $cardArea.append($card);
                });


                $table.append($thead);
                $table.append($tbody);
                $tableWrapper.append($schedule_date_pc);
                $tableWrapper.append($ride_memo_pc);
                $tableWrapper.append($table);
                
                

                $('#ride_schedule_check_div').append($tableWrapper).append($cardArea);
                // モーダルを開く
                $('#ride_schedule_check_modal').removeClass('hidden');
            } catch (e) {
            }
        },
        error: function(){
            alert('失敗');
        }
    });
}

// 出発・到着時刻の情報取得
function get_arr_dep_info(ride_detail){
    // 出発時刻・到着時刻のフォーマット
    let dep = ride_detail.departure_time ? formatTime(ride_detail.departure_time) : null;
    let arr = ride_detail.arrival_time ? formatTime(ride_detail.arrival_time) : null;
    // 時刻表示のHTML
    let timeHtml = '';
    if(arr && dep){
        timeHtml = `<span class="text-orange-700 font-medium">${arr} 着</span>
                    <span class="mx-1">→</span>
                    <span class="text-blue-700 font-medium">${dep} 発</span>`;
    }else if(arr){
        timeHtml = `<span class="text-orange-700 font-medium">${arr} 着</span>`;
    }else if(dep){
        timeHtml = `<span class="text-blue-700 font-medium">${dep} 発</span>`;
    }else{
        timeHtml = `<span class="text-gray-400">—</span>`;
    }
    return timeHtml;
}

// 時刻フォーマット関数 (HH:mm)
function formatTime(timeStr){
    if(!timeStr) return null;
    // "HH:mm:ss" -> "HH:mm"
    return timeStr.split(':').slice(0,2).join(':');
}