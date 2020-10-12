<input type="hidden" data-media-type="current-folder" value="{{ $currentFolder }}"/>

@if ($items)
    {!! $this->makePartial('mediamanager/list_grid') !!}
@else
    <p>@lang('admin::lang.text_empty')</p>
@endif
