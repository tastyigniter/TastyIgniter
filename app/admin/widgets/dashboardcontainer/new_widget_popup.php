<?= form_open(current_url()) ?>
    <div class="modal-header">
        <h4 class="modal-title"><?= e(trans('admin::lang.dashboard.text_add_widget')) ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label class="control-label"><?= e(trans('admin::lang.dashboard.label_widget')) ?></label>
            <select class="form-control" name="className">
                <option value=""><?= e(trans('admin::lang.dashboard.text_select_widget')) ?></option>
                <?php foreach ($widgets as $className => $widgetInfo) { ?>
                    <option
                        value="<?= e($className) ?>"><?= isset($widgetInfo['label']) ? e(trans($widgetInfo['label'])) : $className ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label class="control-label"><?= e(trans('admin::lang.dashboard.label_widget_columns')) ?></label>
            <select class="form-control" name="size">
                <option></option>
                <?php foreach ($gridColumns as $column => $name) { ?>
                    <option value="<?= e($column) ?>" <?= $column == 12 ? 'selected' : null ?>><?= e($name) ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button
            type="button"
            class="btn btn-primary"
            data-request="<?= $this->getEventHandler('onAddWidget') ?>"
            data-dismiss="modal"
        >
            <?= e(trans('admin::lang.button_add')) ?>
        </button>
        <button
            type="button"
            class="btn btn-default"
            data-dismiss="modal">
            <?= e(trans('admin::lang.button_close')) ?>
        </button>
    </div>
<?= form_close() ?>