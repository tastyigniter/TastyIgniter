<div class="row mb-3">
    <div class="media bg-light p-4 w-100 border border-danger border-left-0 border-right-0 text-danger">
        <a
            class="media-left align-self-center mr-4 preview-thumb"
            style="width:200px;">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{{ $theme->name }}</h4>
            <p class="description">@lang('system::lang.themes.error_config_no_found')</p>
            <div class="list-action my-4">
                {!! $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) !!}
            </div>
        </div>
    </div>
</div>
