<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label">Title:</label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-show-menu-images" class="col-sm-3 control-label">Display Cart Images:
							<span class="help-block">Show or hide cart menu images</span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($show_cart_images == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="show_cart_images" value="0" <?php echo set_radio('show_cart_images', '0'); ?>>Hide</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="show_cart_images" value="1" <?php echo set_radio('show_cart_images', '1', TRUE); ?>>Show</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="show_cart_images" value="0" <?php echo set_radio('show_cart_images', '0', TRUE); ?>>Hide</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="show_cart_images" value="1" <?php echo set_radio('show_cart_images', '1'); ?>>Show</label>
								<?php } ?>
							</div>
							<?php echo form_error('show_cart_images', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group" id="cart-image-size">
						<label for="input-cart-image-size" class="col-sm-3 control-label">Cart Image Size:
							<span class="help-block">(Height x Width)</span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="cart_images_h" class="form-control" value="<?php echo $cart_images_h; ?>" />
								<input type="text" name="cart_images_w" class="form-control" value="<?php echo $cart_images_w; ?>" />
							</div>
							<?php echo form_error('cart_images_h', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('cart_images_w', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('input[name="show_cart_images"]').on('change', function() {
		if (this.value == '1') {
			$('#cart-image-size').fadeIn();
		} else {
			$('#cart-image-size').fadeOut();
		}
	});

	$('input[name="show_cart_images"]:checked').trigger('change');
});
//--></script>