import start_loading from '../loading';

// クリックイベント
$(document).on('click', function(e){
    // クリックされた要素にモーダルを閉じるクラス名が設定されていれば、モーダルを閉じる
    if(e.target.classList.contains('ride_schedule_select_modal_close')){
        $('#ride_schedule_select_modal').addClass('hidden');
    }
    // モーダルを開く
    const $btn = $(e.target).closest('.ride_schedule_select_modal_open');
    if($btn.length){
        // ルート区分IDを取得
        const route_type_id = $btn.data('route-type-id');
        // 送迎IDを取得
        const ride_id = $btn.data('ride-id');
        // 参加している送迎詳細IDを取得
        const join_ride_detail_id = $btn.data('join-ride-detail-id');
        // 送迎予定の選択肢を作成
        create_ride_schedule_select(route_type_id, ride_id, join_ride_detail_id);
        // 送迎IDを更新
        $('#ride_id').val(ride_id);
        /* // チェックボックスを全てオフにする
        $('.order_import_pattern_select').prop('checked', false);
        // 全行のハイライトを削除
        $('tbody tr').removeClass('bg-theme-sub'); */
        // モーダルを開く
        $('#ride_schedule_select_modal').removeClass('hidden');
    }
});

// 送迎予定の選択肢を作成
function create_ride_schedule_select(route_type_id, ride_id, join_ride_detail_id){
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
                // タイトルを設定
                if(route_type_id === 1){
                    $('#ride_schedule_select_modal_title').html('乗車する場所を選択して下さい');
                }else if(route_type_id === 2){
                    $('#ride_schedule_select_modal_title').html('降車する場所を選択して下さい');
                }
                // まず既存のテーブルをクリア
                $('#ride_schedule_select_div').empty();
                /*
                =========================
                    PC用テーブル作成
                =========================
                */

                let $tableWrapper = $('<div class="hidden md:block overflow-x-auto w-full"></div>');
                let $table = $('<table class="text-sm w-full border-collapse"></table>');

                let $thead = $(`
                    <thead>
                        <tr class="text-left text-white bg-black whitespace-nowrap sticky top-0">
                            <th class="py-1 px-2 text-center">場所名</th>
                            <th class="py-1 px-2 text-center">場所メモ</th>
                            <th class="py-1 px-2 text-center">停車順番</th>
                            <th class="py-1 px-2 text-center">着 → 発</th>
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

                data['ride_details'].forEach(function(ride_detail){

                    let timeHtml = get_arr_dep_info(ride_detail);

                    // 選択可能判定
                    let canSelect = false;

                    if(route_type_id === 1){
                        canSelect = !!ride_detail.departure_time;
                    }else if(route_type_id === 2){
                        canSelect = !!ride_detail.arrival_time;
                    }

                    // ラジオHTML生成
                    let radioHtml = '';
                    let isChecked = (ride_detail.ride_detail_id === join_ride_detail_id) ? 'checked' : '';

                    if(canSelect){
                        radioHtml = `
                            <input type="radio"
                                name="ride_detail_id"
                                value="${ride_detail.ride_detail_id}"
                                ${isChecked}
                                class="ride-detail-radio w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                        `;
                    }else{
                        radioHtml = `
                            <input type="radio" disabled
                                class="w-5 h-5 border-gray-200 opacity-30">
                        `;
                    }

                    /*
                    =========================
                        PCテーブル行
                    =========================
                    */

                    let selectableClass = canSelect
                            ? 'select-row hover:bg-theme-sub cursor-pointer'
                            : 'bg-gray-100 text-gray-400 cursor-not-allowed';

                    let $tr = $(`
                        <tr data-id="${ride_detail.ride_detail_id}"
                            class="${selectableClass} border hover:bg-theme-sub cursor-pointer">
                            <td class="py-1 px-2">${ride_detail.location_name}</td>
                            <td class="py-1 px-2">${ride_detail.location_memo ?? ''}</td>
                            <td class="py-1 px-2 text-right">${ride_detail.stop_order ?? ''}</td>
                            <td class="py-1 px-2 text-center">${timeHtml}</td>
                        </tr>
                    `);

                    $tbody.append($tr);

                    /*
                    =========================
                        SPカード
                    =========================
                    */

                    let cardClass = canSelect
                                        ? 'w-full select-row ride-card border rounded-xl p-3 shadow-sm hover:bg-theme-sub cursor-pointer'
                                        : 'w-full ride-card border rounded-xl p-3 shadow-sm bg-gray-100 text-gray-400 cursor-not-allowed';

                    let $card = $(`
                        <div data-id="${ride_detail.ride_detail_id}"
                            class="${cardClass}">
                            <div class="font-semibold">
                                ${ride_detail.location_name}
                                <span class="text-sm text-gray-600">${ride_detail.location_memo ?? ''}</span>
                            </div>
                            <div class="text-sm text-center mt-2 font-medium">
                                ${timeHtml}
                            </div>
                        </div>
                    `);

                    $cardArea.append($card);
                });

                $table.append($thead);
                $table.append($tbody);
                $tableWrapper.append($table);

                $('#ride_schedule_select_div')
                    .append($tableWrapper)
                    .append($cardArea);
                
                // 初期選択がある場合
                if(join_ride_detail_id){

                    $('#selected_ride_detail_id').val(join_ride_detail_id);

                    // まず全て通常状態
                    $('.select-row')
                        .removeClass('bg-theme-sub')
                        .addClass('bg-white');

                    // 選択状態
                    $(`.select-row[data-id="${join_ride_detail_id}"]`)
                        .removeClass('bg-white')
                        .addClass('bg-theme-sub');
                }
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

$(document).on('click', '.select-row', function(){

    if($(this).hasClass('cursor-not-allowed')){
        return;
    }

    let selectedId = $(this).data('id');

    $('#selected_ride_detail_id').val(selectedId);

    // 全て通常状態へ
    $('.select-row')
        .removeClass('bg-theme-sub')
        .addClass('bg-white');

    // 選択状態
    $(`.select-row[data-id="${selectedId}"]`)
        .removeClass('bg-white')
        .addClass('bg-theme-sub');
});

// 確定ボタンを押下した場合
$('#ride_schedule_select_enter').on("click",function(){
    // 処理を実行するか確認
    const result = window.confirm("選択を確定しますか？");
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result === true){
        start_loading();
        $("#ride_schedule_select_form").submit();
    }
});