<?php $fieldOptions = $field->value;
$weekdays = $formModel->getWeekDaysOptions();
?>
<div class="field-flexible-hours">
    <div class="table-responsive">
        <table class="table table-stripped">
            <thead>
            <tr>
                <th></th>
                <th><?= lang('admin::locations.label_open_hour'); ?></th>
                <th><?= lang('admin::locations.label_close_hour'); ?></th>
                <th><?= lang('admin::locations.label_opening_status'); ?></th>
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
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input
                                type="text"
                                name="<?= $field->getName() ?>[<?= $index; ?>][open]"
                                class="form-control"
                                autocomplete="off"
                                value="<?= $hour['open'] ?>"
                                <?= $field->getAttributes() ?> />
                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input
                                type="text"
                                name="<?= $field->getName() ?>[<?= $index; ?>][close]"
                                class="form-control"
                                autocomplete="off"
                                value="<?= $hour['close'] ?>"
                                <?= $field->getAttributes() ?> />
                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                        </div>
                    </td>
                    <td>
                        <input
                            type="hidden"
                            name="<?= $field->getName() ?>[<?= $index; ?>][status]"
                            value="0"
                            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>>

                        <div class="field-switch">
                            <input
                                type="checkbox"
                                name="<?= $field->getName() ?>[<?= $index; ?>][status]"
                                data-toggle="toggle"
                                data-onstyle="success" data-offstyle="danger"
                                data-on="<?= e(lang('admin::locations.text_open')) ?>"
                                data-off="<?= e(lang('admin::locations.text_closed')) ?>"
                                value="1"
                                <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                                <?= $hour['status'] == 1 ? 'checked="checked"' : '' ?>
                                <?= $field->getAttributes() ?>>
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
