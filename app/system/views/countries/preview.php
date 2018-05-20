<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'     => 'edit-form',
            'role'   => 'form',
            'method' => 'PATCH',
        ]
    ); ?>

    <?= $this->renderForm(['preview' => TRUE]); ?>

    <?= form_close(); ?>
</div>
