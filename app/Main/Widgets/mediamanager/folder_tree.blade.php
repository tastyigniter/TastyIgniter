<div class="folder-tree"
     data-tree-data='@json($folderTree)'>
    <button>Go to root folder</button>
</div>
<select class="hide">
    <option value="">@lang('admin::lang.text_please_select')</option>
    @foreach ($folderList as $key => $value)
        <option value="{{ $value }}">{{ $value }}</option>
    @endforeach
</select>
