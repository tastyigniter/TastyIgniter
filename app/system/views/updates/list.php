<div id="list-items">
    <div class="panel panel-light">
        <?php $countIgnored = count($updates['ignoredItems']); ?>
        <div class="panel-heading">
            <h5 class="panel-title">
                <i class="fa fa-cloud-download fa-fw"></i>&nbsp;&nbsp;
                <?= sprintf(lang('system::updates.text_update_found'), $updates['count']); ?>
                <?= $countIgnored ? ', '.sprintf(lang('system::updates.text_update_ignored'), $countIgnored) : null; ?>
            </h5>
        </div>

        <?php if (count($updates['items'])) { ?>
            <div class="panel-body">
                <p><?= lang('system::updates.text_maintenance_mode'); ?></p>
            </div>

            <?= $this->makePartial('updates/list_items', ['items' => $updates['items'], 'ignored' => FALSE]); ?>
        <?php } ?>

        <?php if ($countIgnored) { ?>
            <div class="panel-heading">
                <h5 class="panel-title">
                    <i class="fa fa-times-circle fa-fw"></i>&nbsp;&nbsp;
                    <?= sprintf(lang('system::updates.text_update_ignored'), $countIgnored); ?>
                </h5>
            </div>

            <?= $this->makePartial('updates/list_items', ['items' => $updates['ignoredItems'], 'ignored' => TRUE]); ?>
        <?php } ?>

    </div>
</div>