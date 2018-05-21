<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            <h4 class="modal-title">Previously installed site found in the database.</h4>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <p>Your existing site data will be updated.</p>
            </div>
            <input type="hidden" name="upgrade" value="1">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('button_cancel'); ?></button>
            <button type="submit" class="btn btn-success"><?= lang('button_continue'); ?></button>
        </div>
    </div>
</div>
