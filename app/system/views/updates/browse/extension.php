<div class="panel panel-item item-extension shadow-sm">
    <div class="d-flex align-items-center p-3">
        <div class="pr-3">
            <?php if (!empty($item['thumb'])) { ?>
                <img src="<?= $item['thumb'] ?>"
                     class="img-rounded"
                     alt="No Image"
                     style="width: 64px; height: 64px;">
            <?php }
            else { ?>
                <i class="fa <?= $item['icon'] ?> fa-2x text-muted"></i>
            <?php } ?>
        </div>
        <div class="col-8 px-0 mr-auto">
            <h5 class=""><?= str_limit($item['name'], 22) ?></h5>
            <p class="mb-0 text-truncate"><?= str_limit($item['description'], 72); ?></p>
        </div>
        <div class="pl-3">
            <?php if (!empty($item['installed'])) { ?>
                <button class="media-middle btn btn-outline-default pull-right disabled" title="Added">
                    <i class="fa fa-cloud-download"></i>
                </button>
            <?php }
            else { ?>
                <button
                    class="media-middle btn btn-outline-success pull-right btn-install"
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
</div>
