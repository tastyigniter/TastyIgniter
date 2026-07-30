<li class="dropdown-header">
    <div class="d-flex justify-content-between">
        <div class="flex-fill">@lang('igniter.user::default.notifications.text_title')</div>
        @if($notifications->isNotEmpty())
            <div>
                <a
                    class="cursor-pointer"
                    data-request="{{$this->getEventHandler('onMarkAsRead')}}"
                    title="@lang('igniter.user::default.notifications.button_mark_as_read')"
                ><i class="fa fa-check"></i></a>
            </div>
        @endif
    </div>
</li>
<ul class="menu">
    @forelse($notifications as $notification)
        <li class="menu-item{{ !$notification->read_at ? ' active' : '' }}">
            <a href="{{ $notification->url }}" class="menu-link">
                {!! $this->makePartial('notifications.notification', ['notification' => $notification]) !!}
            </a>
        </li>
        <li class="divider"></li>
    @empty
        <li class="p-3 text-center">@lang('igniter.user::default.notifications.text_empty')</li>
    @endforelse
</ul>
<li class="dropdown-footer">
    <a class="text-center" href="{{ admin_url('notifications') }}"><i class="fa fa-ellipsis-h"></i></a>
</li>
