<li
  id="{{ $this->getId() }}"
  class="nav-item dropdown"
>
  <a href="#" class="nav-link" data-bs-toggle="dropdown">
    <img
      class="rounded-circle"
      src="{{ $avatarUrl.'&s=64' }}"
      alt="User Image"
    >
  </a>
  <div class="dropdown-menu dropdown-menu-end">
    <div class="d-flex flex-column w-100 align-items-center">
      <div class="pt-4 px-4 pb-2">
        <img class="rounded-circle" src="{{ $avatarUrl.'&s=64' }}" alt="">
      </div>
      <div class="pb-3 text-center">
        <div class="h5 mb-0">{{ $userName }}</div>
        <div class="text-muted small">{{ $roleName }}</div>
        <button
          @class([
            'btn btn-sm mt-2 px-3 rounded-4',
            'btn-outline-success' => $userIsOnline,
            'btn-outline-danger' => $userIsAway && !$userIsIdle,
            'btn-outline-warning' => $userIsIdle
          ])
          data-toggle="record-editor"
          data-handler="{{ $this->getEventHandler('onLoadStatusForm') }}"
        >
          <i @class([
            'fa fa-circle fa-fw',
          ])></i>
          {{ lang($userStatusName ?: 'igniter::admin.text_set_status') }}
        </button>
      </div>
    </div>
    <div role="separator" class="dropdown-divider"></div>
    @foreach($links as $item)
      <a class="dropdown-item {{ $item->cssClass }}" {!! $item->attributes !!}>
        <i class="{{ $item->iconCssClass }}"></i><span>@lang($item->label)</span>
      </a>
    @endforeach
  </div>
</li>
