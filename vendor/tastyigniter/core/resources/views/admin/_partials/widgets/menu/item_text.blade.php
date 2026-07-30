<li
  id="{{$this->getId($item->itemName)}}"
  class="nav-item"
>
    <div {!! $item->getAttributes()!!}>
        <i class="fa {{ $item->icon }}"></i>
        <span class="text-nowrap hidden-xs"><strong>{{ $item->label }}</strong></span>
    </div>
</li>
