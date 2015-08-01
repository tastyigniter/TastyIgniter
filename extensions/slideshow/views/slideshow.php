<div id="slider">
	<div class="flexslider">
		<ul class="slides">
			<?php foreach ($slides as $slide) { ?>
				<?php if (isset($slide['image_src'])) { ?>
					<li>
						<div class="slider-caption">
							<?php echo $slide['caption']; ?>
						</div>

						<img alt="<?php echo $slide['name']; ?>" src="<?php echo $slide['image_src']; ?>"  />
					</li>
				<?php } ?>
			<?php } ?>
	  	</ul>
	</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo root_url("assets/js/flexslider/flexslider.css"); ?>">
<script src="<?php echo root_url("assets/js/flexslider/jquery.flexslider.js"); ?>"></script>
<script type="text/javascript"><!--
	$('.flexslider').flexslider({
		prevText: '',
		nextText: ''
	});
//--></script>