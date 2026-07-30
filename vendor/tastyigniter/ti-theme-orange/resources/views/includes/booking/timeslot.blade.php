<p>
    {{ sprintf(lang('igniter.reservation::default.text_time_msg'),
        make_carbon($date.' '.$time)->isoFormat(lang('system::lang.moment.date_time_format_long')),
        $guest
    ) }}
</p>

<x-igniter-orange::forms.form id="picker-form">
    @forelse($this->reducedTimeslots as $key => $slot)
        <button
            type="button"
            wire:click="onSelectTime('{{ $slot->dateTime->format('H:i') }}')"
            @class(['btn btn-primary rounded me-3', 'disabled' => $slot->fullyBooked, 'btn-lg' => $slot->isSelected])
            id="time{{$key}}"
        >{{ $slot->dateTime->isoFormat(lang('system::lang.moment.time_format')) }}</button>
    @empty
        @lang('igniter.reservation::default.text_no_time_slot')
    @endforelse
    <div class="form-row">
        <div class="col">
            <x-igniter-orange::forms.error field="time" class="text-danger"/>
        </div>
    </div>
</x-igniter-orange::forms.form>
