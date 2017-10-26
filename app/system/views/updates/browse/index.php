<div class="row-fluid">

    <?= $this->widgets['toolbar']->render(); ?>

    <?= $this->makePartial('updates/search'); ?>

    <div class="panel panel-items">
        <div class="panel-heading">
            <h4 class="panel-title"><?= sprintf(lang('system::updates.text_recommended_title'), ucwords(str_plural($itemType))) ?></h4>
        </div>

        <div
            id="list-items"
            class="panel-body items-list"
            data-fetch-items="<?= $itemType; ?>"
            data-installed-items="<?= json_encode($installedItems); ?>"
        >
            <p class="text-center">
                <i class="fa fa-spinner fa-3x fa-spin"></i>
            </p>
        </div>
    </div>
</div>

<?= $this->makePartial('updates/carte'); ?>
