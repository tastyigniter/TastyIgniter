<?= get_metas(); ?>
<link href="<?= image_url('favicon.ico'); ?>" rel="shortcut icon" type="image/ico">
<title><?= sprintf(lang('main::lang.site_title'), lang(get_title()), setting('site_name')); ?></title>
<link href="/app/system/assets/ui/flame.css" rel="stylesheet" type="text/css" id="flame-css">
<?= get_style_tags(['widget', 'component', 'theme']); ?>
<link href="<?= theme_url('demo/assets/css/demo.css') ?>" rel="stylesheet" type="text/css" id="stylesheet-css">
