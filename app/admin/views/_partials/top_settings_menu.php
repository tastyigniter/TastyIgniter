<?php
$itemOptions = $item->options();
$updatesCount = $item->unreadCount();
$hasSettingsError = count(array_filter(Session::get('settings.errors', [])));
?>
<li class="nav-item dropdown">
    <a class="nav-link" href="" data-toggle="dropdown">
        <i class="fa fa-gears" role="button"></i>
        <?php if ($hasSettingsError) { ?>
            <span class="badge badge-danger"><i class="fa fa-exclamation text-white"></i></span>
        <?php } else if ($updatesCount) { ?>
            <span class="badge badge-danger"><?= e($updatesCount); ?></span>
        <?php } ?>
    </a>

    <ul class="dropdown-menu">
        <div class='menu menu-grid row'>
            <?php foreach ($itemOptions as $label => $value) { ?>
                <?php list($icon, $link) = $value; ?>
                <div class="menu-item col col-4">
                    <a class="menu-link" href="<?= $link; ?>">
                        <i class="<?= $icon; ?>"></i>
                        <span><?= e(lang($label)); ?></span>
                    </a>
                </div>
            <?php } ?>
        </div>
        <?php if (!$hasSettingsError AND $updatesCount) { ?>
            <a
                class="dropdown-item border-top text-center alert-warning"
                href="<?= admin_url('updates'); ?>"
            ><?= sprintf(lang('system::lang.updates.text_update_found'), $updatesCount); ?></a>
        <?php } ?>
        <div class="dropdown-footer">
            <a class="text-center<?= $hasSettingsError ? ' text-danger' : '' ?>" href="<?= admin_url('settings'); ?>"><i class="fa fa-ellipsis-h"></i></a>
        </div>
    </ul>
</li>
