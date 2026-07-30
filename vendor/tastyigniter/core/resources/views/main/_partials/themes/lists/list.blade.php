    {!! form_open(current_url(),
        [
            'id'     => 'list-form',
            'role'   => 'form',
            'method' => 'POST',
        ]
    ) !!}

    <div class="pt-3 px-3 pb-0">
        {!! $this->makePartial('lists/list_body') !!}
    </div>

    {!! form_close() !!}

    {!! $this->makePartial('lists/list_pagination') !!}
