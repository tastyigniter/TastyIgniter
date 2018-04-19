<div class="row content message-list">
    <div class="col-xs-12 col-md-2 wrap-none">
        <div class="message-toolbar toolbar-action wrap-left">
            <a
                href="<?= admin_url('messages/compose'); ?>"
                class="btn btn-layer btn-primary btn-block"
            ><?= lang('system::messages.button_compose'); ?></a>
        </div>

        <?= $this->makePartial('messages/message_folders'); ?>
    </div>

    <div class="col-xs-12 col-md-10 wrap-none">
        <?= $this->renderList(); ?>
    </div>
</div>
