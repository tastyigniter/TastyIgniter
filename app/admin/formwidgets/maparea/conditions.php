<div
    id="<?= $this->getId('area-'.$areaIndex.'-conditions') ?>"
    data-control="condition-list"
    data-last-counter="<?= count($area['conditions']) ?>"
    data-template="#condition-template"
    data-parent-row="<?= $areaIndex ?>">

    <div class="table-responsive wrap-none">
        <table class="table table-striped is-sortable">
            <thead>
            <tr>
                <th class="list-action"></th>
                <th><?= lang('label_area_charge'); ?></th>
                <th width="50%"><?= lang('label_charge_condition'); ?></th>
                <th><?= lang('label_area_min_amount'); ?></th>
            </tr>
            </thead>
            <tbody data-append-to>
            <?php $index = 0;
            foreach ($area['conditions'] as $key => $condition) { ?>
                <?php $index++; ?>
                <?= $this->makePartial('maparea/condition', [
                    'condition' => $condition,
                    'areaIndex' => $areaIndex,
                    'index'     => $index,
                ]) ?>
            <?php } ?>
            </tbody>
            <tfoot>
            <tr id="tfoot">
                <td class="list-action text-center">
                    <a
                        class="btn btn-primary btn-xs"
                        data-control="add-row"
                        data-parent="#<?= $this->getId('area-'.$areaIndex.'-conditions') ?>">
                        <i class="fa fa-plus"></i>
                    </a>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
