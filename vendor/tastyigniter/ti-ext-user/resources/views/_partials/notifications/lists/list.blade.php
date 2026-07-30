@if(count($records))
  @php
    $groupedRecords = $records->groupBy(function ($item) {
        return day_elapsed($item->created_at, false);
    });
  @endphp
  <div class="list-group list-group-flush border-0">
    @foreach($groupedRecords as $dateAdded => $notifications)
      <div class="list-group-item bg-transparent border-0 pt-3">
        <span>{{ $dateAdded }}</span>
      </div>
      <div class="list-group-item px-2">
        <div class="list-group list-group-flush">
          @foreach($notifications as $notification)
            <a
              @class(['list-group-item list-group-item-action rounded-hover', 'opacity-50' => $notification->read_at])
              href="{{ $notification->url }}"
            >
              {!! $this->makePartial('notifications.notification', ['notification' => $notification]) !!}
            </a>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
@else
  <p class="p-4 text-center">@lang('igniter.user::default.notifications.text_empty')</p>
@endif

{!! $this->makePartial('lists/list_pagination') !!}
