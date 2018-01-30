<div class="main-footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-3 pull-right">
                <?php $socialIcons = get_theme_options('social', []); ?>
                <?php if (!empty(array_filter($socialIcons))) { ?>
                    <?= partial('social_icons', ['socialIcons' => $socialIcons]); ?>
                <?php } ?>
            </div>

            <div class="col-xs-4 col-sm-3">
                <div class="footer-links">
                    <h4 class="footer-title hidden-xs"><?= lang('main::default.text_my_account'); ?></h4>
                    <ul>
                        <li>
                            <a href="<?= site_url('account/login'); ?>">
                                <?= lang('main::default.menu_login'); ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('account/register'); ?>">
                                <?= lang('main::default.menu_register'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-4 col-sm-3">
                <div class="footer-links">
                    <h4 class="footer-title hidden-xs"><?= setting('site_name'); ?></h4>
                    <ul>
                        <?php if (!is_single_location()) { ?>
                            <li>
                                <a href="<?= site_url('locations'); ?>">
                                    <?= lang('main::default.menu_locations'); ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?= site_url('contact'); ?>">
                                <?= lang('main::default.menu_contact'); ?>
                            </a>
                        </li>
                        <?php if (get_theme_options('hide_admin_link') != '1') { ?>
                            <li>
                                <a target="_blank"
                                   href="<?= admin_url(); ?>">
                                    <?= lang('main::default.menu_admin'); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-xs-4 col-sm-3">
                <div class="footer-links">
                    <h4 class="footer-title hidden-xs"><?= lang('main::default.text_information'); ?></h4>
                    <ul>
                        <?php $pages = [];//$this->Pages_model->getPages(); ?>
                        <?php if ($pages) { ?>
                            <?php foreach ($pages as $page) { ?>
                                <?php if (is_array($page['navigation']) AND in_array('footer', $page['navigation'])) { ?>
                                    <li>
                                        <a href="<?= site_url('pages?page_id='.$page['page_id']); ?>">
                                            <?= $page['name']; ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bottom-footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 wrap-all border-top">
                <?= sprintf(
                    lang('main::default.site_copyright'),
                    date('Y'),
                    setting('site_name'),
                    lang('system::default.tastyigniter.system_name')
                ).lang('system::default.tastyigniter.system_powered'); ?>
            </div>
        </div>
    </div>
</div>