<div id="list-items">
    @php
        $countItems = count($updates['items']);
        $countIgnored = count($updates['ignoredItems']);
    @endphp
    @if ($countItems)
        <div class="p-3 border-bottom">
            <b>
                <i class="fa fa-cloud-download fa-fw"></i>&nbsp;&nbsp;
                {{ sprintf(lang('system::lang.updates.text_update_found'), $countItems) }}
            </b>
        </div>

        <div class="p-3 border-bottom">@lang('system::lang.updates.text_maintenance_mode')</div>

        {!! $this->makePartial('updates/list_items', ['items' => $updates['items'], 'ignored' => FALSE]) !!}
    @endif

    @if ($countIgnored)
        <div class="panel-heading">
            <b>
                <i class="fa fa-times-circle fa-fw"></i>&nbsp;&nbsp;
                {{ sprintf(lang('system::lang.updates.text_update_ignored'), $countIgnored) }}
            </b>
        </div>

        {!! $this->makePartial('updates/list_items', ['items' => $updates['ignoredItems'], 'ignored' => TRUE]) !!}
    @endif

</div>
