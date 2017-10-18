<div class="panel panel-default panel-license">
    <div
        class="panel-heading"
        data-toggle="collapse"
        data-target="#license-body"
    >
        <?= lang('text_license_sub_heading'); ?>
    </div>
    <div id="license-body" class="panel-body collapse">
        <input type="hidden" name="license_agreed" value="1">
        <?= nl2br(file_get_contents('license.txt')); ?>
    </div>
</div>

