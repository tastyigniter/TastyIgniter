<?php 
	$this->load->library('extension');
	$modules = $this->extension->getModules('left');
?>

<?php if (!empty($modules)) { ?>
	<div class="clearfix visible-xs"></div>
	<div id="module-left" class="col-md-2 module-left pull-left wrap-none">
		<div class="left-section">
			<?php foreach ($modules as $module) { ?>
				<?php echo Modules::run($module['name'] .'/main/'. $module['name'] .'/index', $module['setting']); ?>
			<?php } ?>
		</div>
	</div>
<?php } ?>

<!--<div id="cart-box" class="module-box" data-spy="affix" data-offset-top="200" data-offset-bottom="5">-->