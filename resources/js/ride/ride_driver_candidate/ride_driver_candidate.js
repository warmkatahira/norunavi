import start_loading from '../../loading';

// 更新ボタンを押下した場合
$('#ride_driver_candidate_update_enter').on("click",function(){
    // AJAX通信のURLを定義
    const ajax_url = '/ride_driver_candidate_update/ajax_validation';
    // バリデーションで使用するデータを整理
    const data = collectValidationData();
    console.log(data);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'GET',
        data: data,
        dataType: 'json',
        success: function(data){
            // 処理を実行するか確認
            const result = window.confirm("ドライバー更新を実行しますか？");
            // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
            if(result === true){
                start_loading();
                $("#ride_driver_candidate_form").submit();
            }
        },
        error: function(xhr){
            if(xhr.status === 422){
                // バリデーションエラーを取得
                const errors = xhr.responseJSON.errors;
                // エラー情報を格納する変数を宣言
                let validation_errors = '';
                // ここで画面にエラーメッセージ表示など処理
                $.each(errors, function(index, value) {
                    // 変数にエラー情報を格納
                    validation_errors += `${value[0]}\n`;
                });
                alert(validation_errors);
            }else{
                alert('通信エラーが発生しました。');
            }
        }
    });
});

// バリデーションで使用するデータを整理
function collectValidationData()
{
    return {
        ride_id: $('#ride_id').val(),
        user_no: $("[name='user_no[]']")
            .map(function () {
                return $(this).val();
            }).get(),
        use_vehicle_id: $("select[name='use_vehicle_id[]']").map(function () {
            return $(this).val();
        }).get(),
        driver_status_id: $("select[name='driver_status_id[]']").map(function () {
            return $(this).val();
        }).get(),
        driver_memo: $("input[name='driver_memo[]']").map(function () {
            return $(this).val();
        }).get(),
    };
}

// ドライバー追加処理
$('#add_ride_driver_candidate_btn').on('click', function () {
    // 最後にあるride_driver_candidate_divを取得して複製
    const $last = $('.ride_driver_candidate_div').last();
    const $clone = $last.clone();
    /* ------------------------
       ドライバーselectを有効化
    -------------------------*/
    const $driverSelect = $clone.find('select').first();
    $driverSelect.removeClass('bg-gray-200').prop('disabled', false).attr('name', 'user_no[]').val('');
    // hidden削除（既存用なので不要）
    $clone.find('input[name^="user_no["]').remove();
    /* ------------------------
       使用車両
    -------------------------*/
    $clone.find('select[name^="use_vehicle_id"]').val('');
    /* ------------------------
       ドライバーステータス
    -------------------------*/
    $clone.find('select[name^="driver_status_id"]').val('');
    /* ------------------------
       ドライバーメモ
    -------------------------*/
    $clone.find('input[type="text"]').val('');
    /* ------------------------
       既存IDは削除
    -------------------------*/
    $clone.find('input[name^="ride_driver_candidate_id"]').remove();
    // 一番後ろに追加
    $('#ride_driver_candidate_wrapper').append($clone);
});

// 削除処理
$(document).on('click', '#delete_ride_driver_candidate_btn', function () {
    $(this).closest('.ride_driver_candidate_div').remove();
});