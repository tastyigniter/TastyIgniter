<div id="banner-box" class="module-box">
    <?php if ($banners) foreach ($banners as $banner) { ?>
        <div class="row">
            <div class="col-xs-12">
                <?php if ($banner['type'] === 'image') { ?>
                    <div class="thumbnail">
                        <a href="<?php echo $banner['click_url']; ?>">
                            <img alt="<?php echo $banner['alt_text']; ?>" src="<?php echo $banner['images'][0]['url']; ?>" class="thumb img-responsive" />
                        </a>
                    </div>
                <?php } else if ($banner['type'] === 'carousel') { ?>
                    <div class="thumbnail">
                        <div id="banner-slideshow" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php for ($i = 0; $i < count($banner['images']); $i++) { ?>
                                    <li data-target="#banner-slideshow" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i === 0) ? 'active' : ''; ?>"></li>
                                <?php } ?>
                            </ol>

                            <div class="carousel-inner">
                                <?php $num = 0 ?>
                                <?php foreach ($banner['images'] as $image) { ?>
                                    <div class="item <?php echo ($num === 0) ? 'active' : ''; ?>">
                                        <a href="<?php echo $banner['click_url']; ?>">
                                            <img class="img-responsive" alt="<?php echo $banner['alt_text']; ?>" src="<?php echo $image['url']; ?>" />
                                        </a>
                                    </div>
                                    <?php $num++; ?>
                                <?php } ?>
                            </div>

                            <a class="left carousel-control" href="#banner-slideshow" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                            <a class="right carousel-control" href="#banner-slideshow" data-slide="next"><span class="fa fa-chevron-right"></span></a>
                        </div>
                    </div>
                <?php } else if ($banner['type'] === 'custom') { ?>
                    <?php echo $banner['custom_code']; ?>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>