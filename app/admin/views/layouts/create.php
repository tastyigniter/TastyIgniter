<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'   => 'edit-form',
            'role' => 'form',
        ],
        ['_method' => 'POST']
    ); ?>

    <?= $this->renderForm(); ?>

    <?= form_close(); ?>
</div>

