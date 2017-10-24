<div class="table-responsive wrap-vertical">
    <table class="table table-striped<?= $ignored ? ' table-muted' : ''; ?>">
        <tbody>
        <?php foreach ($items as $item) { ?>
            <tr>
                <td class="list-action">
                    <i class="fa <?= $item['icon'] ?> fa-2x text-muted"></i>
                </td>
                <td>
                    <h4 class="<?= $ignored ? 'text-muted' : ''; ?>">
                        <?= str_limit($item['name'], 22) ?> <i class="fa fa-long-arrow-right"></i>
                        <span class="small">
                                <?= sprintf(lang('system::updates.text_item_update_summary'), $item['ver'], $item['version']) ?>
                            </span>
                    </h4>
                    <?php if (isset($item['tags']['data'])) foreach ($item['tags']['data'] as $tag) { ?>
                        <p class="<?= $ignored ? 'text-muted ' : ''; ?>small">
                            <strong><?= $tag['tag']; ?>:</strong> <?= $tag['description'] ?>
                        </p>
                    <?php } ?>
                </td>
                <td class="text-right">
                    <div class="btn-group" data-toggle="buttons">
                        <?php if ($ignored) { ?>
                            <button
                                class="btn btn-default"
                                type="button"
                                data-control="ignore-item"
                                data-item-code="<?= $item['code'] ?>"
                                data-item-type="<?= $item['type'] ?>"
                                data-item-version="<?= $item['version'] ?>"
                                data-item-action="remove"
                            >
                                <span class="text-danger"><?= lang('admin::default.text_remove') ?></span>
                            </button>
                        <?php }
                        else { ?>
                            <button
                                class="btn btn-default"
                                type="button"
                                data-control="update-item"
                                data-item-code="<?= $item['code'] ?>"
                                data-item-type="<?= $item['type'] ?>"
                                data-item-version="<?= $item['version'] ?>"
                                data-item-action="ignore"
                            >
                                <span class="text-danger"><?= lang('admin::default.text_ignore') ?></span>
                            </button>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
