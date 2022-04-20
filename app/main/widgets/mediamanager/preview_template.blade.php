<div class="info">
    <div class="btn-group">
        @if ($file['type'] === 'img')
            <button
                type="button"
                class="btn btn-default btn-preview"
                title="@lang('main::lang.media_manager.button_preview')"
                data-url="{{ $file['img_url'] }}"><i class="fa fa-eye"></i></button>
        @else
            <button
                type="button"
                class="btn btn-default btn-preview"
                title="@lang('main::lang.media_manager.button_preview')"
                disabled="disabled"
                data-url="{{ $file['img_url'] }}"><i class="fa fa-eye"></i></button>
        @endif
        @if ($rename)
            <button
                type="button"
                class="btn btn-default btn-rename"
                title="@lang('main::lang.media_manager.button_rename')"
                data-name="{{ $file['name'] }}"
                data-path="{{ $sub_folder }}"><i class="fa fa-pencil"></i></button>
        @endif
        @if ($move)
            <button
                type="button"
                class="btn btn-default btn-move"
                title="@lang('main::lang.media_manager.button_move')"><i class="fa fa-folder-open"></i></button>
        @endif
        @if ($copy)
            <button
                type="button"
                class="btn btn-default btn-copy"
                title="@lang('main::lang.media_manager.button_copy')"><i class="fa fa-clipboard"></i></button>
        @endif
        @if ($delete)
            <button
                type="button"
                class="btn btn-default btn-delete"
                title="@lang('main::lang.media_manager.button_delete')"><i class="fa fa-trash"></i></button>
        @endif
    </div>
    <ul class="get_info">
        <li class="file-name">
            <span>Name :</span>{{ $file['name'] }}
        </li>
        <li class="file-size">
            <span>@lang('main::lang.media_manager.label_size') :</span> {{ $file['size'] }}
        </li>
        <li class="file-path">
            <span>@lang('main::lang.media_manager.label_path') :</span> /{{ $sub_folder }}
        </li>
        @if ($file['type'] === 'img')
            <li class="file-url"><span>@lang('main::lang.media_manager.label_url') :</span>
                <input
                    type="text"
                    class="form-control url-control"
                    readonly="readonly"
                    value="{{ $file['img_url'] }}"
                />
            </li>
            <li class="img-dimension">
                <span>@lang('main::lang.media_manager.label_dimension') :</span> {{ $file['img_dimension'] }}
            </li>
        @endif
        <li class="file-date">
            <span>@lang('main::lang.media_manager.label_modified_date') :</span> {{ $file['date'] }}
        </li>
        <li class="file-extension">
            <span>@lang('main::lang.media_manager.label_extension') :</span><em class="text-uppercase">{{ $file['ext'] }}</em>
        </li>
        <li class="file-permission">
            <span>@lang('main::lang.media_manager.label_permission') :</span>
            @if ($file['perms'] === '04' || $file['perms'] === '05')
                @lang('main::lang.media_manager.text_read_only')
            @elseif ($file['perms'] === '06' || $file['perms'] === '07')
                @lang('main::lang.media_manager.text_read_write')
            @else
                @lang('main::lang.media_manager.text_no_access')
            @endif
        </li>
    </ul>
</div>
