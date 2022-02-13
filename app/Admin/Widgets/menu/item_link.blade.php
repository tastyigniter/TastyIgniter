<li
    id="{{ $item->getId() }}"
    class="nav-item">
    <a {!! $item->getAttributes()!!}>
        <i class="fa {{ $item->icon }}"></i>
        @if ($item->badge)
            <span class="label {{ $item->badge }}"></span>
        @endif
        @if ($item->label)
            <span>@lang($item->label)</span>
        @endif
    </a>
</li>
