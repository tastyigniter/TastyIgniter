<div id="{{$this->getId('list')}}">
    {!! form_open(current_url(),
    [
        'id' => $this->getId('list-form'),
        'role' => 'form',
        'method' => 'POST',
    ]
) !!}

    <div class="list-extensions pt-3 px-3 pb-0">
        @if(count($records))
            {!! $this->makePartial('lists/list_body') !!}
        @else
            <div class="card border-none">
                <div class="card-body p-3">{{ $emptyMessage }}</div>
            </div>
        @endif
    </div>

    {!! form_close() !!}

    {!! $this->makePartial('lists/list_pagination') !!}
</div>
