<?php if (count($records)) { ?>
    <?php foreach ($records as $theme) { ?>
        <?php
        if (!$theme->themeClass) continue;
        ?>
        <div class="col-xs-12 wrap-bottom">
        <div class="panel panel-theme">
            <div class="theme-label">
                <?php if ($theme->themeClass->isActive()) { ?>
                    <span class="activated" title="<?= lang('system::themes.text_is_default'); ?>"></span>
                <?php } ?>
            </div>
            <div class="panel-body">
                <div class="media">
                    <a class="media-left preview-thumb"
                       data-toggle="modal"
                       data-target="#theme-preview-<?= $theme->code; ?>"
                       data-img-src="<?=  URL::asset($theme->themeClass->screenshot); ?>">
                        <img class="img-rounded"
                             alt=""
                             src="<?= URL::asset($theme->themeClass->screenshot); ?>"
                             style="width:250px;"/>
                    </a>
                    <div class="media-body wrap-left">
                        <h4 class="media-heading"><?= $theme->name; ?></h4>
                        <p class="description text-muted"><?= $theme->description; ?></p>
                        <div class="buttons action">

                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('source')]) ?>

                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('edit')]) ?>

                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('default')]) ?>

                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) ?>
                        </div>
                        <div class="row metas">
                            <div class="pull-left wrap-vertical text-muted text-sm">
                                <b><?= lang('system::themes.text_author'); ?>:</b><br/>
                                <?= $theme->themeClass->author; ?>
                            </div>
                            <div class="pull-left wrap-vertical text-muted text-sm text-left">
                                <b><?= lang('system::themes.text_version'); ?>:</b><br/>
                                <?= $theme->version; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (strlen($theme->themeClass->screenshot)) { ?>
            <div class="modal fade" id="theme-preview-<?= $theme->code; ?>">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                            <h4 class="modal-title">Preview Theme</h4>
                        </div>
                        <div class="modal-body wrap-none">
                            <img src="<?= $theme->themeClass->screenshot; ?>" width="100%"/>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>