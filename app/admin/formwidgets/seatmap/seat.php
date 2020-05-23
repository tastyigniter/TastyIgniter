<div class="col-sm-3 pb-3">
    <div class="card bg-light shadow-sm rounded-pill">
        <div class="d-flex p-3">
            <input type="hidden" name="<?= $sortableInputName ?>[]" value="<?= $seat->getKey(); ?>">
            <div class="align-self-center mr-3">
                <a
                    class="handle <?= $this->getId('items') ?>-handle"
                    role="button">
                    <i class="fa fa-bars text-black-50"></i>
                </a>
            </div>
            <div class="mr-auto">
                <i
                    class="fa fa-chair <?= $seat->table_status ? 'text-success' : 'text-danger'; ?> mr-2"
                ></i>
                <b><?= $seat->table_name; ?></b>
            </div>
            <div class="mr-3">
                <?= $seat->min_capacity; ?> - <?= $seat->max_capacity; ?>
            </div>
            <div class="">
                <a
                    class="close text-danger"
                    role="button"
                    data-control="delete-item"
                    data-item-id="<?= $seat->getKey() ?>"
                    data-item-selector="#<?= $this->getId('item-'.$index) ?>"
                    data-confirm-message="<?= lang('admin::lang.alert_warning_confirm') ?>"
                ><i class="fa fa-trash-alt"></i></a>
            </div>
        </div>
    </div>
</div>