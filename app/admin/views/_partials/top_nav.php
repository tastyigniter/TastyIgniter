<?php
$isLogged = AdminAuth::isLogged();
$systemLogo = image_url('tastyigniter-logo.png');
$systemName = lang('system::default.tastyigniter.system_name');
?>
<?php if ($isLogged) { ?>
    <nav class="navbar navbar-top navbar-expand navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-brand">
                <a class="logo" href="<?= admin_url('dashboard'); ?>">
                    <i class="logo-icon icon-ti-logo"></i>
                </a>
            </div>

            <div class="page-title">
                <span><?= Template::getHeading(); ?></span>
            </div>

            <div class="navbar navbar-right">
                <?= $this->widgets['mainmenu']->render(); ?>

                <button
                    type="button"
                    class="navbar-toggler"
                    data-toggle="collapse"
                    data-target="#navSidebar"
                    aria-controls="navSidebar"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="fa fa-bars"></span>
                </button>
            </div>
        </div>
    </nav>
<?php } ?>
