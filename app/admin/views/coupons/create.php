<div class="row content">
    <?= form_open(current_url(),
        [
            'id'     => 'edit-form',
            'role'   => 'form',
            'method' => 'POST',
        ]
    ); ?>

    <?= $this->renderForm(); ?>

    <?= form_close(); ?>
</div>
