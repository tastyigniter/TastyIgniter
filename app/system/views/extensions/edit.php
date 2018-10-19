<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id' => 'edit-form',
            'role' => 'form',
            'method' => 'PATCH',
        ]
    ); ?>

    <?= $this->toolbarWidget->render(); ?>
    <?= $this->formWidget->render(); ?>

    <?= form_close(); ?>
</div>
