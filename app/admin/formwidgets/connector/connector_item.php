<div
    id="<?= $this->getId('item-'.$index) ?>"
    class="card bg-light border-none mb-2"
    data-item-index="<?= $index ?>"
>
    <div class="card-body p-3">
        <div class="d-flex w-100 justify-content-between">
            <?php if (!$this->previewMode AND $sortable) { ?>
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
                    <span class="card-title font-weight-bold mb-0"><?= $item->{$nameFrom} ?></span>
                    <p class="card-subtitle mb-0"><?= $item->{$descriptionFrom} ?></p>
                <?php } ?>
            </div>
            <div class="align-self-center ml-auto">
                <a
                    class="close text-danger"
                    aria-label="Remove"
                    <?php if (!$this->previewMode) { ?>
                        data-control="delete-item"
                        data-item-id="<?= $item->getKey() ?>"
                        data-item-selector="#<?= $this->getId('item-'.$index) ?>"
                        data-confirm-message="<?= lang('admin::lang.alert_warning_confirm') ?>"
                    <?php } ?>
                ><i class="fa fa-trash-alt"></i></a>
            </div>
        </div>

        <input type="hidden" name="<?= $sortableInputName ?>[]" value="<?= $index; ?>">
    </div>
</div>
