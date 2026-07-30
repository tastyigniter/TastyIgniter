<select
    wire:model="guest"
    name="guest"
    id="noOfGuests"
    @class(['form-select', 'is-invalid' => has_form_error('guest')])
>
    @for ($i = $minGuestSize; $i <= $maxGuestSize; $i++) {
        <option value="{{ $i }}">
            {{$i}} @lang($i > 1 ? 'igniter.reservation::default.text_people' : 'igniter.reservation::default.text_person')
        </option>
    @endfor
</select>
