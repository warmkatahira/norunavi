<div id="ride_schedule_select_modal" class="ride_schedule_select_modal_close hidden fixed z-50 inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto shadow-lg rounded-md w-modal-window">
        <div class="flex justify-between items-center bg-theme-main text-white rounded-t-md px-4 py-2">
            <p id="ride_schedule_select_modal_title">タイトル</p>
        </div>
        <div class="p-5 bg-theme-body">
            <form method="POST" action="{{ route('ride_schedule_select_update.update') }}" id="ride_schedule_select_form">
                @csrf
                <div id="ride_schedule_select_div" class="flex flex-row"></div>
                <div class="flex justify-between mt-5">
                    <button type="button" id="ride_schedule_select_enter" class="btn bg-btn-enter p-3 text-white w-56" data-item-id=""><i class="las la-check la-lg mr-1"></i>確定</button>
                    <button type="button" class="ride_schedule_select_modal_close btn bg-btn-cancel p-3 text-white w-56"><i class="las la-times la-lg mr-1"></i>閉じる</button>
                </div>
                <input type="hidden" id="ride_id" name="ride_id">
            </form>
        </div>
    </div>
</div>