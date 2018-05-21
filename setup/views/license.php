<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5><?= lang('text_license_sub_heading'); ?></h5>
        </div>
        <div class="modal-body panel-license">
            <input type="hidden" name="license_agreed" value="1">
            <?= nl2br(file_get_contents(BASEPATH.'/LICENSE.txt')); ?>
        </div>

        <div class="modal-footer">
            <a
                class="btn btn-success pull-right"
                data-install-control="accept-license"
            ><?= lang('button_accept') ?></a>
        </div>
    </div>
</div>
