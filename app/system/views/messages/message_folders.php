<div class="panel panel-message-folders">
    <div class="panel-heading">
        <h3 class="panel-title"><?= lang('system::messages.text_folders'); ?></h3>
    </div>
    <div class="panel-body wrap-none">
        <div class="list-group list-group-hover">
            <?php foreach ($folders as $key => $folder) { ?>
                <a
                    class="list-group-item <?= ($key == $listContext) ? 'active' : '' ?>"
                    href="<?= admin_url($folder['url']); ?>"
                >
                    <i class="fa <?= $folder['icon']; ?>"></i>&nbsp;&nbsp;
                    <?= lang($folder['title']); ?>&nbsp;&nbsp;
                    <?php if ($key == 'inbox') { ?>
                        <span class="label label-primary pull-right"><?= $unreadCount; ?></span>
                    <?php } ?>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
