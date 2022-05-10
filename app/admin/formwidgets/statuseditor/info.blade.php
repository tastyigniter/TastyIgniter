<div class="d-flex">
    <div class="mr-3 flex-fill text-center">
        <label class="form-label">
            @lang('admin::lang.label_status')
        </label>
        <a
            class="d-flex align-items-center justify-content-center"
            role="button"
            data-editor-control="load-status"
        >
            <h3
                style="border-bottom: 2px dashed;{{ $status ? 'color: '.$status->status_color : '' }};"
            >{{ $status ? lang($status->status_name) : '--' }}</h3>
        </a>
    </div>
    <div class="mr-3 flex-fill text-center">
        <label class="form-label">
            {{ lang('admin::lang.orders.label_assign_staff') }}
        </label>
        <a
            class="d-flex align-items-center justify-content-center"
            role="button"
            data-editor-control="load-assignee"
        >
            <h3
                style="border-bottom: 2px dashed;"
            >{{ $assignee ? $assignee->staff_name : '--' }}</h3>
        </a>
    </div>
</div>
