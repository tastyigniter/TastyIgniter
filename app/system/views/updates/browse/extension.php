<div class="panel panel-item item-extension">
    <div class="media">
        <a class="media-left media-middle">
            <?php if (!empty($item['thumb'])) { ?>
                <img src="<?= $item['thumb'] ?>"
                     class="img-rounded"
                     alt="No Image"
                     style="width: 64px; height: 64px;">
            <?php }
            else { ?>
                <i class="fa <?= $item['icon'] ?> fa-3x text-muted"></i>
            <?php } ?>
        </a>
        <div class="media-body">
            <h5 class="panel-title"><?= str_limit($item['name'], 22) ?></h5>
            <?= str_limit($item['description'], 72); ?>
        </div>
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
