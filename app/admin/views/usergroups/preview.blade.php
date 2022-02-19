<div class="row-fluid">
    {!! form_open([
        'id'     => 'preview-form',
        'role'   => 'form',
    ]) !!}

    {!! $this->renderForm(['preview' => TRUE]) !!}

    {!! form_close() !!}
</div>
