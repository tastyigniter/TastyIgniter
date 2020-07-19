<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <?= get_metas(); ?>
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <?= get_favicon(); ?>
    <title><?= sprintf(lang('admin::lang.site_title'), Template::getTitle(), setting('site_name')); ?></title>
    <?= get_style_tags(); ?>
</head>
<body class="page <?= $this->bodyClass; ?>">
    <?php if (AdminAuth::isLogged()) { ?>

        <?= $this->makePartial('top_nav') ?>

        <?= AdminMenu::render('side_nav'); ?>

    <?php } ?>

    <div class="page-wrapper">
        <div class="page-content">
            <?= Template::getBlock('body') ?>
        </div>
    </div>

    <div id="notification">
        <?= $this->makePartial('flash') ?>
    </div>
    <?= $this->makePartial('set_status_form'); ?>
    <?= Assets::getJsVars(); ?>
    <?= get_script_tags(); ?>
</body>
</html>