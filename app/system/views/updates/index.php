    <div class="row-fluid">

        <?= $this->widgets['toolbar']->render(); ?>

        <?php if (!empty($updates)) { ?>
            <div id="updates">
                <?= $this->makePartial('updates/list'); ?>
            </div>
        <?php }
        else { ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="text-w-400"><?= lang('system::updates.text_no_updates'); ?></h4>
                </div>
            </div>
        <?php } ?>
    </div>

<?= $this->makePartial('updates/carte'); ?>
