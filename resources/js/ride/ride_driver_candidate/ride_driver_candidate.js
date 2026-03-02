import start_loading from '../../loading';

// 更新ボタンを押下した場合
$('#ride_driver_candidate_update_enter').on("click",function(){
    // 処理を実行するか確認
    const result = window.confirm("ドライバー更新を実行しますか？");
    // 「はい」が押下されたらsubmit、「いいえ」が押下されたら処理キャンセル
    if(result === true){
        start_loading();
        $("#ride_driver_candidate_form").submit();
    }
});