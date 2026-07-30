<div
    class="media-manager"
    data-control="media-manager"
    data-alias="{{ $this->alias }}"
    data-max-upload-size="{{ $maxUploadSize }}"
    data-allowed-extensions='@json($allowedExtensions)'
    data-select-mode="{{ $selectMode }}"
    data-unique-id="{{ $this->getId() }}"
>
    <div id="{{ $this->getId('toolbar') }}" class="media-toolbar p-3">
        {!! $this->makePartial('mediamanager/toolbar') !!}
    </div>

    <div id="notification"></div>

    <div class="media-container bg-white">
        <div class="row no-gutters">
            <div
                class="col-9 border-right p-0"
                data-control="media-list"
            >
                <div id="{{ $this->getId('breadcrumb') }}" class="media-breadcrumb border-bottom px-3">
                    {!! $this->makePartial('mediamanager/breadcrumb') !!}
                </div>

                <div id="{{ $this->getId('item-list') }}" class="media-list-container px-3">
                    @if ($this->getSetting('enable_uploads'))
                        {!! $this->makePartial('mediamanager/uploader') !!}
                    @endif

                    {!! $this->makePartial('mediamanager/item_list') !!}
                </div>
            </div>
            <div class="col-3">
                {!! $this->makePartial('mediamanager/sidebar') !!}
            </div>
        </div>
    </div>

    <div
        id="{{ $this->getId('statusbar') }}"
        data-control="media-statusbar">
        {!! $this->makePartial('mediamanager/statusbar') !!}
    </div>
    {!! $this->makePartial('mediamanager/forms') !!}
</div>

<div id="previewBox" style="display:none;"></div>
