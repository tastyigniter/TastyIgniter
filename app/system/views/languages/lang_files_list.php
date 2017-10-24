<?php
$options = $field->options();
?>

<?php foreach ($options as $type => $files) { ?>
    <h4 class="text-capitalize"><?= $type; ?>&nbsp;&nbsp;&nbsp;&nbsp;<span class="small text-lowercase"><small><?= count($files); ?> <?= lang('text_files'); ?></small></span>
    </h4>

    <div class="row">
        <?php foreach ($files as $file) { ?>
            <div class="col-sm-4 wrap-bottom">
                <a
                    href="<?= admin_url("languages/edit/{$file['id']}?domain={$file['path']}&file={$file['name']}"); ?>">
                    <?= $file['name']; ?>
                </a>
            </div>
        <?php } ?>
    </div>
<?php } ?>
