</div>
</div>
<div class="footer">
	<div class="container">
		<div class="links">
			<a href="<?php echo site_url(); ?>">Home</a>  |  
			<a href="<?php echo site_url('main/menus'); ?>">View Menu</a>  |  
			<a href="<?php echo site_url('main/local'); ?>">Local</a>  |  
			<a href="<?php echo site_url('main/contact'); ?>">Contact Us</a>  |  
			
			<?php $pages = $this->Pages_model->getPages(); ?>
			<?php foreach ($pages as $page) { ?>
				<?php if ($page['menu_location'] === '3' OR $page['menu_location'] === '1') { ?>
					<a href="<?php echo site_url('main/pages?page_id='.$page['page_id']); ?>"><?php echo $page['name']; ?></a>  |  
				<?php } ?>
			<?php } ?>

			<a target="_blank" href="<?php echo site_url(ADMIN_URI.''); ?>" >Administrator</a>
		</div>

		<div class="copyright">
			&copy; <?php echo date('Y'); ?> TastyIgniter. All Rights Reserved</p> <br />
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	if ($('#codeigniter_profiler').length) {
		$('.copyright').append('Page rendered in <strong>{elapsed_time}</strong> seconds <br /><a id="profiler">View Profiler</a>');
		$('#profiler').on('click', function(){
			if($('#codeigniter_profiler').is(':visible')) {
				$('#codeigniter_profiler').fadeOut();
			} else {
				$('#codeigniter_profiler').fadeIn();
			}
		});	

		 $('#codeigniter_profiler').fadeOut();
	}

	$('a').tooltip({placement: 'bottom'});
	$('select.form-control').selectpicker({iconBase:'fa', tickIcon:'fa-check'});
});	
</script>
</body>
</html>