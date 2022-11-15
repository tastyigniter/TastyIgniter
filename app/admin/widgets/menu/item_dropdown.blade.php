@php
    $itemOptions = (isset($hasPartial) && $hasPartial) ? [] : $item->options();
    is_array($itemOptions) || $itemOptions = [];
@endphp
<li
    id="{{ $item->getId()}}"
    class="nav-item dropdown">
    <a {!! $item->getAttributes() !!}>
        <i class="fa {{ $item->icon }}" role="button"></i>
        @if ($item->unreadCount())
            <span class="badge {{ $item->badge }}">&nbsp;</span>
        @endif
    </a>

    <ul
        class="dropdown-menu {{ $item->optionsView }}"
        @if (strlen($item->partial)) data-request-options="{{ $item->itemName }}" @endif
    >
        @if (!strlen($item->partial))
            <li class="dropdown-header">@if ($item->label) @lang($item->label) @endif</li>
            @foreach ($itemOptions as $key => $value)
                <li><a class="menu-link" href="{{ $key }}">@lang($value)</a></li>
            @endforeach
        @else
            <li class="dropdown-header">@if ($item->label) @lang($item->label) @endif</li>
            <li
                id="{{ $item->getId($item->itemName.'-options') }}"
                class="dropdown-body">
                <p class="wrap-all text-muted text-center"><span class="ti-loading spinner-border fa-3x fa-fw"></span>
                </p>
            </li>
        @endif
        <li class="dropdown-footer">
            @if ($item->viewMoreUrl)
                <a class="text-center" href="{{ $item->viewMoreUrl }}"><i class="fa fa-ellipsis-h"></i></a>
            @endif
        </li>
    </ul>
</li>
