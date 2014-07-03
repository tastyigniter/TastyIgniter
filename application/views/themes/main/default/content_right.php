<?php 
	$this->load->library('extension');
	$modules = $this->extension->getModules('right');
?>

<?php if (!empty($modules)) { ?>
	<div class="clearfix visible-xs"></div>
	<div id="module-right" class="col-md-3 pull-right wrap-none">
		<div class="right-section">
			<?php foreach ($modules as $module) { ?>
				<?php echo Modules::run($module['name'] .'/main/'. $module['name'] .'/index', $module['setting']); ?>
			<?php } ?>
		</div>
	</div>
<?php } ?>