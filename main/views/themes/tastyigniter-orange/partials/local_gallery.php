<div class="col-md-12 gallery">
    <?php if ($local_gallery) { ?>
        <h5><b><?php echo $local_gallery['title']; ?></b></h5>
        <p><?php echo $local_gallery['description']; ?></p><br />
        <?php if (!empty($local_gallery['images'])) { ?>
            <div class="row">
	            <?php foreach ($local_gallery['images'] as $image) { ?>
	                <div class="col-xs-6 col-md-3">
	                    <a class="thumbnail" style="height: 120px !important;">
	                        <img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['alt_text']; ?>">
	                    </a>
	                </div>
	            <?php } ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p><?php echo lang('text_gallery'); ?></p>
    <?php } ?>
</div>