<?php if ($display_slides) { ?>
<div id="slider">
	<div class="flexslider">
		<ul class="slides">
			<?php if (!empty($slides)) { ?>
				<?php foreach ($slides as $slide) { ?>
					<?php if (isset($slide['image_src'])) { ?>
						<li>
							<div class="slider-caption">
								<?php echo $slide['caption']; ?>
							</div>

							<img src="<?php echo $slide['image_src']; ?>" />
						</li>
					<?php } ?>
				<?php } ?>
			<?php } else { ?>
				<li></li>
			<?php } ?>
	  	</ul>
	</div>
</div>
<script type="text/javascript"><!--
	$('.flexslider').flexslider({
		prevText: '',
		nextText: ''
	});
//--></script>
<?php } ?>