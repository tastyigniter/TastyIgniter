<?= get_script_tags(['widget', 'component', 'custom', 'theme']); ?>
<?= get_theme_options('ga_tracking_code'); ?>
<?php $custom_script = get_theme_options('custom_script'); ?>
<?= !empty($custom_script['footer']) ? '<script type="text/javascript">'.$custom_script['footer'].'</script>' : ''; ?>
