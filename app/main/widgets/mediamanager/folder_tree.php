<div class="folder-tree hide"
     data-tree-data="<?= e(json_encode($folderTree)); ?>">
    <button>
        Go to root folder
    </button>
</div>
<select class="hide">
    <option value=""><?= e(lang('admin::lang.text_please_select')) ?></option>
    <?php foreach ($folderList as $key => $value) { ?>
        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
    <?php } ?>
</select>
