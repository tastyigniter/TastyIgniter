<div class="panel panel-item item-theme">
    <img 
        src="<?= $item['icon'] ?>"
        class="img-responsive img-rounded"
        alt="No Image"
    >

        <div class="panel-body">
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
            <h5 class="panel-title"><?= str_limit($item['name'], 22) ?></h5>
            <?= str_limit($item['description'], 72); ?>
    </div>
</div>
