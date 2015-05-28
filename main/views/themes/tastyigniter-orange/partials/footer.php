</div>
</div>
<footer>
	<div class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4">
                    <div class="about">
                        <h4 class="footer-title">About Grill</h4>
                        <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent libero velit, rutrum eu ex sit amet, mollis euismod lorem.
                        <br><br>Donec ac ante sit amet sapien lobortis imperdiet. Sed tincidunt nisi ac tellus bibendum mattis. Etiam at metus ut arcu imperdiet tincidunt.</p>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="footer-links">
                        <h4 class="footer-title">Links</h4>
                        <ul>
							<li><a href="<?php echo site_url(); ?>"><i class="fa fa-angle-right"></i>Home</a></li>
							<li><a href="<?php echo site_url('menus'); ?>"><i class="fa fa-angle-right"></i>View Menu</a></li>
							<li><a href="<?php echo site_url('local/locations'); ?>"><i class="fa fa-angle-right"></i>Locations</a></li>
							<li><a href="<?php echo site_url('contact'); ?>"><i class="fa fa-angle-right"></i>Contact Us</a></li>

							<?php $pages = $this->Pages_model->getPages(); ?>
							<?php if ($pages) { ?>
								<?php foreach ($pages as $page) { ?>
									<?php if (in_array('footer', $page['navigation'])) { ?>
										<li><a href="<?php echo site_url('pages?page_id='.$page['page_id']); ?>"><i class="fa fa-angle-right"></i><?php echo $page['name']; ?></a></li>
									<?php } ?>
								<?php } ?>
							<?php } ?>

							<li><a target="_blank" href="<?php echo site_url(ADMINDIR.''); ?>" ><i class="fa fa-angle-right"></i>Administrator</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4">
                    <div class="contact-info">
                        <h4 class="footer-title">Contact info</h4>
                        <p>Sed dignissim, diam id molestie faucibus, purus nisl pretium quam, in pulvinar velit massa id elit.</p>
                        <?php $main_local = $this->location->getMainLocal(); ?>
                        <ul>
                            <li><i class="fa fa-phone"></i><?php echo $main_local['location_telephone']; ?></li>
                            <li><i class="fa fa-globe"></i><?php echo $this->location->getFormatAddress($main_local, FALSE); ?></li>
                            <li><i class="fa fa-envelope"></i><a href="#">info@company.com</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
 	</div>
    <div class="bottom-footer">
	    <div class="container">
			<p>&copy; <?php echo date('Y'); ?> TastyIgniter. All Rights Reserved</p>
        </div>
	</div>
</footer>
<script type="text/javascript">
$(document).ready(function() {
	if ($('#codeigniter_profiler').length) {
		$('.bottom-footer .container').append('<a id="profiler">View Profiler</a>');
		$('#profiler').on('click', function(){
			if($('#codeigniter_profiler').is(':visible')) {
				$('#codeigniter_profiler').fadeOut();
			} else {
				$('#codeigniter_profiler').fadeIn();
			}
		});

		 $('#codeigniter_profiler').fadeOut();
	}

	$('a, i').tooltip({placement: 'bottom'});
	$('select.form-control').select2();
});
</script>
</body>
</html>