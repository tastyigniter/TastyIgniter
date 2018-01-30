<?= get_metas(); ?>
<?php if ($favicon = get_theme_options('favicon')) { ?>
    <link href="<?= image_url($favicon); ?>" rel="shortcut icon" type="image/ico">
<?php }
else { ?>
    <?= get_favicon(); ?>
<?php } ?>
<title><?= sprintf(lang('main::default.site_title'), lang(get_title()), setting('site_name')); ?></title>
<?= get_style_tags(); ?>
<?= get_active_styles(); ?>
<?= get_style_tags(['app', 'widget', 'component', 'theme']); ?>
<?= get_script_tags('app'); ?>
<?php $custom_script = get_theme_options('custom_script'); ?>
<?= !empty($custom_script['head']) ? '<script type="text/javascript">'.$custom_script['head'].'</script>' : ''; ?>