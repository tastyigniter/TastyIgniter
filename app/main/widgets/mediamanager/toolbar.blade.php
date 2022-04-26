<div class="btn-toolbar" role="toolbar">
    <div class="toolbar-action flex-fill d-lg-flex justify-content-between">
        <div class="toolbar-item pb-3 pb-lg-0">
            <div class="btn-group">
                <div
                    class="dropdown mr-2"
                    data-control="folder-tree-dropdown"
                >
                    <button
                        type="button"
                        class="btn btn-default dropdown-toggle"
                        data-bs-toggle="dropdown"
                    ><i class="fa fa-ellipsis-h"></i></button>
                    <div
                        id="{{ $this->getId('folder-tree') }}"
                        data-control="folder-tree"
                        class="dropdown-menu"
                    >{!! $this->makePartial('mediamanager/folder_tree') !!}</div>
                </div>
                <button
                    class="btn btn-default" type="button"
                    data-media-control="refresh">
                    <i class="fa fa-refresh"></i>
                </button>
            </div>

            <div class="btn-group">
                @if ($this->getSetting('uploads'))
                    <button
                        type="button" class="btn btn-primary"
                        data-media-control="upload">
                        <i class="fa fa-upload"></i>&nbsp;&nbsp;
                        @lang('main::lang.media_manager.button_upload')
                    </button>
                @endif
            </div>

            <div class="btn-group">
                @if ($this->getSetting('new_folder'))
                    <button
                        class="btn btn-default"
                        title="@lang('main::lang.media_manager.text_new_folder')"
                        data-media-control="new-folder"
                        data-swal-title="@lang('main::lang.media_manager.text_folder_name')"
                    ><i class="fa fa-folder"></i></button>
                @endif
                @if ($this->getSetting('rename'))
                    <button
                        class="btn btn-default" title="@lang('main::lang.media_manager.text_rename_folder')"
                        data-media-control="rename-folder"
                        data-swal-title="@lang('main::lang.media_manager.text_folder_name')"
                    ><i class="fa fa-pencil"></i></button>
                @endif
                @if ($this->getSetting('delete'))
                    <button
                        class="btn btn-danger"
                        title="@lang('main::lang.media_manager.text_delete_folder')"
                        data-media-control="delete-folder"
                        data-swal-confirm="@lang('admin::lang.alert_warning_confirm')"
                    ><i class="fa fa-trash"></i></button>
                @endif
            </div>
        </div>

        <div class="toolbar-item">
            <div class="input-group">
                <div class="dropdown mr-2">
                    <a class="btn btn-default dropdown-toggle" role="button" data-bs-toggle="dropdown" title="Filter">
                        <i class="fa fa-filter"></i> <i class="caret"></i>
                    </a>
                    {!! $this->makePartial('mediamanager/filters', ['filterBy', $filterBy]) !!}
                </div>

                <div class="dropdown mr-2">
                    <a class="btn btn-default dropdown-toggle" role="button" data-bs-toggle="dropdown" title="Sort">
                        @if (isset($sortBy[1]) && $sortBy[1] === 'ascending')
                            <i class="fa fa-sort-amount-asc"></i> <i class="caret"></i>
                        @else
                            <i class="fa fa-sort-amount-desc"></i> <i class="caret"></i>
                        @endif
                    </a>
                    {!! $this->makePartial('mediamanager/sorting', ['sortBy', $sortBy]) !!}
                </div>

                @unless ($isPopup)
                    <a
                        class="btn btn-default btn-options mr-2"
                        href="{{ admin_url('settings/edit/media') }}">
                        <i class="fa fa-gear"></i>
                    </a>
                @endunless
                {!! $this->makePartial('mediamanager/search') !!}
            </div>
        </div>
    </div>
</div>
