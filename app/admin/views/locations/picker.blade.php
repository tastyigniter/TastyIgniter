@php
    $userPanel = \Admin\Classes\UserPanel::forUser();
@endphp
<li
    class="nav-item dropdown"
    data-control="location-picker"
>
    <a class="nav-link" href="" data-bs-toggle="dropdown">
        <i class="fa fa-location-dot" role="button"></i>
    </a>

    <ul class="dropdown-menu">
        @foreach($userPanel->listLocations() as $location)
            <li>
                <a
                    @class(['dropdown-item', 'active' => $location->active])
                    data-request="{{ $this->getEventHandler('onChooseLocation') }}"
                    @unless($location->active)data-request-data="location: '{{ $location->id }}'"@endunless
                >{{ $location->name }}</a>
            </li>
        @endforeach
    </ul>
</li>
