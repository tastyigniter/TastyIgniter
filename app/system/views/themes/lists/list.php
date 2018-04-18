<div class="row-fluid">
    <div class="panel panel-inverse">
        <?= form_open(current_url(),
            [
                'id'   => 'list-form',
                'role' => 'form',
                'method' => 'POST'
            ]
        ); ?>

        <div class="row">
            <?= $this->makePartial('lists/list_body') ?>

            <?= $this->makePartial('lists/list_pagination') ?>
        </div>

        <?= form_close(); ?>
    </div>
</div>
