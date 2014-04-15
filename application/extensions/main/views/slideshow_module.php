<div class="img_inner">
<div class="slider-relative">
	<div id="slider" class="nivoSlider" style="width:<?php echo $dimension_w; ?>px;height:<?php echo $dimension_h; ?>px;">
		<?php foreach ($images as $name => $image_src) { ?>
			<img alt="<?php echo $name; ?>" src="<?php echo $image_src; ?>" />
		<?php } ?>
	</div>
</div>
</div>
<script src="<?php echo base_url("assets/js/jquery.nivo.slider.pack.js"); ?>"></script>
<script type="text/javascript">
$(window).load(function() {
	$('#slider').nivoSlider({
		effect: '<?php echo $effect; ?>',               // Specify sets like: 'fold,fade,sliceDown'
		slices: 15,                     				// For slice animations
		boxCols: 8,                     				// For box animations
		boxRows: 4,                     				// For box animations
		animSpeed: <?php echo $speed; ?>,              // Slide transition speed
		pauseTime: 3000,                // How long each slide will show
		startSlide: 0,                  // Set starting Slide (0 index)
		directionNav: true,             // Next & Prev navigation
		controlNav: true,               // 1,2,3... navigation
		controlNavThumbs: false,        // Use thumbnails for Control Nav
		pauseOnHover: true,             // Stop animation while hovering
		manualAdvance: false,           // Force manual transitions
		prevText: 'Prev',               // Prev directionNav text
		nextText: 'Next',               // Next directionNav text
		randomStart: false,             // Start on a random slide
		beforeChange: function(){},     // Triggers before a slide transition
		afterChange: function(){},      // Triggers after a slide transition
		slideshowEnd: function(){},     // Triggers after all slides have been shown
		lastSlide: function(){},        // Triggers when last slide is shown
		afterLoad: function(){}         // Triggers when slider has loaded
	});
});
</script>
