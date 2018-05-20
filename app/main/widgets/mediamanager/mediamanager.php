<div
    class="media-manager"
    data-control="media-manager"
    data-alias="<?= $this->alias ?>"
    data-max-upload-size="<?= e($maxUploadSize) ?>"
    data-allowed-extensions="<?= e(json_encode($allowedExtensions)) ?>"
    data-select-mode="<?= e($selectMode) ?>"
    data-unique-id="<?= $this->getId() ?>"
>
    <div id="<?= $this->getId('toolbar') ?>" class="media-toolbar">
        <?= $this->makePartial('mediamanager/toolbar') ?>
    </div>

    <div id="notification"></div>

    <div id="<?= $this->getId('breadcrumb') ?>" class="media-breadcrumb">
        <?= $this->makePartial('mediamanager/breadcrumb') ?>
    </div>

    <div class="media-container">

        <div id="<?= $this->getId('folder-tree') ?>"
             data-control="folder-tree">
            <?= $this->makePartial('mediamanager/folder_tree') ?>
        </div>

        <div class="row no-gutters">
            <div
                class="col-9 border-right wrap-none wrap-left"
                data-control="media-list"
            >
                <div id="<?= $this->getId('item-list') ?>" class="media-list-container">
                    <?php if ($this->getSetting('uploads')) { ?>
                        <?= $this->makePartial('mediamanager/uploader') ?>
                    <?php } ?>

                    <?= $this->makePartial('mediamanager/item_list') ?>
                </div>
            </div>
            <div class="col-3">
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