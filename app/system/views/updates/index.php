<div class="row-fluid">

    <?= $this->widgets['toolbar']->render(); ?>

    <?php if (!empty($updates['items']) OR !empty($updates['ignoredItems'])) { ?>
        <div id="updates">
            <?= $this->makePartial('updates/list'); ?>
        </div>
    <?php }
    else { ?>
        <div class="panel panel-light">
            <div class="panel-body">
                <h5 class="text-w-400"><?= lang('system::lang.updates.text_no_updates'); ?></h5>
            </div>
        </div>
    <?php } ?>
</div>

<?= $this->makePartial('updates/carte'); ?>
