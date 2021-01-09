<span
    class="label {{ $value ? 'label-default' : '' }}"
    style="background-color: {{ $record->status_color }};"
>{{ $value ?? lang('admin::lang.text_incomplete') }}</span>
