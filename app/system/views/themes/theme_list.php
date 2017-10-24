<?php if (count($records)) { ?>
    <?php foreach ($records as $theme) { ?>
    <?php
        if (!$theme->themeClass) continue;
    ?>
        <div class="col-xs-12 col-sm-6 wrap-bottom">
        <div class="panel panel-theme">
            <div class="theme-label">
                <?php if ($theme->themeClass->isActive()) { ?>
                    <span class="activated" title="<?= lang('system::themes.text_is_default'); ?>"></span>
                <?php } ?>

                <?php if ($theme->themeClass->isChild()) { ?>
                    <span class="child-theme" title="<?= lang('system::themes.text_is_child'); ?>"></span>
                <?php } ?>
            </div>
            <div class="panel-body">
                <div class="media">
                    <a class="media-left preview-thumb"
                       data-toggle="modal"
                       data-target="#theme-preview-<?= $theme->code; ?>"
                       data-img-src="<?= URL::asset($theme->themeClass->screenshot); ?>">
                        <img class="img-rounded"
                             alt=""
                             src="<?= URL::asset($theme->themeClass->screenshot); ?>"
                             style="width:150px!important;height:214px!important"/>
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?= $theme->name; ?></h4>
                        <p class="description text-muted"><?= $theme->description; ?></p>
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
                        <div class="buttons action">

                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('edit')]) ?>

                            <?php
                            $column = $this->getColumn('default');
                            if ($theme->themeClass->isActive()) {
                                $column->cssClass = $column->cssClass.' disabled';
                                $column->attributes['title'] = 'lang:text_is_default';
                            }
                            ?>
                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('default')]) ?>

                            <?php if (!$theme->themeClass->isChild()) { ?>
                                <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('copy')]) ?>
                            <?php } ?>

                            <?= $this->makePartial('lists/list_button', ['record' => $theme, 'column' => $this->getColumn('delete')]) ?>
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