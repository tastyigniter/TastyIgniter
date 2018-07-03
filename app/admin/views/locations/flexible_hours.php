<?php $fieldOptions = $field->value;
$weekdays = $formModel->getWeekDaysOptions();
?>
<div class="field-flexible-hours">
    <div class="row">
        <div class="col-sm-7">
            <div class="table-responsive">
                <table class="table table-stripped">
                    <thead>
                    <tr>
                        <th></th>
                        <th><?= lang('admin::lang.locations.label_open_hour'); ?></th>
                        <th><?= lang('admin::lang.locations.label_close_hour'); ?></th>
                        <th><?= lang('admin::lang.locations.label_opening_status'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $index = 0;
                    foreach ($weekdays as $key => $day) { ?>
                        <?php
                        $hour = (isset($fieldOptions[$key])) ? $fieldOptions[$key] : ['day' => $key, 'open' => '00:00', 'close' => '23:59', 'status' => 1]
                        ?>
                        <tr>
                            <td>
                                <span><?= $day; ?></span>
                                <input
                                    type="hidden"
                                    name="<?= $field->getName(); ?>[<?= $index; ?>][day]"
                                    value="<?= $hour['day']; ?>"/>
                            </td>
                            <td>
                                <div class="input-group" data-control="clockpicker" data-autoclose="true">
                                    <input
                                        type="text"
                                        name="<?= $field->getName() ?>[<?= $index; ?>][open]"
                                        class="form-control"
                                        autocomplete="off"
                                        value="<?= $hour['open'] ?>"
                                        <?= $field->getAttributes() ?> />
                                    <span class="input-group-prepend">
                                <span class="input-group-icon"><i class="fa fa-clock-o"></i></span>
                            </span>
                                </div>
                            </td>
                            <td>
                                <div class="input-group" data-control="clockpicker" data-autoclose="true">
                                    <input
                                        type="text"
                                        name="<?= $field->getName() ?>[<?= $index; ?>][close]"
                                        class="form-control"
                                        autocomplete="off"
                                        value="<?= $hour['close'] ?>"
                                        <?= $field->getAttributes() ?> />
                                    <span class="input-group-prepend">
                                <span class="input-group-icon"><i class="fa fa-clock-o"></i></span>
                            </span>
                                </div>
                            </td>
                            <td>
                                <input
                                    type="hidden"
                                    name="<?= $field->getName() ?>[<?= $index; ?>][status]"
                                    value="0"
                                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                                >
                                <div
                                    class="field-switch"
                                    data-control="switch"
                                >
                                    <input
                                        type="checkbox"
                                        name="<?= $field->getName() ?>[<?= $index; ?>][status]"
                                        id="<?= $field->getId($index.'status') ?>"
                                        class="field-switch-input"
                                        value="1"
                                        <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                                        <?= $hour['status'] == 1 ? 'checked="checked"' : '' ?>
                                        <?= $field->getAttributes() ?>
                                    >
                                    <label
                                        class="field-switch-label"
                                        for="<?= $field->getId($index.'status') ?>"
                                    >
                                <span class="field-switch-container">
                                    <span class="field-switch-active">
                                        <span class="field-switch-toggle bg-success"><?= e(lang('admin::lang.locations.text_open')) ?></span>
                                    </span>
                                    <span class="field-switch-inactive">
                                        <span class="field-switch-toggle bg-danger"><?= e(lang('admin::lang.locations.text_closed')) ?></span>
                                    </span>
                                </span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        <?php
                        $index++;
                        ?>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
