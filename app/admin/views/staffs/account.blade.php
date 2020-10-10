<div class="row-fluid">
    {!! form_open([
        'id'     => 'edit-form',
        'role'   => 'form',
        'method' => 'PATCH',
    ]) !!}

    {!! $this->renderForm() !!}

    {!! form_close() !!}
</div>
