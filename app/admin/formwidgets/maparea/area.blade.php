<div
    id="{{ $this->getId('area-'.$area->area_id) }}"
    class="map-area card bg-light shadow-sm mb-2"
    data-control="area"
    data-area-id="{{ $area->area_id }}"
    data-item-index="{{ $index }}"
>
    <div
        class="card-body"
        role="tab"
        id="{{ $this->getId('area-header-'.$area->area_id) }}"
    >
        <div class="d-flex w-100 justify-content-between">
            @if (!$this->previewMode && $sortable)
                <input type="hidden" name="{{ $sortableInputName }}[]" value="{{ $area->area_id }}">
                <div class="align-self-center">
                    <a
                        class="btn handle {{ $this->getId('areas') }}-handle mt-1"
                        role="button">
                        <i class="fa fa-arrows-alt-v text-black-50"></i>
                    </a>
                </div>
            @endif
            <div class="align-self-center mr-3">
                 <span
                     class="badge"
                     style="background-color:{{ $area->color }}"
                 >&nbsp;</span>
            </div>
            <div
                class="flex-fill align-self-center mt-1"
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
