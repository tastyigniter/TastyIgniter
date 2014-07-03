<div id="slideshow-box" class="row">
	<div id="slideshow" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<?php for ($i = 0; $i < count($images); $i++) { ?>
				<li data-target="#slideshow" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
			<?php } ?>
		</ol>

		<div class="carousel-inner">
			<?php $num = 0 ?>
			<?php foreach ($images as $name => $image_src) { ?>
				<div class="item <?php echo ($num === 0) ? 'active' : ''; ?>">
					<img class="img-responsive" alt="<?php echo $name; ?>" src="<?php echo $image_src; ?>" />
				</div>
				<?php $num++; ?>
			<?php } ?>
		</div>

		<a class="left carousel-control" href="#slideshow" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
		<a class="right carousel-control" href="#slideshow" data-slide="next"><span class="fa fa-chevron-right"></span></a>
	</div>
</div>