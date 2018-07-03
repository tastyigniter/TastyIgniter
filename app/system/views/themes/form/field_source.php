<?php
$fieldOptions = $field->options();
$useSearch = $field->getConfig('showSearch', FALSE);
$fieldValue = $field->value;
?>
<?php if ($this->previewMode) { ?>
    <div class="form-control-static"><?= (isset($fieldOptions[$field->value])) ? e(lang($fieldOptions[$field->value])) : '' ?></div>
<?php } else { ?>
    <div class="input-group">
            <select
                id="<?= $field->getId() ?>"
                name="<?= $field->getName() ?>"
                class="form-control"
                <?= $field->getAttributes() ?>>

                <?php if ($field->placeholder) { ?>
                    <option value=""><?= e(lang($field->placeholder)) ?></option>
                <?php } ?>
                <?php foreach ($fieldOptions as $value => $option) { ?>
                    <?php
                    if (!is_array($option)) $option = [$option];
                    ?>
                    <option
                        <?= $value == $fieldValue ? 'selected="selected"' : '' ?>
                        <?php if (isset($option[1])): ?>data-<?= strpos($option[1], '.') ? 'image' : 'icon' ?>="<?= $option[1] ?>"<?php endif ?>
                        value="<?= $value ?>">
                        <?= e((sscanf($option[0], 'lang:%s', $line) === 1) ? lang($line) : $option[0]) ?>
                    </option>
                <?php } ?>
            </select>
        <div class="input-group-prepend ml-1">
            <button
                type="button"
                class="btn btn-outline-default"
                data-toggle="modal"
                data-target="#<?= $field->getId('modal') ?>"
                data-modal-title="<?= lang('system::lang.themes.text_new_source_title') ?>"
                data-modal-source-action="new"
                data-modal-source-name=""
            ><?= lang('system::lang.themes.button_new_source') ?></button>
            <?php if (!empty($field->value)) { ?>
                <button
                    type="button"
                    class="btn btn-outline-default"
                    data-toggle="modal"
                    data-target="#<?= $field->getId('modal') ?>"
                    data-modal-title="<?= lang('system::lang.themes.text_rename_source_title') ?>"
                    data-modal-source-action="rename"
                    data-modal-source-name="<?= $fieldValue; ?>"
                ><?= lang('system::lang.themes.button_rename_source') ?></button>
                <button
                    type="button"
                    class="btn btn-outline-danger"
                    data-request="onDelete"
                    data-request-form="#edit-form"
                    data-request-confirm="<?= lang('admin::lang.alert_warning_confirm') ?>"
                ><i class="fa fa-trash"></i></button>
            <?php } ?>
        </div>
    </div>
    <div
        id="<?= $field->getId('modal') ?>"
        class="modal show"
        tabindex="-1"
        role="dialog"
        aria-labelledby="newSourceModal"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4
                        class="modal-title"
                        data-modal-text="title"
                    ></h4>
                </div>
                <form method="POST" accept-charset="UTF-8">
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?= e(lang('system::lang.themes.label_file')) ?></label>
                            <input data-modal-input="source-name" type="text" class="form-control" name="name"/>
                            <input data-modal-input="source-action" type="hidden" name="action"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                        ><?= lang('admin::lang.button_close') ?></button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            data-request="onManageSource"
                            data-request-before-update="$(this).closest('.modal').modal('hide')"
                        ><?= lang('admin::lang.button_save') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
