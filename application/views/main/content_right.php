<?php 
	$uri_route = array();

	if ($this->uri->segment(1)) {
		$uri_route[] = $this->uri->segment(1);
	} else {
		$uri_route[] = 'home';
	}
	
	if ($this->uri->segment(2)) {
		$uri_route[] = $this->uri->segment(1) .'/'. $this->uri->segment(2);
	}

	$this->load->model('Extensions_model');
	$this->load->model('Design_model');

	$extensions = $this->Extensions_model->getExtensions();		
	$layout_id = $this->Design_model->getRouteLayoutId($uri_route);
	
	$modules_data = array();
	foreach ($extensions as $extension) {
		if (file_exists(EXTPATH .'main/controllers/'. $extension['code'] .'_module.php')) {
			$result = $this->config->item($extension['code'] .'_module');
		
			if (is_array($result['modules'])) {
				foreach ($result['modules'] as $module) {
					if (in_array($module['layout_id'], $layout_id) && $module['position'] === 'right' && $module['status'] === '1') {
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
<div class="right-section">
	<?php foreach ($modules_data as $key => $value) { ?>
		<?php echo Modules::run('main/'. $value['code'] .'_module/index'); ?>
	<?php } ?>
	<?php if (isset($button_left) OR isset($button_right)) { ?>
	<div class="buttons">
		<?php if (isset($button_left)) { ?>
			<div class="left"><?php echo $button_left; ?></div>
		<?php } ?>
		<?php if (isset($button_right)) { ?>
			<div class="right"><?php echo $button_right; ?></div>
		<?php } ?>
	</div>
	<?php } ?>
</div>
<?php } ?>