<x-igniter-orange::forms.form id="picker-form" wire:submit="onSave">
    <div class="form-row align-items-center progress-indicator-container">
        <div
            wire:ignore
            class="col-md-8 pr-md-4"
        >
            <input
                wire:model="date"
                type="text"
                name="date"
                class="d-none"
                data-control="datepicker"
                data-inline="true"
                data-static="true"
                x-on:change="$wire.$refresh()"
            />
        </div>
        <div class="col-md-4" id="ti-datepicker-options">
            <div class="form-group">
                <div @class(['form-floating', 'is-invalid' => has_form_error('guest')])>
                    @include('igniter-orange::includes.booking.input-guest')
                    <label for="noOfGuests">@lang('igniter.reservation::default.label_guest_num')</label>
                </div>
                <x-igniter-orange::forms.error field="guest" class="text-danger"/>
            </div>
            @unless($hideTimePicker)
                <div class="form-group">
                    <div @class(['form-floating', 'is-invalid' => has_form_error('time')])>
                        @include('igniter-orange::includes.booking.input-time')
                        <label for="time">@lang('igniter.reservation::default.label_time')</label>
                    </div>
                    <x-igniter-orange::forms.error field="time" class="text-danger"/>
                </div>
            @endunless
            <div class="form-group">
                <button
                    type="submit"
                    @class(['btn btn-primary btn-lg w-100'])
                >@lang('igniter.reservation::default.button_find_table')</button>

                <x-igniter-orange::forms.error field="date" class="text-danger"/>
            </div>
        </div>
    </div>
</x-igniter-orange::forms.form>
