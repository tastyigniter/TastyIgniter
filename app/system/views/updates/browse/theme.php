<div class="panel panel-item">
    <div class="panel-body">
        <div class="media">
            <a class="media-top">
                <img src="<?= $item['icon'] ?>"
                     class="img-rounded"
                     alt="No Image"
                     style="width: 64px; height: 64px;">
            </a>
            <div class="media-body small">
                <?php if (!empty($item['installed'])) { ?>
                    <button class="btn btn-default pull-right disabled" title="Added">
                        <i class="fa fa-cloud-download"></i>
                    </button>
                <?php }
                else { ?>
                    <button
                        class="btn btn-default pull-right btn-install"
                        data-title="Add <?= $item['name'] ?>"
                        data-control="add-item"
                        data-item-code="<?= $item['code'] ?>"
                        data-item-name="<?= $item['name'] ?>"
                        data-item-type="<?= $item['type'] ?>"
                        data-item-version="<?= $item['version'] ?>"
                        data-item-context="<?= e(json_encode($item)); ?>"
                        data-item-action="install">
                        <i class="fa fa-cloud-download text-success"></i>
                    </button>
                <?php } ?>
                <h4 class="panel-title"><?= str_limit($item['name'], 22) ?></h4>
                <?= str_limit($item['description'], 72); ?>
            </div>
        </div>
    </div>
</div>
