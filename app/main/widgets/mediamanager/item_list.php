<input type="hidden" data-media-type="current-folder" value="<?= e($currentFolder) ?>"/>

<?php if ($items) { ?>
    <?= $this->makePartial('mediamanager/list_grid') ?>
<?php } else { ?>
    <p><?php echo lang('admin::lang.text_empty'); ?></p>
<?php } ?>
