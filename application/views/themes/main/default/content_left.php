<?php 
	$uri_route = 'home';
	if ($this->uri->segment(1)) {
		$uri_route = $this->uri->segment(1);
	}
	
	if ($this->uri->segment(2)) {
		$uri_route = $this->uri->segment(1) .'/'. $this->uri->segment(2);
	}

	$this->load->model('Extensions_model');
	$this->load->model('Design_model');
	
	$extensions = $this->Extensions_model->getExtensions();		
	$layout_id = $this->Design_model->getRouteLayoutId($uri_route);
	
	if ($this->uri->segment(1) === 'pages') {
		$layout_id = $this->Design_model->getPageLayoutId($this->uri->segment(3));
	}
	
	$modules_data = array();
	foreach ($extensions as $extension) {
		if (file_exists(EXTPATH .'main/controllers/'. $extension['code'] .'_module.php')) {
			$result = $this->config->item($extension['code'] .'_module');

			if (is_array($result['modules'])) {
				foreach ($result['modules'] as $module) {
					if (in_array($module['layout_id'], $layout_id) && $module['position'] === 'left' && $module['status'] === '1') {
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