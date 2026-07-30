<li
    id="{{$this->getId($item->itemName)}}"
    class="nav-item">
    <a {!! $item->getAttributes()!!}>
        <i class="fa {{ $item->icon }}"></i>
        @if ($item->label)
            <span>@lang($item->label)</span>
        @endif
    </a>
</li>
