<input type="hidden" data-media-type="current-folder" value="<?= e($currentFolder) ?>"/>

<?php if (count($totalItems)) { ?>
    <?= $this->makePartial('mediamanager/list_grid') ?>
<?php } else { ?>
    <p><?php echo lang('admin::lang.text_empty'); ?></p>
<?php } ?>
