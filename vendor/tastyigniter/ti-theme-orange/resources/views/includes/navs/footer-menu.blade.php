<div>
    <div class="row">
        @foreach ($menuItems as $navItem)
            <div class="col-sm-3">
                <div class="footer-links">
                    <h6 class="footer-title d-none d-sm-block">@lang($navItem->title)</h6>
                    <ul>
                        @foreach ($navItem->items as $item)
                            <li>
                                <a
                                    href="{{ $item->url }}"
                                    {!! $item->extraAttributes !!}
                                >@lang($item->title)</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</div>
