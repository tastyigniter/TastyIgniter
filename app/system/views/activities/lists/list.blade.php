@if (count($records))
    @php
    $groupedRecords = $records->groupBy(function ($item) {
        return day_elapsed($item->created_at, false);
    });
    @endphp
    <ul class="timeline">
        @foreach ($groupedRecords as $dateAdded => $activities)
            <li class="time-label">
                <span>{{ $dateAdded }}</span>
            </li>
            @foreach ($activities as $activity)
                <li class="timeline-item {{ $activity->status ? 'read' : 'unread' }}">
                    <time class="timeline-time" datetime="">
                        <span>{{ mdate('%h:%i %A', strtotime($activity->created_at)) }}</span>
                        <span>{{ time_elapsed($activity->created_at) }}</span>
                    </time>
                    <div class="timeline-icon"></div>
                    <div class="timeline-body"><a href="{{ $activity->url }}">{!! $activity->message !!}</a></div>
                </li>
            @endforeach
        @endforeach
    </ul>
@else
    <p class="p-4 text-center">@lang('system::lang.activities.text_empty')</p>
@endif

{!! $this->makePartial('lists/list_pagination') !!}
