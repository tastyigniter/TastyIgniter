<div id="<?= $filterId ?>" class="list-filter <?= $cssClasses ?>">
    <div class="panel panel-filter">
        <div class="panel-body" data-store-name="<?= $cookieStoreName; ?>"<?= !$this->isActiveState() ? ' style="display:none"' : '' ?>>
            <div class="filter-bar">
                <div class="row">
                    <div class="col-md-9">
                        <?php if (count($scopes)) { ?>
                            <form id="filter-form" class="form-inline" accept-charset="utf-8" method="POST" action="<?= current_url(); ?>" role="form">
                                <input type="hidden" name="_handler" value="<?= $onSubmitHandler; ?>">

                                <?= $this->makePartial('filter/filter_scopes') ?>

                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-default" type="submit" title="<?= lang('text_filter'); ?>">
                                        <i class="fa fa-filter"></i>
                                    </button>&nbsp;
                                    <button class="btn btn-default" type="button" data-request="<?= $onClearHandler; ?>" title="<?= lang('text_clear'); ?>">
                                        <i class="fa fa-times text-danger"></i>
                                    </button>
                                </div>
                            </form>
                        <?php } ?>
                    </div>

                    <div class="col-md-3 text-right">
                        <?php if ($search) { ?>
                            <div class="filter-search">
                                <?= $search ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
