<div class="d-flex align-items-center">
  @if($icon = $notification->icon)
    <div class="pe-4">
      <i class="fa fs-4 {{$icon}} text-{{$notification->iconColor ?? 'muted'}}"></i>
    </div>
  @endif
  <div class="flex-grow-1">
    <div class="text-truncate text-muted">{{ $notification->title }}</div>
    <div class="menu-item-meta">{!! $notification->message !!}</div>
    <span class="small menu-item-meta text-muted">
            {{ time_elapsed($notification->created_at) }}
        </span>
  </div>
</div>
