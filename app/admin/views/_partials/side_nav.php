<?php
$systemLogo = image_url('tastyigniter-logo.png');
$systemName = lang('system::default.tastyigniter.system_name');
?>
<div class="sidebar" role="navigation">
    <div class="navbar-brand">
        <a class="logo" href="<?= admin_url('dashboard'); ?>">
            <img class="logo-image"
                 alt="<?= $systemName; ?>"
                 title="<?= $systemName; ?>"
                 src="<?= $systemLogo; ?>"
                 height="45"/>
        </a>
    </div>

    <?= $this->makePartial('side_nav_items', [
        'cssClass' => 'nav nav-sidebar navbar-collapse',
        'navItems' => $navItems,
    ]) ?>

    <div class="hidden-xs sidebar-toggle">
        <a
            data-toggle="sidebar"
            role="button"
        >
            <i class="fa fa-chevron-circle-left fa-fw"></i>
            <span class="content"><?= lang('admin::default.menu_collapse'); ?></span>
        </a>
    </div>
</div>
