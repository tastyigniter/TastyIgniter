<div class="row-fluid">
    <?= form_open(current_url(),
        [
            'id'   => 'list-form',
            'role' => 'form',
            'method' => 'POST'
        ]
    ); ?>

        <div class="container-fluid">
            <div class="row">
                <?= $this->makePartial('lists/list_body') ?>
            </div>
        </div>

    <?= form_close(); ?>
    
    <?= $this->makePartial('lists/list_pagination') ?>
</div>
