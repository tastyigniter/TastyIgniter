<div class="p-4 w-100 border border-danger border-left-0 border-right-0 text-danger">
    <h4 class="media-heading">{{ $theme->name }}</h4>
    <p class="description">@lang('igniter::system.themes.error_config_no_found')</p>
    <div class="list-action my-4">
        {!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) !!}
    </div>
</div>
