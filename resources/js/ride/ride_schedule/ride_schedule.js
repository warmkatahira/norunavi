import start_loading from '../../loading';

// 追加ボタンを押下した場合
$('#ride_schedule_create_enter').on("click",function(){
    // 処理を実行するか確認
    const result = window.confirm("送迎予定追加を実行しますか？");
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result === true){
        start_loading();
        $("#ride_schedule_form").submit();
    }
});

// 更新ボタンを押下した場合
$('#ride_schedule_update_enter').on("click",function(){
    // 処理を実行するか確認
    const result = window.confirm("送迎予定更新を実行しますか？");
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result === true){
        start_loading();
        $("#ride_schedule_form").submit();
    }
});

// 削除ボタンが押下されたら
$('.ride_schedule_delete_enter').on("click",function(){
    // 削除ボタンが押下された要素の親のtrタグを取得
    const tr = $(this).closest('tr');
    // 削除しようとしている要素の情報を取得
    const schedule_date = tr.find('.schedule_date').text();
    const route_name = tr.find('.route_name').text();
    try {
        // 処理を実行するか確認
        const result = window.confirm("送迎予定を削除しますか？\n\n" + "ルート名：" + route_name + "\n送迎日：" + schedule_date);
        // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
        if(result == true){
            start_loading();
            // 削除対象の送迎予定IDを要素にセット
            $('#ride_id').val($(this).data('ride-id'));
            $("#ride_schedule_delete_form").submit();
        }
    } catch (e) {
        alert(e.message);
    }
});

// flatpickr用
document.addEventListener("DOMContentLoaded", function () {
    // flatpickr を適用する要素を取得
    const el = document.querySelector("#schedule_date");
    // bladeから渡されたdata-date-multipleを取得（"true" / "false"）
    // 文字列なので、厳密に比較して真偽値に変換する
    const allowMultiple = el.dataset.dateMultiple === "true";
    // flatpickr の初期化
    flatpickr("#schedule_date", {
        // create のときは複数選択、update のときは単一選択
        mode: allowMultiple ? "multiple" : "single",
        dateFormat: "Y-m-d",
        locale: "ja",
        showMonths: 1
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // ドライバーのセレクトボックス
    const driverSelect = document.querySelector("#driver_user_no");
    // 車両のセレクトボックス
    const vehicleSelect = document.querySelector("#use_vehicle_id");
    // ドライバーが変更されたときの処理
    driverSelect.addEventListener("change", function () {
        // 現在選択されている <option> 要素を取得
        const selectedOption = this.options[this.selectedIndex];
        // 選択されたドライバーの option に仕込んだ data-vehicle を取得
        // （例: <option data-vehicle="3">）
        const vehicleId = selectedOption.dataset.vehicle;
        // ドライバーに紐づく車両がある場合は自動選択
        if(vehicleId){
            vehicleSelect.value = vehicleId;
        } 
        // 紐づく車両がない場合は車両選択をクリア
        else{
            vehicleSelect.value = "";
        }
    });
});

// 利用者のツールチップ
tippy('.tippy_ride_user', {
    content(reference) {
        const fullName = reference.getAttribute('data-full-name') + ' さん' || '';
        return fullName;
    },
    duration: 500,
    maxWidth: 'none',
    allowHTML: true,
    placement: 'right',
    theme: 'tippy_main_theme',
});