<?php 
	$this->load->library('extension');
	$modules = $this->extension->getModules('top');
?>

<?php if (!empty($modules)) { ?>
	<div id="module-top" class="top-section">
		<?php foreach ($modules as $module) { ?>
			<?php echo Modules::run($module['name'] .'/main/'. $module['name'] .'/index', $module['setting']); ?>
		<?php } ?>
	</div>
<?php } ?>