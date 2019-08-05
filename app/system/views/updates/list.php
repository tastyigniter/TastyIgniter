<div id="list-items">
    <div class="panel panel-light">
        <?php $countItems = count($updates['items']); ?>
        <?php $countIgnored = count($updates['ignoredItems']); ?>
        <?php if ($countItems) { ?>
            <div class="panel-heading">
                <i class="fa fa-cloud-download fa-fw"></i>&nbsp;&nbsp;
                <?= sprintf(lang('system::lang.updates.text_update_found'), $countItems); ?>
            </div>

            <div class="panel-body"><?= lang('system::lang.updates.text_maintenance_mode'); ?></div>

            <?= $this->makePartial('updates/list_items', ['items' => $updates['items'], 'ignored' => FALSE]); ?>
        <?php } ?>

        <?php if ($countIgnored) { ?>
            <div class="panel-heading">
                <i class="fa fa-times-circle fa-fw"></i>&nbsp;&nbsp;
                <?= sprintf(lang('system::lang.updates.text_update_ignored'), $countIgnored); ?>
            </div>

            <?= $this->makePartial('updates/list_items', ['items' => $updates['ignoredItems'], 'ignored' => TRUE]); ?>
        <?php } ?>

    </div>
</div>