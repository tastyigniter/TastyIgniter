<x-igniter-orange::forms.form id="picker-inline-form" wire:submit="onSave">
    <div class="form-row align-items-center progress-indicator-container">
        <div class="col-sm-2 mb-3">
            <label
                class="sr-only"
                for="noOfGuests"
            >@lang('igniter.reservation::default.label_guest_num')</label>
            @include('igniter-orange::includes.booking.input-guest')
        </div>
        <div class="col-sm-3 mb-3">
            <label
                class="sr-only"
                for="date"
            >@lang('igniter.reservation::default.label_date')</label>
            @include('igniter-orange::includes.booking.input-date')
        </div>
        <div class="col-sm-2 mb-3">
            <label
                class="sr-only"
                for="time"
            >@lang('igniter.reservation::default.label_time')</label>
            @include('igniter-orange::includes.booking.input-time')
        </div>
        <div class="col-sm-2 mb-3">
            <button
                type="submit"
                class="btn btn-primary w-100"
            >@lang('igniter.reservation::default.button_find_table')</button>
        </div>
    </div>
    <div class="form-row">
        <div class="col">
            <x-igniter-orange::forms.error field="date" class="text-danger"/>
            <x-igniter-orange::forms.error field="guest" class="text-danger"/>
            <x-igniter-orange::forms.error field="time" class="text-danger"/>
        </div>
    </div>
</x-igniter-orange::forms.form>
