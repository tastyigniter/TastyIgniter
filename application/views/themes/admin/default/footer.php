<?php
		$locations = array();
		if ($this->user->islogged()) {
			$no_sidenav = '';
			$this->load->model('Locations_model');
			
			$results = $this->Locations_model->getLocations();
			foreach ($results as $result) {					
				$locations[] = array(
					'location_id'	=>	$result['location_id'],
					'location_name'	=>	$result['location_name'],
				);
			}
		}
?>
</div>
</div>
</div>
<div id="footer" class="<?php echo ($this->user->islogged()) ? '' : 'wrap-none'; ?>">
	<div class="navbar navbar-default navbar-footer">
		<div class="container-fluid">
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<?php if ($locations) { ?>
				<form role="form" class="navbar-form navbar-left" role="form">
					<div class="form-group">
						<select name="location" class="form-control">
						<?php foreach ($locations as $location) { ?>					
							<?php if ($this->user->getLocationId() === $location['location_id']) { ?>					
								<option value="<?php echo $location['location_id']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
							<?php } ?>
						<?php } ?>
						</select>
					</div>
				</form>
				<?php } ?>
				<p class="navbar-text navbar-right navbar-copyright">&copy; <?php echo date('Y'); ?> TastyIgniter. All Rights Reserved v1.0-beta</p>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	if ($('#codeigniter_profiler').length) {
		$('#footer .navbar-form').after('<a id="profiler" class="navbar-left navbar-text navbar-profiler">View Profiler</a>');
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
	$('select.form-control').selectpicker({iconBase: 'fa', tickIcon: 'fa-check'});
});	
</script>
</body>
</html>