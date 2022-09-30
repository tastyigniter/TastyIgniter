<div class="row-fluid">
    {!! form_open([
        'id'=> 'preview-form-widget',
        'role' => 'form',
    ]) !!}

    {!! $this->renderForm(['preview' => true]) !!}

    {!! form_close() !!}
</div>
