<div class="message-folders panel">
    <div class="panel-header">
        <h5 class="panel-title"><?= lang('system::lang.messages.text_folders'); ?></h5>
    </div>
    <div class="list-group list-group-flush">
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
