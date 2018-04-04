<div class="panel-license">
    <h5><?= lang('text_license_sub_heading'); ?></h5>
    <input type="hidden" name="license_agreed" value="1">
    <?= nl2br(file_get_contents('license.txt')); ?>
</div>

<div class="buttons">
    <a
        class="btn btn-success pull-right"
        data-install-control="accept-license"
    ><?= lang('button_accept') ?></a>
</div>