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
            <?= csrf_field(); ?>
            <input type="hidden" name="_handler" value="<?= $onSubmitHandler; ?>">

            <?= $this->makePartial('filter/filter_scopes') ?>
        </form>
    <?php } ?>

    <?php if ($search) { ?>
        <div class="d-flex mt-3">
            <div class="mr-3">
                <button
                    class="btn btn-outline-danger"
                    type="button"
                    data-request="<?= $onClearHandler; ?>"
                    data-attach-loading
                ><i class="fa fa-times"></i>&nbsp;&nbsp;<?= lang('admin::lang.text_clear'); ?></button>
            </div>
            <div class="flex-fill">
                <div class="filter-search"><?= $search ?></div>
            </div>
        </div>
    <?php } ?>
</div>
