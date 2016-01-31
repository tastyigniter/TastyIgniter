</div>
</div>
<footer id="page-footer">
    <?php echo get_partial('content_footer'); ?>

    <div class="main-footer">
	    <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-3 pull-right">
                    <?php $social_icons = get_theme_options('social'); ?>
                    <?php if (!empty($social_icons) AND array_filter($social_icons)) { ?>
                        <div class="social-bottom">
                            <h4 class="footer-title"><?php echo lang('text_follow_us'); ?></h4>
                            <ul class="social-icons">
                                <?php if (!empty($social_icons['facebook'])) { ?>
                                    <li><a class="fa fa-facebook" target="_blank" href="<?php echo $social_icons['facebook']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['twitter'])) { ?>
                                    <li><a class="fa fa-twitter" target="_blank" href="<?php echo $social_icons['twitter']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['google'])) { ?>
                                    <li><a class="fa fa-google-plus" target="_blank" href="<?php echo $social_icons['google']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['youtube'])) { ?>
                                    <li><a class="fa fa-youtube" target="_blank" href="<?php echo $social_icons['youtube']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['vimeo'])) { ?>
                                    <li><a class="fa fa-vimeo" target="_blank" href="<?php echo $social_icons['vimeo']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['linkedin'])) { ?>
                                    <li><a class="fa fa-linkedin" target="_blank" href="<?php echo $social_icons['linkedin']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['pinterest'])) { ?>
                                    <li><a class="fa fa-pinterest" target="_blank" href="<?php echo $social_icons['pinterest']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['tumblr'])) { ?>
                                    <li><a class="fa fa-tumblr" target="_blank" href="<?php echo $social_icons['tumblr']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['flickr'])) { ?>
                                    <li><a class="fa fa-flickr" target="_blank" href="<?php echo $social_icons['flickr']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['instagram'])) { ?>
                                    <li><a class="fa fa-instagram" target="_blank" href="<?php echo $social_icons['instagram']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['dribbble'])) { ?>
                                    <li><a class="fa fa-dribbble" target="_blank" href="<?php echo $social_icons['dribbble']; ?>"></a></li>
                                <?php } ?>

                                <?php if (!empty($social_icons['foursquare'])) { ?>
                                    <li><a class="fa fa-foursquare" target="_blank" href="<?php echo $social_icons['foursquare']; ?>"></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-xs-4 col-sm-3">
                    <div class="footer-links">
                        <h4 class="footer-title hidden-xs"><?php echo lang('text_my_account'); ?></h4>
                        <ul>
                            <li><a href="<?php echo site_url('account/login'); ?>"><?php echo lang('menu_login'); ?></a></li>
                            <li><a href="<?php echo site_url('account/register'); ?>"><?php echo lang('menu_register'); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-3">
                    <div class="footer-links">
                        <h4 class="footer-title hidden-xs"><?php echo config_item('site_name'); ?></h4>
                        <ul>
                            <li><a href="<?php echo site_url('local/all'); ?>"><?php echo lang('menu_locations'); ?></a></li>
                            <li><a href="<?php echo site_url('contact'); ?>"><?php echo lang('menu_contact'); ?></a></li>
                            <?php if (get_theme_options('hide_admin_link') !== '1') { ?>
                                <li><a target="_blank" href="<?php echo admin_url(); ?>"><?php echo lang('menu_admin'); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-3">
                    <div class="footer-links">
                        <h4 class="footer-title hidden-xs"><?php echo lang('text_information'); ?></h4>
                        <ul>
                            <?php $pages = $this->Pages_model->getPages(); ?>
                            <?php if ($pages) { ?>
                                <?php foreach ($pages as $page) { ?>
                                    <?php if (in_array('footer', $page['navigation'])) { ?>
                                        <li><a href="<?php echo site_url('pages?page_id='.$page['page_id']); ?>"><?php echo $page['name']; ?></a></li>
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
                    <!-- TastyIgniter is open source software developed and maintained by a volunteer community.
                    It would be much appreciated by the TastyIgniter community if you left the full copyright and "powered by" notice intact,
                    to show your support for TastyIgniter.  If you choose to remove or modify the copyright below,
                    you may be refused support on the TastyIgniter Community Forums.

                    This is free software, support us and we'll support you. -->
                    <?php echo sprintf(lang('site_copyright'), date('Y'), config_item('site_name'), lang('tastyigniter_system_name')) . lang('tastyigniter_system_powered'); ?>
                    <!-- End powered by -->
                </div>
            </div>
        </div>
	</div>
</footer>
<?php $custom_script = get_theme_options('custom_script'); ?>
<?php if (!empty($custom_script['footer'])) { echo '<script type="text/javascript">'.$custom_script['footer'].'</script>'; }; ?>
</body>
</html>