@if ($showAsapOption ?? true)
    <div class="form-check py-2 border-bottom">
        <input
            wire:model="isAsap"
            type="radio"
            name="isAsap"
            id="isAsap"
            class="form-check-input"
            value="1"
            @checked($isAsap)
            @disabled($previewMode)
        />
        <label
            class="form-check-label text-wrap ms-2 d-block"
            for="isAsap"
        >@lang('igniter.local::default.text_asap')</label>
    </div>
@endif
@if ($showLaterOption ?? true)
    <div class="form-check py-2">
        <input
            wire:model="isAsap"
            type="radio"
            name="isAsap"
            id="isLater"
            class="form-check-input"
            value="0"
            @checked(!$isAsap)
            @disabled($previewMode)
        />
        <label
            class="form-check-label text-wrap ms-2 d-block"
            for="isLater"
        >@lang('igniter.local::default.text_later')</label>
    </div>
@endif
<div x-cloak x-show="showTimePicker">
    <div class="row gx-3 mt-2 mx-4 mb-3">
        <div class="col">
            <div class="form-floating">
                <select
                    wire:model="orderDate"
                    name="orderDate"
                    class="form-select"
                >
                    <option disabled></option>
                    @foreach($timeslotDates as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                <label for="orderDate">@lang('igniter.local::default.label_date')</label>
            </div>
        </div>
        <div class="col">
            <div class="form-floating">
                <select
                    wire:model="orderTime"
                    x-model="orderTime"
                    name="orderTime"
                    class="form-select"
                >
                    <template x-for="value, key in timeslot[orderDate]" :key="key">
                        <option x-bind:value="key" x-bind:selected="key == orderTime" x-text="value"></option>
                    </template>
                </select>
                <label for="orderTime">@lang('igniter.local::default.label_time')</label>
            </div>
        </div>
    </div>
</div>
