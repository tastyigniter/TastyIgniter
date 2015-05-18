<div id="banner-box" class="module-box">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $text_heading; ?></h3>
		</div>
 		
 		<div class="panel-body">
            <?php if ($type === 'image') { ?>
                <a href="<?php echo $click_url; ?>">
                    <img alt="<?php echo $alt_text; ?>" src="<?php echo $images[0]['url']; ?>" class="thumb img-responsive" />
                </a>
            <?php } else if ($type === 'carousel') { ?>
                <div id="banner-slideshow" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php for ($i = 0; $i < count($images); $i++) { ?>
                            <li data-target="#banner-slideshow" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
                        <?php } ?>
                    </ol>

                    <div class="carousel-inner">
                        <?php $num = 0 ?>
                        <?php foreach ($images as $image) { ?>
                            <div class="item <?php echo ($num === 0) ? 'active' : ''; ?>">
                                <a href="<?php echo $click_url; ?>">
                                    <img class="img-responsive" alt="<?php echo $alt_text; ?>" src="<?php echo $image['url']; ?>" />
                                </a>
                            </div>
                            <?php $num++; ?>
                        <?php } ?>
                    </div>

                    <a class="left carousel-control" href="#banner-slideshow" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                    <a class="right carousel-control" href="#banner-slideshow" data-slide="next"><span class="fa fa-chevron-right"></span></a>
                </div>
            <?php } else if ($type === 'custom') { ?>
                <?php echo $custom_code; ?>
            <?php } ?>
		</div>
	</div>
</div>