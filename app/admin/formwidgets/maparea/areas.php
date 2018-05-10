<div
    data-control="area-list"
    data-last-counter="<?= count($areas) ?>"
    data-template="#area-template">

    <div class="panel-group panel-area-group">
        <div class="panel">
            <div class="panel-header">
                <h5 class="panel-title"><?php echo lang('admin::locations.text_delivery_area'); ?></h5>
            </div>
            <div
                id="<?= $this->getId('areas') ?>"
                class="panel-body panel-area-body"
                role="tablist"
                aria-multiselectable="true"
                data-append-to
            >
                <?php foreach ($areas as $index => $area) { ?>
                    <?= $this->makePartial('maparea/area_panel', ['area' => $area, 'index' => $index]) ?>
                <?php } ?>
            </div>

            <div class="panel-footer">
                <button
                    type="button"
                    class="btn btn-default"
                    data-control="add-panel">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;<?= $prompt ? e(lang($prompt)) : '' ?>
                </button>
            </div>
        </div>
    </div>
</div>
<script type="text/template" id="area-template">
    <?= $this->makePartial('maparea/area_panel', [
        'area'  => $emptyArea,
        'index' => '%%index%%',
    ]) ?>
</script>

<script type="text/template" id="condition-template">
    <?= $this->makePartial('maparea/condition', [
        'condition' => $emptyCondition,
        'areaIndex' => '%%row%%',
        'index'     => '%%index%%',
    ]) ?>
</script>
