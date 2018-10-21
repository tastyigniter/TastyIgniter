<div class="panel panel-item item-extension h-100 shadow-sm">
    <div class="d-flex h-75 p-3">
        <div class="pr-4">
            <?php if (!empty($item['thumb'])) { ?>
                <img src="<?= $item['thumb'] ?>"
                     class="img-rounded"
                     alt="No Image"
                     style="width: 64px; height: 64px;">
            <?php }
            else { ?>
                <i class="fa <?= $item['icon'] ?> fa-3x text-muted"></i>
            <?php } ?>
        </div>
        <div class="flex-grow-1 px-0 ml-auto">
            <h5><?= str_limit($item['name'], 22) ?></h5>
            <p class="mb-0 text-muted"><?= str_limit($item['description'], 128); ?></p>
        </div>
    </div>
    <div class="d-flex p-3">
        <?php if (!empty($item['installed'])) { ?>
            <button class="btn btn-outline-default btn-block disabled" title="Added">
                <i class="fa fa-cloud-download"></i>
            </button>
        <?php }
        else { ?>
            <button
                class="btn btn-outline-success btn-block btn-install"
                data-title="Add <?= $item['name'] ?>"
                data-control="add-item"
                data-item-code="<?= $item['code'] ?>"
                data-item-name="<?= $item['name'] ?>"
                data-item-type="<?= $item['type'] ?>"
                data-item-version="<?= $item['version'] ?>"
                data-item-context="<?= e(json_encode($item)); ?>"
                data-item-action="install">
                <i class="fa fa-cloud-download"></i>
            </button>
        <?php } ?>
    </div>
</div>
