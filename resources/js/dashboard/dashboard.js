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
                $('#ride_schedule_select_table').remove();
                // テーブル作成
                let $table = $('<table id="ride_schedule_select_table" class="text-sm w-full"></table>');
                // thead作成
                let $thead = $('<thead></thead>');
                let $tr = $('<tr class="text-left text-white bg-black whitespace-nowrap sticky top-0"></tr>');
                // tr作成
                $tr.append('<th class="font-thin py-1 px-2 text-center">選択</th>');
                $tr.append('<th class="font-thin py-1 px-2 text-center">場所名</th>');
                $tr.append('<th class="font-thin py-1 px-2 text-center">場所メモ</th>');
                $tr.append('<th class="font-thin py-1 px-2 text-center">停車順番</th>');
                $tr.append('<th class="font-thin py-1 px-2 text-center">着　→　発</th>');
                // 追加
                $thead.append($tr);
                $table.append($thead);
                // tbody作成
                let $tbody = $('<tbody class="bg-white"></tbody>');
                // ride_details をループ
                data['ride_details'].forEach(function(ride_detail){
                    // 出発・到着時刻の情報取得
                    let timeHtml = get_arr_dep_info(ride_detail);
                    let $tr = $('<tr></tr>');
                    // 選択できるかを判定する変数を宣言
                    let canSelect;
                    if(route_type_id === 1){
                        // 乗車 → 出発時刻があるか
                        canSelect = !!ride_detail.departure_time;
                    }else if(route_type_id === 2){
                        // 降車 → 到着時刻があるか
                        canSelect = !!ride_detail.arrival_time;
                    }else{
                        canSelect = false;
                    }
                    // 出発時刻がある場合は、ラジオボタンを表示
                    if(canSelect){
                        // チェックするかどうかを判定
                        let isChecked = (ride_detail.ride_detail_id === join_ride_detail_id) ? 'checked' : '';
                        $tr.append(`<td class="py-1 px-2 border text-center"><label class="inline-flex items-center justify-center cursor-pointer p-2 rounded hover:bg-gray-100"><input type="radio" name="ride_detail_id" value="${ride_detail.ride_detail_id}" ${isChecked} class="ride-detail-radio w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer"><span class="sr-only">選択</span></label></td>`);
                    }else{
                        $tr.append(`<td class="py-1 px-2 border text-center"><label class="inline-flex items-center justify-center p-2 rounded"><input type="radio" disabled class="w-5 h-5 border-gray-200 opacity-0"></label></td>`);
                    }
                    $tr.append('<td class="py-1 px-2 border">' + ride_detail.location_name + '</td>');
                    $tr.append('<td class="py-1 px-2 border">' + (ride_detail.location_memo ?? '') + '</td>');
                    $tr.append('<td class="py-1 px-2 border text-right">' + (ride_detail.stop_order ?? '') + '</td>');
                    $tr.append('<td class="py-1 px-2 border text-center">' + (timeHtml) + '</td>');
                    $tbody.append($tr);
                });
                $table.append($tbody);
                // 表示する場所に追加
                $('#ride_schedule_select_div').append($table);
                // changeイベントを強制発火
                $('.ride-detail-radio:checked').trigger('change');
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

// ラジオ変更時
$(document).on('change', '.ride-detail-radio', function() {
    // まず全行の色をリセット
    $('#ride_schedule_select_table tbody tr').removeClass('bg-yellow-200');
    // チェックされたラジオの親trを黄色に
    if($(this).is(':checked')){
        $(this).closest('tr').addClass('bg-yellow-200');
    }
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