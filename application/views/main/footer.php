<div id="review-box" style="display:none;"></div>
</div>
</div>
</div>
<footer>

    <div class="links">
		<a href="<?php echo site_url('home'); ?>">Home</a>  |  
		<a href="<?php echo site_url('aboutus'); ?>">About Us</a>  |  
		<a href="<?php echo site_url('menus'); ?>">View Menu</a>  |  
		<a href="<?php echo site_url('contact'); ?>">Contact Us</a>  |  
		<a target="_blank" href="<?php echo site_url('admin'); ?>" >Administrator</a>
    </div>

  	<div class="copyright">
		&copy; <?php echo date('Y'); ?> TastyIgniter. All Rights Reserved</p> <br />
		Page rendered in <strong>{elapsed_time}</strong> seconds <br /><a id="profiler">View Profiler</a>
	</div>
</footer>
<script type="text/javascript">
$(document).ready(function() {
  	$('#profiler').on('click', function(){
  		if($('#codeigniter_profiler').is(':visible')){
     		$('#codeigniter_profiler').fadeOut();
		} else {
   			$('#codeigniter_profiler').fadeIn();
		}
	});	

     $('#codeigniter_profiler').fadeOut();
});	
</script>
</body>
</html>