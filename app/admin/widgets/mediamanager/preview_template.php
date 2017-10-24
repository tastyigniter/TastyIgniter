<div class="info">
    <div class="btn-group">
        <?php if ($file['type'] === 'img') { ?>
            <button type="button" class="btn btn-default btn-preview" title="<?= lang('button_preview'); ?>" data-url="<?= $file['img_url']; ?>"><i class="fa fa-eye"></i></button>
        <?php } else { ?>
            <button type="button" class="btn btn-default btn-preview" title="<?= lang('button_preview'); ?>" disabled="disabled" data-url="<?= $file['img_url']; ?>"><i class="fa fa-eye"></i></button>
        <?php } ?>
        <?php if ($rename) { ?>
            <button type="button" class="btn btn-default btn-rename" title="<?= lang('button_rename'); ?>" data-name="<?= $file['name']; ?>" data-path="<?= $sub_folder; ?>"><i class="fa fa-pencil"></i></button>
        <?php } ?>
        <?php if ($move) { ?>
            <button type="button" class="btn btn-default btn-move" title="<?= lang('button_move'); ?>"><i class="fa fa-folder-open"></i></button>
        <?php } ?>
        <?php if ($copy) { ?>
            <button type="button" class="btn btn-default btn-copy" title="<?= lang('button_copy'); ?>"><i class="fa fa-clipboard"></i></button>
        <?php } ?>
        <?php if ($delete) { ?>
            <button type="button" class="btn btn-default btn-delete" title="<?= lang('button_delete'); ?>"><i class="fa fa-trash"></i></button>
        <?php } ?>
    </div>
    <ul class="get_info">
        <li class="file-name">
            <span>Name :</span><?= $file['name']; ?>
        </li>
        <li class="file-size">
            <span><?= lang('label_size'); ?> :</span> <?= $file['size']; ?>
        </li>
        <li class="file-path">
            <span><?= lang('label_path'); ?> :</span> <?= '/'.$sub_folder; ?>
        </li>
        <?php if ($file['type'] === 'img') { ?>
            <li class="file-url"><span><?= lang('label_url'); ?> :</span>
                <input type="text" class="form-control url-control" readonly="readonly" value="<?= $file['img_url']; ?>"/>
            </li>
            <li class="img-dimension">
                <span><?= lang('label_dimension'); ?> :</span> <?= $file['img_dimension']; ?>
            </li>
        <?php } ?>
        <li class="file-date">
            <span><?= lang('label_modified_date'); ?> :</span> <?= $file['date']; ?>
        </li>
        <li class="file-extension">
            <span><?= lang('label_extension'); ?> :</span><em class="text-uppercase"><?= $file['ext']; ?></em>
        </li>
        <li class="file-permission">
            <span><?= lang('label_permission'); ?> :</span>
            <?php if ($file['perms'] === '04' OR $file['perms'] === '05') { ?>
                <?= lang('text_read_only'); ?>
            <?php } else if ($file['perms'] === '06' OR $file['perms'] === '07') { ?>
                <?= lang('text_read_write'); ?>
            <?php } else { ?>
                <?= lang('text_no_access'); ?>
            <?php } ?>
        </li>
    </ul>
</div>
