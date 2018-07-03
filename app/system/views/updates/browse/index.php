<div class="row-fluid">

    <?= $this->widgets['toolbar']->render(); ?>

    <?= $this->makePartial('updates/search'); ?>

    <div class="panel panel-light panel-items">
        <div class="panel-heading">
            <h5 class="panel-title"><?= sprintf(lang('system::lang.updates.text_popular_title'), ucwords(str_plural($itemType))) ?></h5>
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
