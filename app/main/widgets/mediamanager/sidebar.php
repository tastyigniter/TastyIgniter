<div class="media-sidebar">
    <div data-media-preview-container></div>
</div>

<script type="text/template" data-media-single-selection-template>
    <div class="sidebar-preview-placeholder-container">
        <div class="sidebar-preview-toolbar">
            <div class="btn-group">
                <button
                    type="button"
                    class="btn btn-outline-default"
                    title="<?= lang('main::lang.media_manager.button_cancel'); ?>"
                    data-media-control="cancel-selection">
                    <i class="fa fa-times text-danger"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-outline-default"
                    title="<?= lang('main::lang.media_manager.button_rename'); ?>"
                    data-media-control="rename-item"
                    <?= (!$this->getSetting('rename')) ? 'disabled' : null ?>>
                    <i class="fa fa-pencil"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-outline-default"
                    title="<?= lang('main::lang.media_manager.button_move'); ?>"
                    data-media-control="move-item"
                    <?= (!$this->getSetting('move')) ? 'disabled' : null ?>>
                    <i class="fa fa-folder-open"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-outline-default"
                    title="<?= lang('main::lang.media_manager.button_copy'); ?>"
                    data-media-control="copy-item"
                    <?= (!$this->getSetting('copy')) ? 'disabled' : null ?>>
                    <i class="fa fa-clipboard"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-outline-danger"
                    title="<?= lang('main::lang.media_manager.button_delete'); ?>"
                    data-media-control="delete-item"
                    <?= (!$this->getSetting('delete')) ? 'disabled' : null ?>>
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="sidebar-preview-placeholder">
            <img class="img-responsive" src="{src}">
        </div>
        <div class="sidebar-preview-info">
            <p>{name}</p>
        </div>
        <div class="sidebar-preview-meta">
            <p><span class="small text-muted"><?= lang('main::lang.media_manager.label_dimension'); ?> </span>{dimension}
            </p>
            <p><span class="small text-muted"><?= lang('main::lang.media_manager.label_size'); ?> </span>{size}</p>
            <p><span class="small text-muted">URL </span><a href="{url}" target="_blank">Click here</a></p>
            <p><span class="small text-muted"><?= lang('main::lang.media_manager.label_modified_date'); ?> </span>{modified}
            </p>
        </div>
        <?php if ($chooseButton) { ?>
            <div class="sidebar-choose-btn">
                <button
                    class="btn btn-primary btn-block"
                    data-control="media-choose">
                    <?= lang($chooseButtonText); ?>
                </button>
            </div>
        <?php } ?>
    </div>
</script>

<script type="text/template" data-media-multi-selection-template>
    <div class="sidebar-preview-placeholder-container">
        <div class="sidebar-preview-toolbar">
            <div class="btn-group">
                <button
                    type="button"
                    class="btn btn-outline-default"
                    title="<?= lang('main::lang.media_manager.button_cancel'); ?>"
                    data-media-control="cancel-selection">
                    <i class="fa fa-times text-danger"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-outline-default"
                    title="<?= lang('main::lang.media_manager.button_move'); ?>"
                    data-media-control="move-item"
                    <?= (!$this->getSetting('move')) ? 'disabled' : null ?>>
                    <i class="fa fa-folder-open"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-outline-default"
                    title="<?= lang('main::lang.media_manager.button_copy'); ?>"
                    data-media-control="copy-item"
                    <?= (!$this->getSetting('copy')) ? 'disabled' : null ?>>
                    <i class="fa fa-clipboard"></i>
                </button>

                <button
                    type="button"
                    class="btn btn-outline-danger"
                    title="<?= lang('main::lang.media_manager.button_delete'); ?>"
                    data-media-control="delete-item"
                    <?= (!$this->getSetting('delete')) ? 'disabled' : null ?>>
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="sidebar-preview-placeholder">
            <i class="fa fa-clone fa-4x"></i>
        </div>
        <div class="sidebar-preview-info">
            <p class="fa-2x" data-media-total-size>{total}</p>
            <p><span class="text-muted small"><?= lang('main::lang.media_manager.text_items_selected'); ?></span></p>
        </div>
        <?php if ($chooseButton) { ?>
            <div class="sidebar-choose-btn">
                <button
                    class="btn btn-primary btn-block"
                    data-control="media-choose">
                    <?= lang($chooseButtonText); ?>
                </button>
            </div>
        <?php } ?>
    </div>
</script>

<script type="text/template" data-media-no-selection-template>
    <!--    --><? //= $this->makePartial('mediamanager/multi_preview_template') ?>
</script>
