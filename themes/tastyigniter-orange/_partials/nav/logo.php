<div class="logo">
    <a class="" href="<?= page_url('home'); ?>">
        <?php if ($this->theme->logo_image) { ?>
            <img
                alt="<?= setting('site_name'); ?>"
                src="<?= image_url($this->theme->logo_image) ?>"
                height="40"
            >
        <?php } else if ($this->theme->logo_text) { ?>
            <?= $this->theme->logo_text; ?>
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
