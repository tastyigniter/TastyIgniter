<meta name="description" content="<?= setting('meta_description') ?>">
<meta name="keywords" content="<?= setting('meta_keywords') ?>">
<?= get_metas(); ?>
<?php if (trim($favicon = $this->theme->favicon, '/')) { ?>
    <link href="<?= image_url($favicon); ?>" rel="shortcut icon" type="image/ico">
<?php }
else { ?>
    <?= get_favicon(); ?>
<?php } ?>
<title><?= sprintf(lang('main::default.site_title'), lang(get_title()), setting('site_name')); ?></title>
<?= get_style_tags(['ui']); ?>
<link href="<?= assets_url('css/vendor/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" id="bootstrap-css">
<link href="<?= assets_url('css/vendor/font-awesome.min.css') ?>" rel="stylesheet" type="text/css" id="font-awesome-css">
<?= get_style_tags(['widget', 'component', 'theme']); ?>
<link href="<?= theme_url('demo/assets/css/stylesheet.css') ?>" rel="stylesheet" type="text/css" id="stylesheet-css">
<?= get_script_tags('app'); ?>
<?= !empty($this->theme->custom_script['head'])
    ? '<script type="text/javascript">'.$this->theme->custom_script['head'].'</script>'
    : ''; ?>
