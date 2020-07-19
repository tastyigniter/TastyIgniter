<?php foreach ($records ?? [] as $theme) { ?>
    <?php if (!$theme->getTheme()) { ?>
        <div class="row mb-3">
            <div class="media bg-light p-4 w-100 border border-danger text-danger">
                <a class="media-left align-self-center mr-4 preview-thumb"
                   style="width:200px;">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?= $theme->name; ?></h4>
                    <p class="description"><?= lang('system::lang.themes.error_config_no_found') ?></p>
                    <div class="buttons action my-4">
                        <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="row mb-3">
            <div class="media bg-light p-4 w-100">
                <a class="media-left align-self-center mr-4 preview-thumb"
                   data-toggle="modal"
                   data-target="#theme-preview-<?= $theme->code; ?>"
                   data-img-src="<?= URL::asset($theme->screenshot); ?>"
                   style="width:200px;">
                    <img
                        class="img-responsive img-rounded"
                        alt=""
                        src="<?= URL::asset($theme->screenshot); ?>"/>
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?= $theme->name; ?></h4>
                    <p class="description text-muted"><?= $theme->description; ?></p>
                    <div class="buttons action my-4">
                        <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('source')]) ?>

                        <?php if ($theme->getTheme()->hasCustomData()) { ?>
                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('edit')]) ?>
                        <?php } ?>

                        <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('default')]) ?>

                        <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) ?>
                    </div>
                    <div class="row metas align-self-end">
                        <div class="pull-left wrap-vertical text-muted text-sm">
                            <b><?= lang('system::lang.themes.text_author'); ?>:</b><br/>
                            <?= $theme->author; ?>
                        </div>
                        <div class="pull-left wrap-vertical text-muted text-sm text-left">
                            <b><?= lang('system::lang.themes.text_version'); ?>:</b><br/>
                            <?= $theme->version; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (strlen($theme->screenshot)) { ?>
                <div class="modal fade" id="theme-preview-<?= $theme->code; ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Preview Theme</h4>
                                <button type="button" class="close" data-dismiss="modal"
                                        aria-hidden="true">X</button>
                            </div>
                            <div class="modal-body wrap-none">
                                <img src="<?= $theme->screenshot; ?>" width="100%"/>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
<?php } ?>
