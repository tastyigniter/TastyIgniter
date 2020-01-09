<div class="container-fluid">
    <?php foreach ($items as $item) { ?>
        <div class="update-item row pt-3 pb-3 border-top <?= $ignored ? 'text-muted' : ''; ?>">
            <div class="col-sm-1 pt-2 text-center text-muted">
                <span
                    class="extension-icon rounded"
                    style="<?= $item['icon']['styles'] ?? ''; ?>"
                ><i class="<?= $item['icon']['class'] ?? ''; ?>"></i></span>
            </div>
            <div class="col-sm-2 pl-0 text-truncate">
                <b><?= $item['name'] ?></b>
                <p><?= $item['version'] ?></p>
            </div>
            <div class="description col col-sm-7">
                <?php if (isset($item['tags']['data'][0]) AND $tag = $item['tags']['data'][0]) { ?>
                    <?= $tag['description'] ?>
                <?php } ?>
            </div>
            <div class="col col-sm-2 text-right">
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
