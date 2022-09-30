<div class="row-fluid">
    {!! form_open([
        'id' => 'form-widget',
        'role' => 'form',
        'method' => 'PATCH',
    ]) !!}

    {!! $this->renderForm() !!}

    {!! form_close() !!}
</div>
