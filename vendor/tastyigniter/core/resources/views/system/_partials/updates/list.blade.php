<div id="list-items" class="card border-none shadow-none rounded-none">
    @php
        $countItems = count($updates['items']);
        $countIgnored = count($updates['ignoredItems']);
    @endphp
    <div class="p-3 border-bottom text-muted">
        <b>
            <i class="fa fa-arrow-up fa-fw"></i>
            {{ sprintf(lang('igniter::system.updates.text_update_found'), $countItems) }}
        </b>
    </div>

    {!! $this->makePartial('updates/list_items', ['items' => $updates['items'], 'ignored' => false]) !!}

    <div class="p-3 border-top border-bottom text-muted">
        <b>
            <i class="fa fa-xmark fa-fw"></i>&nbsp;&nbsp;
            {{ sprintf(lang('igniter::system.updates.text_update_ignored'), $countIgnored) }}
        </b>
    </div>

    {!! $this->makePartial('updates/list_items', ['items' => $updates['ignoredItems'], 'ignored' => TRUE]) !!}

</div>
