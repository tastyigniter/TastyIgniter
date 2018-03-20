<?= get_script_tags(['widget', 'component', 'custom', 'theme']); ?>
<?= $this->theme->ga_tracking_code; ?>
<?= !empty($this->theme->custom_script['footer'])
    ? '<script type="text/javascript">'.$this->theme->custom_script['footer'].'</script>'
    : ''; ?>
