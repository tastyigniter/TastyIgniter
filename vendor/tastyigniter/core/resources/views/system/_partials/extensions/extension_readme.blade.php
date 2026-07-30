@if($record && $record->class && strlen($record->readme))
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
        <div class="modal-header justify-content-between">
            <h4 class="modal-title">{{ $record->title }}</h4>
            @isset($record->meta['homepage'])
                <a href="{{ $record->meta['homepage']}}"><i class="fa fa-external-link fa-2x"></i></a>
            @endisset
        </div>
        <div class="modal-body markdown">
            {{ new \Illuminate\Support\HtmlString($record->readme) }}
        </div>
    </div>
</div>
@endif
