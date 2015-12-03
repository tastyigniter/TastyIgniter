</div>
</div>
<footer>
    <?php echo get_partial('content_footer'); ?>

    <div class="main-footer">
	    <div class="container">
            <div class="col-md-8 footer-links">
                <ul>
                    <li><a href="<?php echo site_url('local/all'); ?>"><?php echo lang('menu_locations'); ?></a></li>
                    <li><a href="<?php echo site_url('contact'); ?>"><?php echo lang('menu_contact'); ?></a></li>

                    <?php $pages = $this->Pages_model->getPages(); ?>
                    <?php if ($pages) { ?>
                        <?php foreach ($pages as $page) { ?>
                            <?php if (in_array('footer', $page['navigation'])) { ?>
                                <li><a href="<?php echo site_url('pages?page_id='.$page['page_id']); ?>"><?php echo $page['name']; ?></a></li>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                    <li><a target="_blank" href="<?php echo admin_url(); ?>" ><?php echo lang('menu_admin'); ?></a></li>
                    <li><?php echo sprintf(lang('site_copyright'), date('Y'), config_item('site_name'), lang('ti_text_system_name')) . lang('ti_text_system_powered'); ?></li>
                </ul>
            </div>

            <?php $social_icons = get_theme_options('social'); ?>

            <div class="col-md-4">
                <?php if (!empty($social_icons) AND array_filter($social_icons)) { ?>
                    <div class="social-bottom">
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
        </div>
	</div>
</footer>
</body>
</html>