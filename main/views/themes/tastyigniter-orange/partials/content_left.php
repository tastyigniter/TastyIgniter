<?php if (!empty($left_modules)) { ?>
	<div id="module-left" class="col-sm-3">
		<div class="side-bar">
			<?php foreach ($left_modules as $module) { ?>
				<?php echo $module; ?>
			<?php } ?>
		</div>
	</div>
<?php } ?>
<!--<div id="cart-box" class="module-box" data-spy="affix" data-offset-top="200" data-offset-bottom="5">-->