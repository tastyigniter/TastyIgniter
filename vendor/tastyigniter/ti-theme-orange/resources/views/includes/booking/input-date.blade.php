<select
    wire:model="date"
    name="date"
    id="date"
    @class(['form-select', 'is-invalid' => has_form_error('date')])
>
    @foreach ($dates as $date)
        <option
            value="{{ $date->format('Y-m-d') }}"
        >{{ $date->isoFormat(lang('system::lang.moment.date_format')) }}</option>
    @endforeach
</select>
