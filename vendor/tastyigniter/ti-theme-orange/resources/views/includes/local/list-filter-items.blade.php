@foreach ($filters as $key => $name)
    @php($name = is_array($name) ? $name['name'] : $name)
    <div class="form-check py-2">
        <input
            wire:model.live="{{$field}}"
            wire:loading.attr="disabled"
            name="{{$field}}"
            type="radio"
            id="customRadio{{$key}}"
            class="form-check-input"
            value="{{$key}}"
        />
        <label
            class="form-check-label w-100"
            for="customRadio{{$key}}"
        >@lang($name)</label>
    </div>
@endforeach