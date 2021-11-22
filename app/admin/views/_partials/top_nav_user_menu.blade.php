@php
    $userPanel = \Admin\Classes\UserPanel::forUser();
@endphp
<li class="nav-item dropdown">
    <a href="#" class="nav-link" data-bs-toggle="dropdown">
        <img
            class="rounded-circle"
            src="{{ $userPanel->getAvatarUrl().'&s=64' }}"
        >
    </a>
    <div class="dropdown-menu">
        <div class="d-flex flex-column w-100 align-items-center">
            <div class="pt-4 px-4 pb-2">
                <img class="rounded-circle" src="{{ $userPanel->getAvatarUrl().'&s=64' }}">
            </div>
            <div class="pb-3 text-center">
                <div class="text-uppercase">{{ $userPanel->getUserName() }}</div>
                <div class="text-muted">{{ $userPanel->getRoleName() }}</div>
            </div>
        </div>
        <div class="px-3 pb-3">
            <form method="POST" accept-charset="UTF-8">
                <div class="input-group">
                    <div class="input-group-text{{ $userPanel->hasActiveLocation() ? ' text-info' : ' text-muted' }}">
                        <i class="fa fa-map-marker fa-fw"></i>
                    </div>
                    @if(count($userPanel->listLocations()) <= 1)
                        <input
                            type="text"
                            class="form-control-static"
                            value="{{ $userPanel->getLocationName() }}"
                        />
                    @else
                        <select
                            name="location"
                            class="form-select"
                            data-request="{{ $this->getEventHandler('onChooseLocation') }}"
                        >
                            <option value="0">@lang('admin::lang.text_all_locations')</option>
                            @foreach($userPanel->listLocations() as $location)
                                <option
                                    value="{{ $location->id }}"
                                    {{ $location->active ? 'selected="selected"' : '' }}
                                >{{ $location->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </form>
        </div>
        <div role="separator" class="dropdown-divider"></div>
        @foreach ($item->options() as $item)
            <a class="dropdown-item {{ $item->cssClass }}" {!! Html::attributes($item->attributes) !!}>
                <i class="{{ $item->iconCssClass }}"></i><span>@lang($item->label)</span>
            </a>
        @endforeach
        <div role="separator" class="dropdown-divider"></div>
        <a class="dropdown-item text-black-50" href="https://tastyigniter.com/about" target="_blank">
            <i class="fa fa-info-circle fa-fw"></i>@lang('admin::lang.text_about_tastyigniter')
        </a>
        <a class="dropdown-item text-black-50" href="https://tastyigniter.com/docs" target="_blank">
            <i class="fa fa-book fa-fw"></i>@lang('admin::lang.text_documentation')
        </a>
        <a class="dropdown-item text-black-50" href="https://forum.tastyigniter.com" target="_blank">
            <i class="fa fa-users fa-fw"></i>@lang('admin::lang.text_community_support')
        </a>
    </div>
</li>
