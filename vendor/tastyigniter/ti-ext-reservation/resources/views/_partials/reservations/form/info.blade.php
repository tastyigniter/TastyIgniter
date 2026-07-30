<div class="d-flex">
    <div class="mr-3 flex-fill">
        <label class="form-label">
            @lang('igniter.reservation::default.label_reservation_id')
        </label>
        <h3>#{{ $formModel->reservation_id }}</h3>
    </div>
    <div class="mr-3 flex-fill text-center">
        <label class="form-label">
            @lang('igniter.reservation::default.label_reservation_date_time')
        </label>
        <h3>
            {{ $formModel->reservation_date_time->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
        </h3>
    </div>
</div>
