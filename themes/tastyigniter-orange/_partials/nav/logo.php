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
        <?php } else if (str_contains(setting('site_logo'), 'no_photo')) { ?>
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
