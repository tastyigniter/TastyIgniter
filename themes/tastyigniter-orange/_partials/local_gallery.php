<div class="col-md-12">
    <?php if ($local_gallery) { ?>
        <h5><b><?php echo $local_gallery['title']; ?></b></h5>
        <p><?php echo $local_gallery['description']; ?></p><br />
        <?php if (!empty($local_gallery['images'])) { ?>
            <ul class="gallery">
	            <?php foreach ($local_gallery['images'] as $image) { ?>
	                <li>
		                <img src="<?php echo $image['thumb']; ?>" alt="<?php echo $image['alt_text']; ?>">
	                </li>
	            <?php } ?>
            </ul>
        <?php } ?>
    <?php } else { ?>
        <p><?php echo lang('text_gallery'); ?></p>
    <?php } ?>
</div>
<script type="text/javascript"><!--
	$(document).ready(function(){
		$('#local-gallery ul.gallery').bsPhotoGallery({
			"classes" : "col-lg-3 col-md-4 col-sm-4 col-xs-6",
			"hasModal" : true
		});
	});
//--></script>