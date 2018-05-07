<div
    id="<?= $filterId ?>" 
    class="list-filter <?= $cssClasses ?>"
    data-store-name="<?= $cookieStoreName; ?>"
    <?= !$this->isActiveState() ? ' style="display:none"' : '' ?>
>
    <div class="row">
        <div class="col-sm-9">
            <?php if (count($scopes)) { ?>
                <form id="filter-form"
                        class="form-inline"
                        accept-charset="utf-8"
                        method="POST"
                        action="<?= current_url(); ?>"
                        role="form">
                    <input type="hidden" name="_handler" value="<?= $onSubmitHandler; ?>">

                    <?= $this->makePartial('filter/filter_scopes') ?>

                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-default" type="submit" title="<?= lang('admin::default.text_filter'); ?>">
                            <i class="fa fa-filter"></i>
                        </button>&nbsp;
                        <button class="btn btn-outline-danger"
                                type="button"
                                data-request="<?= $onClearHandler; ?>"
                                title="<?= lang('admin::default.text_clear'); ?>">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>

        <div class="col-sm-3">
            <?php if ($search) { ?>
                <div class="filter-search">
                    <?= $search ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
