<div class="panel panel-item item-theme">
    <img
        src="<?= $item['icon'] ?>"
        class="img-responsive img-rounded"
        alt="No Image"
        style="height: 200px"
    >
    <div class="panel-body">
        <h5><?= str_limit($item['name'], 22) ?></h5>
        <p class="text-muted mb-0"><?= str_limit($item['description'], 72); ?></p>
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
