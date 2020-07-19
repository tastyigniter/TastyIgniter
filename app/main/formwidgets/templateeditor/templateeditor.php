<?php if (!$this->previewMode) { ?>
    <div
        id="<?= $this->getId() ?>"
        class="control-template-editor progress-indicator-container"
        data-control="template-editor"
        data-alias="<?= $this->alias ?>"
    >
        <?php
        $fieldValue = $field->value;
        $fieldPlaceholder = $this->placeholder;
        $selectedType = array_get($fieldValue, 'type') ?? '_pages';
        $selectedFile = array_get($fieldValue, 'file');
        $selectedTypeLabel = str_singular(lang($templateTypes[$selectedType]));
        ?>
        <div class="form-row">
            <div class="col-sm-2">
                <select
                    id="<?= $field->getId('type') ?>"
                    name="<?= $field->getName() ?>[type]"
                    class="form-control"
                    data-template-control="choose-type"
                    data-request="onChooseFile"
                    data-progress-indicator="<?= lang('admin::lang.text_loading') ?>"
                >
                    <?php foreach ($templateTypes as $value => $label) { ?>
                        <option
                            value="<?= $value; ?>"
                            <?= $value == $selectedType ? 'selected="selected"' : '' ?>
                        ><?= lang($label); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-10">
                <div
                    class="input-group" data-toggle="modal"
                    data-target="#<?= $this->getId('form-modal') ?>"
                >
                    <select
                        id="<?= $field->getId('file') ?>"
                        name="<?= $field->getName() ?>[file]"
                        class="form-control"
                        data-template-control="choose-file"
                        data-request="onChooseFile"
                        data-progress-indicator="<?= lang('admin::lang.text_loading') ?>"
                    >
                        <?php if ($fieldPlaceholder) { ?>
                            <option
                                value=""
                            ><?= e(sprintf(lang($fieldPlaceholder), strtolower($selectedTypeLabel))) ?></option>
                        <?php } ?>
                        <?php foreach ($fieldOptions as $value => $option) { ?>
                            <?php if (!is_array($option)) $option = [$option]; ?>
                            <option
                                <?= $value == $selectedFile ? 'selected="selected"' : '' ?>
                                <?php if (isset($option[1])): ?>data-<?= strpos($option[1], '.') ? 'image' : 'icon' ?>="<?= $option[1] ?>"<?php endif ?>
                                value="<?= $value ?>"
                            ><?= e(is_lang_key($option[0]) ? lang($option[0]) : $option[0]) ?></option>
                        <?php } ?>
                    </select>
                    <div class="input-group-append ml-1">
                        <button
                            type="button"
                            class="btn btn-outline-default"
                            data-toggle="modal"
                            data-target="#<?= $this->getId('modal') ?>"
                            data-modal-title="<?= e(sprintf(lang($this->addLabel), $selectedTypeLabel)) ?>"
                            data-modal-source-action="new"
                            data-modal-source-name=""
                        ><i class="fa fa-plus"></i>&nbsp;&nbsp;<?= e(sprintf(lang($this->addLabel), $selectedTypeLabel)) ?>
                        </button>
                        <?php if (!empty($selectedFile)) { ?>
                            <button
                                type="button"
                                class="btn btn-outline-default"
                                data-toggle="modal"
                                data-target="#<?= $this->getId('modal') ?>"
                                data-modal-title="<?= e(sprintf(lang($this->editLabel), $selectedTypeLabel)) ?>"
                                data-modal-source-action="rename"
                                data-modal-source-name="<?= $selectedFile; ?>"
                            ><i class="fa fa-pencil"></i>&nbsp;&nbsp;<?= e(sprintf(lang($this->editLabel), $selectedTypeLabel)) ?>
                            </button>
                            <button
                                type="button"
                                class="btn btn-outline-danger"
                                title="<?= e(sprintf(lang($this->deleteLabel), $selectedTypeLabel)) ?>"
                                data-request="onManageSource"
                                data-request-data="action: 'delete'"
                                data-request-confirm="<?= lang('admin::lang.alert_warning_confirm') ?>"
                                data-progress-indicator="<?= lang('admin::lang.text_deleting') ?>"
                            ><i class="fa fa-trash"></i></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->makePartial('templateeditor/modal'); ?>
    </div>
<?php } ?>
