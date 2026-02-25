$(document).on('click', '.driver_recruiting_hands_up, .driver_recruiting_hands_down', function(){

    const $btn = $(this);
    const ride_id = $btn.data('ride-id');

    const isHandsDown = $btn.hasClass('driver_recruiting_hands_down');
    const ajax_url = isHandsDown ? '/ride_driver_candidate_delete/delete' : '/ride_driver_candidate_create/create';
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: ajax_url,
        type: 'POST',
        data: {
            ride_id: ride_id,
        },
        dataType: 'json',
        success: function(data){

            if(data.success){

                if(isHandsDown){
                    // =========================
                    // 🔽 手下げ → 手上げ
                    // =========================
                    switchToHandsUp($btn);

                } else {
                    // =========================
                    // 🔼 手上げ → 手下げ
                    // =========================
                    switchToHandsDown($btn);
                }
            }

        }
    });

});

function switchToHandsUp($btn){

    $btn
        .removeClass('driver_recruiting_hands_down bg-theme-main text-white')
        .addClass('driver_recruiting_hands_up bg-gray-300 text-black border border-black');

    // 人数 -1
    const $count = $btn.find('.hands-up-count');
    let count = parseInt($count.text());
    $count.text(Math.max(0, count - 1));

    // border部分変更
    $btn.find('.border-white')
        .removeClass('border-white group-hover:border-black')
        .addClass('border-black');

    // アイコン削除
    $btn.find('.la-star').remove();
}


function switchToHandsDown($btn){

    $btn
        .removeClass('driver_recruiting_hands_up bg-gray-300 text-black border border-black')
        .addClass('driver_recruiting_hands_down bg-theme-main text-white');

    // 人数 +1
    const $count = $btn.find('.hands-up-count');
    let count = parseInt($count.text());
    $count.text(count + 1);

    // border部分変更
    $btn.find('.border-black')
        .removeClass('border-black')
        .addClass('border-white group-hover:border-black');

    // アイコン追加（先頭に）
    $btn.find('.flex').first().prepend(
        '<i class="las la-star text-yellow-400 group-hover:text-pink-500 mr-1 relative -top-0.5"></i>'
    );
}