<ul
    id="{{ $this->getId() }}"
    class="navbar-nav"
    data-control="mainmenu"
    data-alias="{{ $this->alias }}"
>
    @foreach ($items as $item)
        {!! $this->renderItemElement($item) !!}
    @endforeach
</ul>
