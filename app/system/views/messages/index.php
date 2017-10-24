    <div class="row content">
        <div class="col-md-12">
            <div class="row message-list">
                <div class="col-xs-12 col-md-2 wrap-none wrap-left">
                    <div class="message-toolbar toolbar-action">
                        <a
                            href="<?= admin_url('messages/compose'); ?>"
                            class="btn btn-layer btn-primary btn-block"
                        ><?= lang('system::messages.button_compose'); ?></a>
                    </div>

                    <?= $this->makePartial('messages/message_folders'); ?>
                </div>

                <div class="col-xs-12 col-md-10 wrap-none wrap-right">
                    <?= $this->renderList(); ?>
                </div>
            </div>
        </div>
    </div>
