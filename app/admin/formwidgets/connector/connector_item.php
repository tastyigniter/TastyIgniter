<div
    id="<?= $this->getId('item-'.$index) ?>"
    class="card bg-light shadow-sm mb-2"
    data-item-index="<?= $index ?>"
>
    <div class="card-body">
        <div class="d-flex w-100 justify-content-between">
            <?php if (!$this->previewMode AND $sortable) { ?>
                <input type="hidden" name="<?= $sortableInputName ?>[]" value="<?= $item->getKey(); ?>">
                <div class="align-self-center mr-3">
                    <a
                        class="handle <?= $this->getId('items') ?>-handle"
                        role="button">
                        <i class="fa fa-bars text-black-50"></i>
                    </a>
                </div>
            <?php } ?>
            <div
                class="flex-fill"
                data-control="load-item"
                data-item-id="<?= $item->getKey() ?>"
                role="button"
            >
                <?php if ($this->partial) { ?>
                    <?= $this->makePartial($this->partial, ['item' => $item]) ?>
                <?php } else { ?>
                    <p class="card-title font-weight-bold"><?= $item->{$nameFrom} ?></p>
                    <p class="card-subtitle mb-0"><?= $item->{$descriptionFrom} ?></p>
                <?php } ?>
            </div>
            <?php if (!$this->previewMode) { ?>
                <div class="align-self-center ml-auto">
                    <a
                        class="close text-danger"
                        aria-label="Remove"
                        data-control="delete-item"
                        data-item-id="<?= $item->getKey() ?>"
                        data-item-selector="#<?= $this->getId('item-'.$index) ?>"
                        data-confirm-message="<?= lang('admin::lang.alert_warning_confirm') ?>"
                    ><i class="fa fa-trash-alt"></i></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
