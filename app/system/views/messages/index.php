<div class="message-list">
    <?= $this->widgets['toolbar']->render(); ?>

    <div class="row no-gutters">
        <div class="col-2">
            <?= $this->makePartial('messages/message_folders'); ?>
        </div>
        <div class="col-10">
            <?= $this->widgets['list_filter']->render(); ?>
            <?= $this->widgets['list']->render(); ?>
        </div>
    </div>

</div>
