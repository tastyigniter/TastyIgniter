<div
    id="<?= $filterId ?>"
    class="list-filter <?= $cssClasses ?>"
    data-store-name="<?= $cookieStoreName; ?>"
    <?= !$this->isActiveState() ? ' style="display:none"' : '' ?>
>
    <?php if (count($scopes)) { ?>
        <form
            id="filter-form"
            class="form-inline"
            accept-charset="utf-8"
            method="POST"
            action="<?= current_url(); ?>"
            role="form"
        >
            <input type="hidden" name="_handler" value="<?= $onSubmitHandler; ?>">

            <?= $this->makePartial('filter/filter_scopes') ?>
        </form>
    <?php } ?>

    <div class="d-flex">
        <?php if (count($scopes) OR $search) { ?>
            <div class="mr-3">
                <button
                    class="btn btn-outline-danger"
                    type="button"
                    data-request="<?= $onClearHandler; ?>"
                >
                    <i class="fa fa-times"></i>&nbsp;&nbsp;<?= lang('admin::lang.text_clear'); ?>
                </button>
            </div>
        <?php } ?>
        <div class="flex-fill">
            <?php if ($search) { ?>
                <div class="filter-search"><?= $search ?></div>
            <?php } ?>
        </div>
    </div>
</div>
