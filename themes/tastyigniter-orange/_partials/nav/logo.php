<div class="logo">
    <a class="" href="<?= site_url('home'); ?>">
        <?php if (get_theme_options('logo_image')) { ?>
            <img
                alt="<?= setting('site_name'); ?>"
                src="<?= image_url(get_theme_options('logo_image')) ?>"
                height="40"
            >
        <?php } else if (get_theme_options('logo_text')) { ?>
            <?= get_theme_options('logo_text'); ?>
        <?php } else if (setting('site_logo') === 'data/no_photo.png') { ?>
            <?= setting('site_name'); ?>
        <?php } else { ?>
            <img
                alt="<?= setting('site_name'); ?>"
                src="<?= image_url(setting('site_logo')) ?>"
                height="40"
            >
        <?php } ?>
    </a>
</div>
