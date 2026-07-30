<div
    class=""
    data-control="dashboard-container"
    data-alias="{{ $this->alias }}"
    data-sortable-container="#{{ $this->getId('container-list') }}"
    data-date-range-format="{{ $dateRangeFormat }}"
>
    <div
        id="{{ $this->getId('container-toolbar') }}"
        class="toolbar dashboard-toolbar btn-toolbar"
        data-container-toolbar>
        {!! $this->makePartial('widget_toolbar') !!}
    </div>

    <div class="dashboard-widgets page-x-spacer">
        <div class="progress-indicator vh-100 d-flex flex-column">
            <div class="align-self-center text-center m-auto">
                <img
                    class="logo-svg"
                    src="{{$site_logo !== 'no_photo.png' ? media_url($site_logo) : asset('vendor/igniter/images/favicon.svg')}}"
                    alt="{{$site_name}}"
                    style="width: 256px;height: 256px;"
                />
                <br>
                <span class="spinner-border"></span>&nbsp;&nbsp;@lang('igniter::admin.text_loading')
            </div>
        </div>
        <div id="{{ $this->getId('container') }}"></div>
    </div>
</div>
