</div>
</div>
<footer>
	<div class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <div class="subscribe-form">
                        <span><?php echo lang('text_subscribe'); ?></span>
                        <form class="subscribeForm" method="get">
                            <div class="input-group subscribe-group">
                                <input type="text" id="subscribe" class="form-control">
                                <button type="submit" id="submitButton" class="input-group-addon"><i class="fa fa-paper-plane-o"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="social-bottom">
                        <span><?php echo lang('text_follow_us'); ?></span>
                        <ul class="social-icons">
                            <li><a class="fa fa-facebook" title="Facebook" target="_blank"></a></li>
                            <li><a class="fa fa-twitter" title="Twitter" target="_blank"></a></li>
                            <li><a class="fa fa-google-plus" title="Google" target="_blank"></a></li>
                            <li><a class="fa fa-skype" title="Skype" target="_blank"></a></li>
                            <li><a class="fa fa-linkedin" title="Linkedin" target="_blank"></a></li>
                            <li><a class="fa fa-youtube" title="Youtube" target="_blank"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
 	</div>
    <div class="bottom-footer">
	    <div class="container footer-links">
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
	</div>
</footer>
<script type="text/javascript">
$(document).ready(function() {
	if ($('#codeigniter_profiler').length) {
		$('.bottom-footer .container > ul').append('<li><a class="btn btn-default btn-profiler"><i class="fa fa-bug"></i></a></li>');
		$('.btn-profiler').on('click', function(){
			if($('#codeigniter_profiler').is(':visible')) {
				$('#codeigniter_profiler').fadeOut();
			} else {
				$('#codeigniter_profiler').fadeIn();
			}
		});

		 $('#codeigniter_profiler').fadeOut();
	}
});
</script>
</body>
</html>