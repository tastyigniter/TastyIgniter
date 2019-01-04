<div class="container-fluid">
    <?php foreach ($items as $item) { ?>
        <div class="row pt-3 pb-3 align-items-center border-top">
            <div class="col-sm-1 text-center">
                <i class="fa <?= $item['icon'] ?> fa-2x text-muted"></i>
            </div>
            <div class="col col-sm-9">
                <h5 class="<?= $ignored ? 'text-muted' : ''; ?>"><?= str_limit($item['name'], 22) ?></h5>
                <?php if (isset($item['tags']['data'][0]) AND $tag = $item['tags']['data'][0]) { ?>
                    <p class="<?= $ignored ? 'text-muted ' : ''; ?>small mb-0">
                        <strong><?= $tag['tag']; ?>:</strong> <?= $tag['description'] ?>
                    </p>
                <?php } ?>
            </div>
            <div class="col col-sm-2">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <?php if ($ignored) { ?>
                        <button
                            class="btn btn-light"
                            type="button"
                            data-control="ignore-item"
                            data-item-code="<?= $item['code'] ?>"
                            data-item-type="<?= $item['type'] ?>"
                            data-item-version="<?= $item['version'] ?>"
                            data-item-action="remove"
                        >
                            <span class="text-success"><?= lang('admin::lang.text_remove') ?></span>
                        </button>
                    <?php }
                    else { ?>
                        <button
                            class="btn btn-light"
                            type="button"
                            data-control="update-item"
                            data-item-code="<?= $item['code'] ?>"
                            data-item-type="<?= $item['type'] ?>"
                            data-item-version="<?= $item['version'] ?>"
                            data-item-action="ignore"
                        >
                            <span class="text-danger"><?= lang('system::lang.updates.text_ignore') ?></span>
                        </button>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
