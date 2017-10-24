<nav class="navbar navbar-media" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#media-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div id="media-navbar-collapse" class="navbar-collapse collapse">
            <div class="btn-toolbar" role="toolbar">
                <div class="toolbar-item pull-left">
                    <div class="btn-group">
                        <button
                            class="btn btn-default" type="button"
                            data-media-control="folder-tree">
                            <i class="fa fa-ellipsis-h"></i>
                        </button>
                        <button
                            class="btn btn-default" type="button"
                            data-media-control="refresh">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>

                    <div class="btn-group">
                        <?php if ($this->getSetting('uploads')) { ?>
                            <button
                                type="button" class="btn btn-primary"
                                data-media-control="upload">
                                <i class="fa fa-upload"></i>&nbsp;&nbsp;
                                <small><?= lang('form_widget_button_upload'); ?></small>
                            </button>
                        <?php } ?>
                    </div>

                    <div class="btn-group">
                        <?php if ($this->getSetting('new_folder')) { ?>
                            <button
                                class="btn btn-default" title="<?= lang('text_new_folder'); ?>"
                                data-media-control="new-folder">
                                <i class="fa fa-folder"></i>
                            </button>
                        <?php } ?>
                        <?php if ($this->getSetting('rename')) { ?>
                            <button
                                class="btn btn-default" title="<?= lang('text_rename_folder'); ?>"
                                data-media-control="rename-folder">
                                <i class="fa fa-pencil"></i>
                            </button>
                        <?php } ?>
                        <?php if ($this->getSetting('delete')) { ?>
                            <button
                                class="btn btn-danger" title="<?= lang('text_delete_folder'); ?>"
                                data-media-control="delete-folder">
                                <i class="fa fa-trash"></i>
                            </button>
                        <?php } ?>
                    </div>
                </div>

                <div class="toolbar-item pull-right">
                    <?= $this->makePartial('mediamanager/search') ?>
                </div>

                <div class="toolbar-item pull-right">
                    <?php if (!$isPopup) { ?>
                        <div class="btn-group">
                            <a class="btn btn-default btn-options"
                               href="<?= admin_url('settings/edit/media'); ?>">
                                <i class="fa fa-gears"></i>
                            </a>
                        </div>
                    <?php } ?>

                    <div class="btn-group">
                        <div class="dropdown">
                            <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Sort">
                                <?php if (isset($sortBy[1]) AND $sortBy[1] === 'ascending') { ?>
                                    <i class="fa fa-sort-amount-asc"></i> <i class="caret"></i>
                                <?php } else { ?>
                                    <i class="fa fa-sort-amount-desc"></i> <i class="caret"></i>
                                <?php } ?>
                            </a>
                            <?= $this->makePartial('mediamanager/sorting', ['sortBy', $sortBy]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
