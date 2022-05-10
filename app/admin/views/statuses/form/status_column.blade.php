@empty($value)
    <span
        class="label {{ $value ? 'label-default' : '' }}"
        style="background-color: {{ $record->status_color }};"
    >{{ $value ?? lang('admin::lang.text_incomplete') }}</span>
@else
    <div class="dropdown">
        <button
            class="btn font-weight-bold p-0 dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            style="border-bottom: 1px dashed;color: {{ $record->status_color }};"
        >{{ $value ?? lang('admin::lang.text_incomplete') }}</button>
        <div class="dropdown-menu">
            @foreach ($statusesOptions as $index => $value)
                @continue($record->status_id == $index)
                <a
                    class="dropdown-item"
                    data-request="onUpdateStatus"
                    data-request-data="recordId: '{{ $record->getKey() }}', statusId: '{{ $index }}'"
                >{{ $value }}</a>
            @endforeach
        </div>
    </div>
@endempty
