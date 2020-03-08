<?php
use \Admin\Classes\UserState;

$staffState = \Admin\Classes\UserState::forUser();
$statusOptions = UserState::getStatusDropdownOptions();
$clearAfterMinutesOptions = UserState::getClearAfterMinutesDropdownOptions();
$selectedStatus = $staffState->getStatus();
$selectedClearAfterMinutes = $staffState->getClearAfterMinutes();
$statusUpdatedAt = $staffState->getUpdatedAt();
$statusMessage = $staffState->getMessage();
?>
<div
    class="modal fade"
    id="editStaffStatusModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="editStaffStatusModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= lang('admin::lang.staff_status.text_set_status'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form
                method="POST"
                accept-charset="UTF-8"
                data-request="mainmenu::onSetUserStatus"
                data-request-success="jQuery('#editStaffStatusModal').modal('hide')"
            >
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="status">
                            <?php foreach ($statusOptions as $key => $column) { ?>
                                <option
                                    value="<?= $key; ?>"
                                    <?= $key == $selectedStatus ? 'selected="selected"' : ''; ?>
                                ><?= lang($column); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div
                        class="form-group"
                        data-trigger="[name='status']"
                        data-trigger-action="show"
                        data-trigger-condition="value[4]"
                        data-trigger-closest-parent="form"
                    >
                        <input
                            type="text"
                            class="form-control"
                            name="message"
                            value="<?= $statusMessage ?>"
                            placeholder="<?= lang('admin::lang.staff_status.text_lunch_break'); ?>"
                        >
                    </div>
                    <div
                        class="form-group"
                        data-trigger="[name='status']"
                        data-trigger-action="show"
                        data-trigger-condition="value[4]"
                        data-trigger-closest-parent="form"
                    >
                        <select class="form-control" name="clear_after" id="staffClearStatusAfter">
                            <?php foreach ($clearAfterMinutesOptions as $key => $column) { ?>
                                <option
                                    value="<?= $key; ?>"
                                    <?= $key == $selectedClearAfterMinutes ? 'selected="selected"' : ''; ?>
                                ><?= lang($column); ?></option>
                            <?php } ?>
                        </select>
                        <?php if ($statusUpdatedAt) { ?>
                            <span class="help-block"><?= time_elapsed($statusUpdatedAt); ?></span>
                        <?php } ?>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button
                        type="button"
                        class="btn btn-link"
                        data-dismiss="modal"
                    ><?= lang('admin::lang.button_close') ?></button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                    ><?= lang('admin::lang.button_save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>