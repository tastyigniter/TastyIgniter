<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <?= get_metas(); ?>
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
        <?= Template::getBlock('body') ?>
    </div>

    <div id="notification">
        <?= $this->makePartial('flash') ?>
    </div>
    <?= get_script_tags(); ?>
</body>
</html>