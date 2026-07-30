<div>
    @if ($showCancelButton)
        <div class="card">
            <div class="card-body text-center">
                <button
                    class="btn btn-light text-danger"
                    wire:click="onCancel"
                    wire:loading.class="disabled"
                >@lang('igniter.reservation::default.button_cancel')</button>
                <x-igniter-orange::forms.error field="onCancel" class="text-danger text-center"/>
            </div>
        </div>
    @endif

    <div class="card">
        @if ($reservation)
            <div class="card-body p-0">
                <div class="d-flex">
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('admin::lang.column_id')</h6>
                        <span class="h4">{{ $reservation->reservation_id }}</span>
                    </div>
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('igniter.reservation::default.column_status')</h6>
                        <span
                            class="h4"
                            style="color:{{$reservation->status_color}};"
                        >{{ $reservation->status_name }}</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('igniter.reservation::default.column_date')</h6>
                        <span class="h4">
                        {{ $reservation->reserve_date->setTimeFromTimeString($reservation->reserve_time)->isoFormat(lang('system::lang.moment.date_time_format_short')) }}
                    </span>
                    </div>
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('igniter.reservation::default.column_guest')</h6>
                        <span class="h4">{{ $reservation->guest_num }}</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('igniter.reservation::default.column_table')</h6>
                        <span class="h4">{{ $reservation->tables->pluck('name')->join(', ') }}</span>
                    </div>
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('igniter.reservation::default.column_comment')</h6>
                        <span class="h4">{{ $reservation->comment }}</span>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('igniter.reservation::default.column_location')</h6>
                        <span class="h4">
                        {{ $reservation->location->location_name }}<br/>
                    </span>
                        <p class="mt-2">{{ html(format_address($reservation->location->getAddress(), false)) }}</p>
                    </div>
                    <div class="col-md-6 p-3 border">
                        <h6 class="small text-muted">@lang('igniter.reservation::default.column_customer_name')</h6>
                        <span class="h4">{{ $reservation->first_name}} {{ $reservation->last_name }}</span>
                        <p class="mt-2">{{ $reservation->email }}</p>
                        <p>{{ $reservation->telephone }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="card-body text-center" id="ti-order-status">
                No reservation found
            </div>
        @endif
    </div>
</div>
