<?php
$isLogged = AdminAuth::isLogged();
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

    <div id="navSidebar" class="nav-sidebar">
        <?= $this->makePartial('side_nav_items', [
            'navItems'      => $navItems,
            'navAttributes' => [
                'id'    => 'side-nav-menu',
                'class' => 'nav',
            ],
        ]) ?>
    </div>
</div>
