<div class="row-fluid">
    <?php foreach ($settings as $item => $categories) { ?>
        <?php
        if (!count($categories)) continue;
        ?>
        <div class="panel panel-light">
            <div class="panel-heading">
                <h5 class="panel-title"><?= ucwords($item) ?></h5>
            </div>
            <div class="list-group">
                <?php foreach ($categories as $key => $category) { ?>
                    <a
                        class="list-group-item list-group-item-action"
                        href="<?= $category->url ?>"
                        role="button"
                    >
                        <h5>
                            <?php if ($item == 'core' AND count(array_get($settingItemErrors, $category->code, []))) { ?>
                                <i
                                    class="text-danger fa fa-exclamation-triangle fa-fw"
                                    title="<?= lang('system::lang.settings.alert_settings_errors') ?>"
                                ></i>&nbsp;&nbsp;
                            <?php } else if ($category->icon) { ?>
                                <i class="text-muted <?= $category->icon ?> fa-fw"></i>&nbsp;&nbsp;
                            <?php } ?>
                            <?= e(strtoupper(lang($category->label))) ?>
                        </h5>
                        <p class="no-margin"><?= $category->description ? e(lang($category->description)) : '' ?></p>
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>

