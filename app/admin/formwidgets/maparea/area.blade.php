<div
    id="{{ $this->getId('area-'.$area->area_id) }}"
    class="map-area card bg-light shadow-sm mb-2"
    data-control="area"
    data-area-id="{{ $area->area_id }}"
>
    <div
        class="card-body"
        role="tab"
        id="{{ $this->getId('area-header-'.$area->area_id) }}"
    >
        <div class="d-flex w-100 justify-content-between">
            <div class="align-self-center mr-3">
                 <span
                     class="badge"
                     style="background-color:{{ $area->color }}"
                 >&nbsp;</span>
            </div>
            <div
                class="flex-fill align-self-center"
                data-control="load-area"
                data-handler="{{ $this->getEventHandler('onLoadArea') }}"
                role="button"
            ><b>{{ $area->name }}</b></div>
            <div class="align-self-center ml-auto">
                <a
                    class="close text-danger"
                    aria-label="Remove"
                    role="button"
                    @unless ($this->previewMode)
                    data-control="remove-area"
                    data-confirm-message="@lang('admin::lang.alert_warning_confirm')"
                    @endunless
                ><i class="fa fa-trash-alt"></i></a>
            </div>
        </div>
    </div>
</div>
