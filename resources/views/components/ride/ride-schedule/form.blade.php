<div class="flex flex-col gap-3">
    <div class="flex flex-col gap-3 bg-white p-3 border border-gray-400">
        <x-ride.ride-schedule.info-div label="ルート区分" :value="$form_mode === 'update' ? $ride->route_type->route_type : $route->route_type->route_type" />
        <x-ride.ride-schedule.info-div label="車両種別" :value="$form_mode === 'update' ? $ride->vehicle_category->vehicle_category : $route->vehicle_category->vehicle_category" />
        <x-ride.ride-schedule.info-div label="乗降場所数" :value="$form_mode === 'update' ? $ride->ride_details->count() : $route->route_details->count()" />
    </div>
    <form method="POST"
        action="{{ $form_mode === 'create'
                        ? route('ride_schedule_create.create')
                        : route('ride_schedule_update.update') }}"
        id="ride_schedule_form">
        @csrf
        <div class="flex flex-col border border-gray-400 divide-y divide-gray-400">
            <x-form.select label="送迎ステータス" id="ride_status_id" name="ride_status_id" :value="$form_mode === 'update' ? $ride->ride_status_id : null" :items="$ride_statuses" optionValue="ride_status_id" optionText="ride_status" required="true" />
            <x-form.input type="text" label="ルート名" id="route_name" name="route_name" :value="$form_mode === 'update' ? $ride->route_name : $route->route_name" required="true" />
            <x-form.input type="text" label="送迎日" id="schedule_date" name="schedule_date" :value="$form_mode === 'update' ? $ride->schedule_date : null" dateMultiple="{{ $form_mode === 'create' ? 'true' : 'false' }}" required="true" />
            <x-form.input type="text" label="送迎メモ" id="ride_memo" name="ride_memo" :value="$form_mode === 'update' ? $ride->ride_memo : null" />
        </div>
        @if($form_mode === 'update')
            <input type="hidden" name="ride_id" value="{{ $ride->ride_id }}">
        @endif
        @if($form_mode === 'create')
            <input type="hidden" name="route_id" value="{{ $route->route_id }}">
        @endif
        <button type="button" id="ride_schedule_{{ $form_mode }}_enter" class="btn bg-btn-enter p-3 text-white w-56 ml-auto mt-3"><i class="las la-check la-lg mr-1"></i>{{ $form_mode === 'create' ? '追加' : '更新' }}</button>
    </form>
</div>