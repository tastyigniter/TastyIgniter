<div class="modal-dialog">
    <div class="modal-content calendar-popover-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <a href="{{ admin_url('reservations/edit') }}/@{{id}}">#@{{id}}</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                @verbatim
                    <span
                            class="label label-secondary text-white"
                            style="background-color: {{status.status_color}};"
                    >{{status.status_name}}</span>
                @endverbatim
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>
                <b>@lang('igniter.reservation::default.column_table'):</b>
                @verbatim
                    {{#tables}}<em>{{name}}</em> - {{/tables}}
                    {{^tables}}No Table({{/tables}}
                @endverbatim
            </p>
            <p>
                <b>@lang('igniter.reservation::default.label_guest'):</b>
                @{{guest_num}}
            </p>
            <p>
                <b>@lang('igniter.reservation::default.label_reservation_time'):</b>
                @{{reserve_time}} - @{{reserve_end_time}}
            </p>
            <p>
                <b>@lang('igniter.reservation::default.label_customer_name'):</b>
                @{{first_name}} @{{last_name}}
            </p>
            <p>
                <b>@lang('igniter::admin.label_email'):</b>
                @{{email}}
            </p>
        </div>
    </div>
</div>