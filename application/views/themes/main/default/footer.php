</div>
</div>
</div>
<footer>
    <div class="links">
		<a href="<?php echo site_url(); ?>">Home</a>  |  
		<a href="<?php echo site_url('main/pages/page/1'); ?>">About Us</a>  |  
		<a href="<?php echo site_url('main/menus'); ?>">View Menu</a>  |  
		<a href="<?php echo site_url('main/contact'); ?>">Contact Us</a>  |  
		<a target="_blank" href="<?php echo site_url('admin'); ?>" >Administrator</a>
    </div>

  	<div class="copyright">
		&copy; <?php echo date('Y'); ?> TastyIgniter. All Rights Reserved</p> <br />
		Page rendered in <strong>{elapsed_time}</strong> seconds <br />
		<!--<a id="profiler">View Profiler</a>-->
	</div>
</footer>
<!--<script type="text/javascript">
$(document).ready(function() {
	if ($('#codeigniter_profiler').length) {
		$('#profiler').on('click', function(){
			if($('#codeigniter_profiler').is(':visible')) {
				$('#codeigniter_profiler').fadeOut();
			} else {
				$('#codeigniter_profiler').fadeIn();
			}
		});	

		 $('#codeigniter_profiler').fadeOut();
	} else {
		$('#profiler').hide();
	}
});	
</script>-->
</body>
</html>