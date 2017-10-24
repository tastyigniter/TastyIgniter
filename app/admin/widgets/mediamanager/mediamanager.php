<div
    class="media-manager"
    data-control="media-manager"
    data-alias="<?= $this->alias ?>"
    data-max-upload-size="<?= e($maxUploadSize) ?>"
    data-allowed-ext="<?= e(json_encode($allowedExt)) ?>"
    data-select-mode="<?= e($selectMode) ?>"
    data-unique-id="<?= $this->getId() ?>"
>
    <div id="<?= $this->getId('toolbar') ?>">
        <?= $this->makePartial('mediamanager/toolbar') ?>
    </div>

    <div id="notification"></div>

    <div id="<?= $this->getId('breadcrumb') ?>" class="container-fluid">
        <?= $this->makePartial('mediamanager/breadcrumb') ?>
    </div>

    <div class="media-container container-fluid">

        <div id="<?= $this->getId('folder-tree') ?>"
             data-control="folder-tree">
            <?= $this->makePartial('mediamanager/folder_tree') ?>
        </div>

        <div class="row-fluid">
            <div class="col-sm-9 border-right wrap-none wrap-left"
                 data-control="media-list">

                <?php if ($this->getSetting('uploads')) { ?>
                    <?= $this->makePartial('mediamanager/uploader') ?>
                <?php } ?>

                <div id="<?= $this->getId('item-list') ?>">
                    <?= $this->makePartial('mediamanager/item_list') ?>
                </div>
            </div>
            <div class="col-sm-3">
                <?= $this->makePartial('mediamanager/sidebar') ?>
            </div>
        </div>
    </div>

    <div
        id="<?= $this->getId('statusbar') ?>"
        data-control="media-statusbar">
        <?= $this->makePartial('mediamanager/statusbar') ?>
    </div>
    <?= $this->makePartial('mediamanager/forms') ?>
</div>

<div id="previewBox" style="display:none;"></div>