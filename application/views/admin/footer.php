</div>
<div id="footer">
  	<div class="bottom_addr">&copy; <?php echo date('Y'); ?> TastyIgniter. All Rights Reserved<br />v1.0-beta</div>
	
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
	<p class="footer">Memory consumed in entire application: <strong>{memory_usage}</strong> <a id="profiler">View Profiler</a></p>
</div>
</div>
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