<div class="card m-3">
    <div class="card-body p-3 text-center">
        <button
            type="button"
            class="btn btn-light text-primary btn-lg"
            data-toggle="record-editor"
            data-handler="onLoadRecommended"
            data-record-data='{"itemType": "{{ $itemType }}"}'
        >@lang('system::lang.updates.button_recommended_'.$itemType)</button>
        <div
            id="carte-help"
            class="wrap-horizontal"
        >{!! sprintf(lang('system::lang.updates.help_carte_key'), 'https://tastyigniter.com/signin', 'https://tastyigniter.com/support/articles/carte-key') !!}
        </div>
    </div>
</div>
