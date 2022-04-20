@php
$itemOptions = $itemOptions['items'] ?? $itemOptions;
@endphp
<ul class="menu menu-lg">
    @if (count($itemOptions))
        @foreach ($itemOptions as $activity)
            <li class="menu-item{{ $activity->isUnread() ? ' active' : '' }}">
                <a href="{{ $activity['url'] }}" class="menu-link">
                    <div class="menu-item-meta">{!! $activity['message'] !!}</div>
                    <span class="small menu-item-meta text-muted">
                        {{ mdate('%h:%i %A', strtotime($activity['created_at'])) }}&nbsp;-&nbsp;
                        {{ time_elapsed($activity['created_at']) }}
                    </span>
                </a>
            </li>
            <li class="divider"></li>
        @endforeach
    @else
        <li class="text-center">@lang('admin::lang.text_empty_activity')</li>
    @endif
</ul>
