</div>
<div id="footer">
  	<div class="footer">
  		<div class="right">
			<?php $this->load->model('Locations_model'); ?>
			<?php $locations = $this->Locations_model->getLocations(); ?>
			<?php if ($this->user->islogged()) { ?>
				<select>
					<?php foreach ($locations as $location) { ?>					
					<?php if ($location['location_id'] === $this->user->getLocationId()) { ?>					
						<option value="<?php echo $location['location_id']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select>
			<?php } ?>
  			&copy; <?php echo date('Y'); ?> TastyIgniter. All Rights Reserved v1.0-beta 
  		</div>
		<div class="left">
			<!--<?php if ($this->user->islogged()) { ?>
				<a id="profiler">View Profiler</a>		
			<?php } ?>-->
		</div>	
  	</div>
</div>
</div>
</div>
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