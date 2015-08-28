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
                    <li><?php echo sprintf(lang('site_copyright'), config_item('site_name'), date('Y')); ?></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="social-bottom">
                    <ul class="social-icons">
                        <li><a class="fa fa-facebook" target="_blank"></a></li>
                        <li><a class="fa fa-twitter" target="_blank"></a></li>
                        <li><a class="fa fa-google-plus" target="_blank"></a></li>
                        <li><a class="fa fa-skype" target="_blank"></a></li>
                        <li><a class="fa fa-linkedin" target="_blank"></a></li>
                        <li><a class="fa fa-youtube" target="_blank"></a></li>
                    </ul>
                </div>
            </div>
        </div>
	</div>
</footer>
</body>
</html>