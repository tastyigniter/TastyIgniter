<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <?= get_metas(); ?>
    <?= get_favicon(); ?>
    <title><?= sprintf(lang('admin::default.site_title'), Template::getTitle(), setting('site_name')); ?></title>
    <?= get_style_tags(['app', 'widget', 'custom', 'theme']); ?>
    <?= get_script_tags('app'); ?>
</head>
<body id="page" class="<?= $this->bodyClass; ?>">
<?php if (AdminAuth::isLogged()) { ?>

    <?= $this->makePartial('top_nav') ?>

    <?= $this->makePartial('side_nav') ?>

<?php } ?>

<div id="page-wrapper">
    <div id="notification">
        <?= $this->makePartial('flash') ?>
    </div>

    <?= Template::getBlock('body') ?>

</div>
<div id="footer" class="navbar-footer">
    <div class="row-fluid">
        <p class="col-xs-9 text-copyright"><?= lang('system::default.tastyigniter.copyright'); ?></p>
        <p class="col-xs-3 text-version"><?= sprintf(lang('system::default.tastyigniter.version'), setting('ti_version')); ?></p>
    </div>
</div>
<?= get_script_tags(['widget', 'custom', 'theme']); ?>
</body>
</html>