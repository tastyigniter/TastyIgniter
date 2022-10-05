<div>
    {{ $record->reservation_datetime->isoFormat(lang('system::lang.moment.time_format'))
        .' - '.$record->reservation_end_datetime->isoFormat(lang('system::lang.moment.time_format')) }}
</div>
<h5 class="my-1">{{ $record->customer_name }}</h5>
<div>
    <span class="badge border border-default text-wrap">{{ $record->table_name }}</span> ({{ $record->guest_num }})
</div>
