<div class="d-flex w-100 align-items-center">
    <div
        class="flex-grow-1"
        @if($record->class && strlen($record->readme))
        data-toggle="record-editor"
        data-handler="onLoadReadme"
        data-record-id="{{ $record->extension_id }}"
        role="button"
        @endif
    >
        <span class="extension-name font-weight-bold @unless($record->class) text-muted @endunless">
            @unless($record->class)<s>{{ $record->title }}</s>@else{{ $record->title }}@endunless
        </span>&nbsp;&nbsp;
        <span class="small text-muted">{{ $record->version }}</span>
        <p class="extension-desc mb-0 text-muted">{{ $record->description }}</p>
    </div>
    <div class="text-muted text-right small">
        <b>@lang('igniter::system.extensions.text_author')</b><br/>
        {{ $record->meta['author'] ?? '' }}
    </div>
</div>
