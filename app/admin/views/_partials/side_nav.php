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

    <?= AdminMenu::render([
        'openTag'  => '<ul class="nav nav-sidebar navbar-collapse" id="side-menu">',
        'closeTag' => '</ul>',
    ]); ?>

    <div class="hidden-xs sidebar-toggle">
        <a>
            <i class="fa fa-chevron-circle-left fa-fw"></i>
            <span class="content"><?= lang('admin::default.menu_collapse'); ?></span>
        </a>
    </div>
</div>
