<li
    id="{{ $this->getId() }}"
    class="nav-item dropdown"
    data-control="notification-list"
    data-mainmenu-item="{{$this->alias}}"
    data-mainmenu-item-handler="{{$this->getEventHandler('onDropdownOptions')}}"
>
    <a
        href="#"
        class="nav-link"
        data-bs-toggle="dropdown"
        data-bs-auto-close="outside"
        data-bs-display="static"
    >
        <i class="fa fa-bell" role="button"></i>
        <span @class([
      'badge text-bg-danger',
      'hide' => !$unreadCount,
    ])>&nbsp;</span>
    </a>
    <ul
        id="{{ $this->getId('options') }}"
        class="dropdown-menu dropdown-menu-end"
    >
        <li class="dropdown-body">
            <p class="wrap-all text-muted text-center">
                <span class="ti-loading spinner-border fa-3x fa-fw"></span>
            </p>
        </li>
    </ul>
</li>
