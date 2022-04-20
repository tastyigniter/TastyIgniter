<div class="row-fluid">

    {!! $this->widgets['toolbar']->render() !!}

    @if (!empty($updates['items']) || !empty($updates['ignoredItems']))
        <div id="updates">
            {!! $this->makePartial('updates/list') !!}
        </div>
    @else
        <div class="panel panel-light">
            <div class="panel-body" id="list-items">
                <h5 class="text-w-400 mb-0">@lang('system::lang.updates.text_no_updates')</h5>
            </div>
        </div>
    @endif
</div>

{!! $this->makePartial('updates/carte') !!}
