<div
    id="<?= $this->getId('area-panel-'.$index) ?>"
    data-row="<?= $index ?>"
    class="panel panel-default">

    <div class="panel-heading collapsed"
         data-toggle="collapse"
         data-parent="#<?= $this->getId('areas') ?>"
         href="#<?= $this->getId('panel-collapse-'.$index) ?>"
         role="button">
        <span class="fa-stack">
            <i data-area-color
               class="fa fa-<?= ($area['type'] == 'circle') ? 'circle' : 'stop' ?> fa-stack-2x fa-inverse"></i>
            <i data-area-color class="fa fa-<?= ($area['type'] == 'circle') ? 'circle' : 'stop' ?> fa-stack-1x"
               style="color:<?= is_numeric($index) ? $this->getAreaColor($index) : '%%color%%'; ?>">
            </i>
        </span>
        <span>&nbsp;&nbsp;<?= $area['name']; ?></span>
        <div class="area-remove-button pull-right">
            <a
                class="text-danger"
                title="Remove"
                role="button"
                data-confirm="<?= lang('lang:admin::default.alert_warning_confirm'); ?>"
                data-control="remove-panel"
                data-target="#<?= $this->getId('area-panel-'.$index) ?>">
                <i class="fa fa-times-circle"></i>
            </a>
        </div>
    </div>
    <div
        id="<?= $this->getId('panel-collapse-'.$index) ?>"
        class="collapse">

        <div class="panel-body">
            <?= $this->makePartial('maparea/area_form', ['area' => $area, 'index' => $index]) ?>

            <div class="form-group">
                <label class="control-label">
                    <?= lang('label_delivery_condition'); ?>
                    <span class="help-block"><?= lang('help_delivery_condition'); ?></span>
                </label>
                <?= $this->makePartial('maparea/conditions', ['area' => $area, 'areaIndex' => $index]) ?>
            </div>
        </div>
    </div>
</div>
