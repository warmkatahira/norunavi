function switchTab(activeId) {
    // ① ボタンの見た目切替
    $('#my_driver_ride_schedule, #driver_recruiting_ride_schedule_').removeClass('bg-theme-main text-white').addClass('bg-white text-black');
    $('#' + activeId).removeClass('bg-white text-black').addClass('bg-theme-main text-white');
    // ② div表示切替
    $('#my_driver_ride_schedule_div, #driver_recruiting_ride_schedule_div').addClass('hidden');
    if(activeId === 'my_driver_ride_schedule'){
        $('#my_driver_ride_schedule_div').removeClass('hidden');
    }else{
        $('#driver_recruiting_ride_schedule_div').removeClass('hidden');
    }
}

// クリックイベント
$('.switch_tab').on('click', function(){
    switchTab($(this).attr('id'));
});