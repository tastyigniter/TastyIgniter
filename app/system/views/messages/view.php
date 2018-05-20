<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'     => 'edit-form',
            'role'   => 'form',
            'method' => 'PATCH',
        ]
    ); ?>

    <?= $this->widgets['toolbar']->render(); ?>

    <div
        class="panel-group conversation"
    >
        <?= $this->widgets['form']->renderField('conversation', ['useContainer' => FALSE]); ?>

        <div class="conversation-respond">
            <?= $this->widgets['form']->renderField('respond', ['useContainer' => FALSE]); ?>
        </div>
    </div>
    <?= form_close(); ?>
</div>
