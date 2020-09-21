@php
$itemOptions = $hasPartial ? [] : $item->options();
is_array($itemOptions) OR $itemOptions = [];
@endphp
<li
    id="{{ $item->getId()}}"
    class="nav-item dropdown">
    <a {{ $item->getAttributes() }}>
        <i class="fa {{ $item->icon }}" role="button"></i>
        @if ($item->unreadCount())
            <span class="badge {{ $item->badge }}">&nbsp;</span>
        @endif
    </a>

    <ul
        class="dropdown-menu {{ $item->optionsView }}"
        @if (strlen($item->partial)) data-request-options="{{ $item->itemName }}" @endif
    >
        <?php if (!strlen($item->partial)) { ?>
            <li class="dropdown-header">@if ($item->label) @lang($item->label) @endif</li>
            <?php foreach ($itemOptions as $key => $value) { ?>
                <li><a class="menu-link" href="{{ $key }}">@lang($value)</a></li>
            <?php } ?>
        <?php } else { ?>
            <li class="dropdown-header">@if ($item->label) @lang($item->label) @endif</li>
            <li
                id="{{ $item->getId($item->itemName.'-options') }}"
                class="dropdown-body">
                <p class="wrap-all text-muted text-center"><span class="ti-loading fa-3x fa-fw"></span></p>
            </li>
        <?php } ?>
        <li class="dropdown-footer">
            <?php if ($item->viewMoreUrl) { ?>
                <a class="text-center" href="{{ $item->viewMoreUrl }}"><i class="fa fa-ellipsis-h"></i></a>
            <?php } ?>
        </li>
    </ul>
</li>
