<div class="panel panel-media border-none no-margin">
    <input type="hidden" data-media-type="current-folder" value="<?= e($currentFolder) ?>"/>

    <?php if (count($totalItems)) { ?>
        <?= $this->makePartial('mediamanager/list_grid') ?>
    <?php } else { ?>
        <p><?php echo lang('text_empty'); ?></p>
    <?php } ?>
    
</div>