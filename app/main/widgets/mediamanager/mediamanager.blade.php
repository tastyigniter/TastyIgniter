<div
    class="media-manager"
    data-control="media-manager"
    data-alias="{{ $this->alias }}"
    data-max-upload-size="{{ $maxUploadSize }}"
    data-allowed-extensions='@json($allowedExtensions)'
    data-select-mode="{{ $selectMode }}"
    data-unique-id="{{ $this->getId() }}"
>
    <div id="{{ $this->getId('toolbar') }}" class="media-toolbar">
        {!! $this->makePartial('mediamanager/toolbar') !!}
    </div>

    <div id="notification"></div>

    <div class="media-container">
        <div class="row no-gutters">
            <div
                class="col-9 border-right wrap-none wrap-left"
                data-control="media-list"
            >
                <div id="{{ $this->getId('breadcrumb') }}" class="media-breadcrumb border-bottom">
                    {!! $this->makePartial('mediamanager/breadcrumb') !!}
                </div>

                <div id="{{ $this->getId('item-list') }}" class="media-list-container">
                    @if ($this->getSetting('uploads'))
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
