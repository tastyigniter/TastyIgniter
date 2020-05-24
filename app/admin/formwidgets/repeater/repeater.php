<div
    class="control-repeater"
    data-control="repeater"
    data-append-to="#<?= $this->getId('append-to') ?>"
    data-sortable-container="#<?= $this->getId('sortable') ?>"
    data-sortable-handle=".<?= $this->getId('items') ?>-handle">

    <div id="<?= $this->getId('items') ?>" class="repeater-items">
        <div class="table-responsive">
            <table
                id="<?= $this->getId('sortable') ?>"
                class="table <?= ($sortable) ? 'is-sortable' : '' ?> mb-0">
                <thead>
                <tr>
                    <?php if (!$this->previewMode AND $sortable) { ?>
                        <th class="list-action"></th>
                    <?php } ?>
                    <?php if (!$this->previewMode AND $showRemoveButton) { ?>
                        <th class="list-action"></th>
                    <?php } ?>
                    <?php foreach ($this->getVisibleColumns() as $name => $label) { ?>
                        <th><?= $label ? e(lang($label)) : '' ?></th>
                    <?php } ?>
                </tr>
                </thead>
                <tbody id="<?= $this->getId('append-to') ?>">
                <?php if ($this->formWidgets) { ?>
                    <?php foreach ($this->formWidgets as $index => $widget) { ?>
                        <?= $this->makePartial('repeater/repeater_item', [
                            'widget' => $widget,
                            'indexValue' => $index,
                        ]) ?>
                    <?php } ?>
                <?php } else { ?>
                    <tr class="repeater-item-placeholder">
                        <td colspan="99" class="text-center"><?= is_lang_key($emptyMessage) ? lang($emptyMessage) : $emptyMessage ?></td>
                    </tr>
                <?php } ?>
                </tbody>
                <?php if ($showAddButton AND !$this->previewMode) { ?>
                    <tfoot>
                    <tr>
                        <th colspan="99">
                            <div class="list-action">
                                <button
                                    class="btn btn-primary"
                                    data-control="add-item"
                                    type="button">
                                    <i class="fa fa-plus"></i>
                                    <?= $prompt ? e(lang($prompt)) : '' ?>
                                </button>
                            </div>
                        </th>
                    </tr>
                    </tfoot>
                <?php } ?>
            </table>
        </div>
    </div>

    <script
        type="text/template"
        data-find="<?= $indexSearch ?>"
        data-replace="<?= $nextIndex ?>"
        data-repeater-template>
        <?= $this->makePartial('repeater/repeater_item', ['widget' => $widgetTemplate, 'indexValue' => $indexSearch]) ?>
    </script>
</div>
