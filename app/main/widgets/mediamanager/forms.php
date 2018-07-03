<script type="text/template" data-media-new-folder-form>
    <form method="POST" accept-charset="UTF-8">
        <div class="form-group">
            <label><?= e(lang('main::lang.media_manager.text_folder_name')) ?></label>
            <input type="text" class="form-control" name="name"/>
        </div>
    </form>
</script>

<script type="text/template" data-media-rename-folder-form>
    <form method="POST" accept-charset="UTF-8">
        <div class="form-group">
            <label><?= e(lang('main::lang.media_manager.text_folder_name')) ?></label>
            <input type="text" class="form-control" name="name"/>
        </div>
    </form>
</script>

<script type="text/template" data-media-rename-file-form>
    <form method="POST" accept-charset="UTF-8">
        <div class="form-group">
            <label><?= e(lang('main::lang.media_manager.text_file_name')) ?></label>
            <input type="text" class="form-control" name="name"/>
        </div>
    </form>
</script>

<script type="text/template" data-media-move-folder-form>
    <form method="POST" accept-charset="UTF-8">
        <div class="form-group">
            <label><?= e(lang('main::lang.media_manager.text_destination_folder')) ?></label>
            <select name="destination" class="form-control">
                <option value=""><?= e(lang('admin::lang.text_please_select')) ?></option>
                <?php foreach ($folderList as $key => $value) { ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </form>
</script>

<script type="text/template" data-media-move-file-form>
    <form method="POST" accept-charset="UTF-8">
        <div class="form-group">
            <label><?= e(lang('main::lang.media_manager.text_destination_folder')) ?></label>
            <select name="destination" class="form-control">
                <option value=""><?= e(lang('admin::lang.text_please_select')) ?></option>
                <?php foreach ($folderList as $key => $value) { ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </form>
</script>

<script type="text/template" data-media-delete-folder-form>
    <form method="POST" accept-charset="UTF-8">
        <p><b><?= e(lang('admin::lang.alert_warning_confirm')) ?></b></p>
    </form>
</script>

<script type="text/template" data-media-delete-file-form>
    <form method="POST" accept-charset="UTF-8">
        <p><b><?= e(lang('admin::lang.alert_warning_confirm')) ?></b></p>
    </form>
</script>

<script type="text/template" data-media-copy-file-form>
    <form method="POST" accept-charset="UTF-8">
        <div class="form-group">
            <label><?= e(lang('main::lang.media_manager.text_destination_folder')) ?></label>
            <select name="destination" class="form-control">
                <option value=""><?= e(lang('admin::lang.text_please_select')) ?></option>
                <?php foreach ($folderList as $key => $value) { ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                <?php } ?>
            </select>
        </div>
    </form>
</script>
