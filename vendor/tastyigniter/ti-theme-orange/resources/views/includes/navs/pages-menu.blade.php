<div class="card">
    <div class="nav flex-column">
        @foreach ($menuItems as $topItem)
            @foreach ($topItem->items as $item)
                <li class="nav-item">
                    <a
                        class="nav-link{{ ($item->isActive || $item->isChildActive) ? ' active fw-bold' : '' }}"
                        href="{{ $item->url }}"
                        {!! $item->extraAttributes !!}
                    >@lang($item->title)</a>
                </li>
            @endforeach
        @endforeach
    </div>
</div>
