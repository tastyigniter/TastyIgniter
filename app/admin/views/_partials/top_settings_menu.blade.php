@php
    $updatesCount = $item->unreadCount();
    $hasSettingsError = count(array_filter(Session::get('settings.errors', [])))
@endphp
<li class="nav-item dropdown">
    <a class="nav-link" href="" data-bs-toggle="dropdown">
        <i class="fa fa-gear" role="button"></i>
        @if($hasSettingsError)
            <span class="badge badge-danger"><i class="fa fa-exclamation text-white"></i></span>
        @elseif($updatesCount)
            <span class="badge badge-danger">&nbsp;</span>
        @endif
    </a>

    <ul class="dropdown-menu">
        <div class='menu menu-grid row'>
            @foreach ($item->options() as $label => [$icon, $link])
                <div class="menu-item col col-4">
                    <a class="menu-link" href="{{ $link }}">
                        <i class="{{ $icon }}"></i>
                        <span>@lang($label)</span>
                    </a>
                </div>
            @endforeach
        </div>
        @if(!$hasSettingsError && $updatesCount)
            <a
                class="dropdown-item border-top text-center alert-warning"
                href="{{ admin_url('updates') }}"
            >{{ sprintf(lang('system::lang.updates.text_update_found'), $updatesCount) }}</a>
        @endif
        <div class="dropdown-footer">
            <a
                class="text-center{{ $hasSettingsError ? ' text-danger' : '' }}"
                href="{{ admin_url('settings') }}"
            ><i class="fa fa-ellipsis-h"></i></a>
        </div>
    </ul>
</li>
