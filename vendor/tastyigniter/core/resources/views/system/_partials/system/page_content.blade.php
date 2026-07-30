@if($alerts->isNotEmpty())
    <div class="d-flex flex-column gap-2 mb-3">
        @foreach($alerts as $alert)
            <div
                @class([
                    'alert mb-0',
                    'alert-danger' => $alert->status === 'failed',
                    'alert-warning' => $alert->status === 'warning',
                ])
                role="alert"
            >
                <strong>{{ $alert->label }}</strong>
                @if($alert->summary ?? false)
                    — {{ $alert->summary }}
                @endif
                @if($alert->actionMessage)
                    — {{ $alert->actionMessage }}
                @endif
                @if($alert->actionUrl)
                    <a href="{{ $alert->actionUrl }}" class="alert-link ms-1" target="_blank" rel="noopener">
                        {{ $alert->actionUrlLabel }}
                    </a>
                @endif
            </div>
        @endforeach
    </div>
@endif

<div class="row g-3">
    @foreach($results as $item)
        {!! $this->makePartial('system/card', [
            'check' => $item['check'],
            'result' => $item['result'],
        ]) !!}
    @endforeach
</div>
