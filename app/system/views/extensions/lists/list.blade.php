{!! form_open(current_url(),
    [
        'id' => 'list-form',
        'role' => 'form',
        'method' => 'POST',
    ]
) !!}

<div class="list-extensions page-x-spacer">
        @if (count($records))
            {!! $this->makePartial('lists/list_body') !!}
        @else
            <div class="card bg-light border-none">
                <div class="card-body p-3">{{ $emptyMessage }}</div>
            </div>
        @endif
</div>

{!! form_close() !!}

{!! $this->makePartial('lists/list_pagination') !!}
