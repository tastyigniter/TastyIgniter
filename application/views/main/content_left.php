<?php 
	if ($this->uri->segment(1)) {
		$route = $this->uri->segment(1);
	} else {
		$route = 'home';
	}

	$this->load->model('Extensions_model');
	$this->load->model('Design_model');
	
	$extensions = $this->Extensions_model->getExtensions();		
	$layout_id = $this->Design_model->getLayoutRouteId($route);
	
	$modules_data = array();
	foreach ($extensions as $extension) {
		if (file_exists('application/extensions/main/controllers/'. $extension['code'] .'_module.php')) {
			$modules = $this->config->item($extension['code'] .'_module');
		
			if ($modules) {
				foreach ($modules as $module) {
					if ($module['layout_id'] === $layout_id && $module['position'] === 'left' && $module['status'] === '1') {
						$modules_data[] = array(
							'code' 		=> $extension['code'],
							'priority' 	=> $module['priority']
						);
					}
				}
			}
		}
	}

	$sort_modules = array();
	
	foreach ($modules_data as $key => $value) {	
		$sort_modules[$key] = $value['priority'];
	}
	
	array_multisort($sort_modules, SORT_ASC, $modules_data);
?>

<?php if (!empty($modules_data)) { ?>
	<div class="left-section">
	<?php foreach ($modules_data as $key => $value) { ?>
		<?php echo Modules::run('main/'. $value['code'] .'_module/index'); ?>
	<?php } ?>
	</div>
<?php } ?>