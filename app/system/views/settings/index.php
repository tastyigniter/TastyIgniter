<div class="row-fluid">
    <div class="card card-light">
        <?php foreach ($settings as $item => $categories) { ?>
            <?php
            if (!count($categories)) continue;
            ?>
            <div class="card-header">
                <h5 class="card-title mb-0"><?= ucwords($item) ?></h5>
            </div>
            <div class="list-group list-group-flush shadow-sm">
                <?php foreach ($categories as $key => $category) { ?>
                    <a
                        class="list-group-item list-group-item-action"
                        href="<?= $category->url ?>"
                        role="button"
                    >
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <?php if ($item == 'core' AND count(array_get($settingItemErrors, $category->code, []))) { ?>
                                    <i
                                        class="text-danger fa fa-exclamation-triangle fa-fw h5"
                                        title="<?= lang('system::lang.settings.alert_settings_errors') ?>"
                                    ></i>
                                <?php } elseif ($category->icon) { ?>
                                    <i class="text-muted <?= $category->icon ?> fa-fw h5"></i>
                                <?php } else { ?>
                                    <i class="text-muted fa fa-puzzle-piece fa-fw h5"></i>
                                <?php } ?>
                            </div>
                            <div class="">
                                <h5><?= e(lang($category->label)); ?></h5>
                                <p class="no-margin"><?= $category->description ? e(lang($category->description)) : '' ?></p>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

