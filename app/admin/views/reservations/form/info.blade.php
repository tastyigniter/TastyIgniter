<div class="d-flex">
    <div class="mr-3 flex-fill">
        <label class="form-label">
            @lang('admin::lang.reservations.label_reservation_id')
        </label>
        <h3>#{{ $formModel->reservation_id }}</h3>
    </div>
    <div class="mr-3 flex-fill text-center d-none">
        <label class="form-label">
            @lang('admin::lang.reservations.label_reservation_date_time')
        </label>
        <h3>
            {{ $formModel->reservation_date_time->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
        </h3>
    </div>
    <div class="flex-fill">
        <label class="form-label">
            @lang('admin::lang.reservations.label_table_name')
        </label>
        <div class="dropdown">
            <button
                class="btn p-0 dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            ><h3 class="d-inline-block" style="border-bottom: 2px dashed;">{{ $formModel->table_name ?: '--' }}</h3>
            </button>
            <div class="dropdown-menu">
                <div class="d-flex align-items-center">
                    <div class="ti-loading spinner-border spinner-border-sm" role="status"></div>
                    <div class="fw-bold ms-2">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</div>
