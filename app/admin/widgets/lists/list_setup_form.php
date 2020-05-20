<div class="modal-dialog modal-dialog-scrollable">
    <?= form_open([]); ?>
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><?= sprintf(lang('admin::lang.list.setup_title'), lang($this->getConfig('title'))); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="control-label">
                    <?= e(lang('admin::lang.list.label_visible_columns')) ?>
                    <span class="help-block"><?= e(lang('admin::lang.list.help_visible_columns')) ?></span>
                </label>
                <div class="list-group list-group-flush">
                    <?php foreach ($columns as $column) { ?>
                        <?php if ($column->type == 'button') { ?>
                            <input
                                type="hidden"
                                id="list-setup-<?= $column->columnName ?>"
                                name="visible_columns[]"
                                value="<?= e($column->columnName) ?>"
                            />
                        <?php } else { ?>
                            <div class="list-group-item">
                                <div class="btn btn-handle form-check-handle"><i class="fa fa-bars"></i></div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input
                                        type="checkbox"
                                        id="list-setup-<?= $column->columnName ?>"
                                        class="custom-control-input"
                                        name="visible_columns[]"
                                        value="<?= e($column->columnName) ?>"
                                        <?= $column->invisible ? '' : 'checked="checked"' ?>
                                    />
                                    <input
                                        type="hidden"
                                        name="column_order[]"
                                        value="<?= e($column->columnName) ?>"
                                    />
                                    <label
                                        class="custom-control-label"
                                        for="list-setup-<?= $column->columnName ?>"
                                    ><b><?= e(lang($column->label)) ?></b></label>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <?php if ($this->showPagination) { ?>
                <div class="form-group">
                    <label class="control-label">
                        <?= e(lang('admin::lang.list.label_page_limit')) ?>
                        <span class="help-block"><?= e(lang('admin::lang.list.help_page_limit')) ?></span>
                    </label>
                    <div
                        class="btn-group btn-group-toggle"
                        data-toggle="buttons"
                    >
                        <?php $index = 0;
                        foreach ($perPageOptions as $optionValue) { ?>
                            <?php
                            $index++;
                            $checkboxId = 'checkbox_page_limit_'.$optionValue;
                            ?>
                            <label class="btn btn-light <?= $optionValue == $pageLimit ? 'active' : '' ?>">
                                <input
                                    type="radio"
                                    id="<?= $checkboxId ?>"
                                    name="page_limit"
                                    value="<?= $optionValue ?>"
                                    <?= $optionValue == $pageLimit ? 'checked="checked"' : '' ?>>
                                <?= e($optionValue) ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="modal-footer progress-indicator-container">
            <button
                type="button"
                class="btn btn-link text-danger mr-sm-auto"
                data-request="<?= $this->getEventHandler('onResetSetup'); ?>"
                data-progress-indicator="<?= e(lang('admin::lang.text_resetting')) ?>"
            ><?= lang('admin::lang.list.button_reset_setup') ?></button>
            <button
                type="button"
                class="btn btn-link"
                data-dismiss="modal"
            ><?= lang('admin::lang.list.button_cancel_setup') ?></button>
            <button
                type="button"
                class="btn btn-primary"
                data-request="<?= $this->getEventHandler('onApplySetup'); ?>"
                data-progress-indicator="<?= e(lang('admin::lang.text_saving')) ?>"
            ><?= lang('admin::lang.list.button_apply_setup') ?></button>
        </div>
    </div>
    <?= form_close(); ?>
</div>