<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-show-menu-images" class="col-sm-3 control-label"><?php echo lang('label_show_cart_images'); ?>
							<span class="help-block"><?php echo lang('help_show_cart_images'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($show_cart_images == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="show_cart_images" value="0" <?php echo set_radio('show_cart_images', '0'); ?>><?php echo lang('text_hide'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="show_cart_images" value="1" <?php echo set_radio('show_cart_images', '1', TRUE); ?>><?php echo lang('text_show'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="show_cart_images" value="0" <?php echo set_radio('show_cart_images', '0', TRUE); ?>><?php echo lang('text_hide'); ?></label>
									<label class="btn btn-success"><input type="radio" name="show_cart_images" value="1" <?php echo set_radio('show_cart_images', '1'); ?>><?php echo lang('text_show'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('show_cart_images', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group" id="cart-image-size">
						<label for="input-cart-image-size" class="col-sm-3 control-label"><?php echo lang('label_cart_image_size'); ?>
							<span class="help-block"><?php echo lang('help_cart_image_size'); ?></span>
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
					<div class="form-group">
						<label for="input-fixed-cart" class="col-sm-3 control-label"><?php echo lang('label_fixed_cart'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($fixed_cart == '1') { ?>
									<label class="btn btn-default"><input type="radio" name="fixed_cart" value="0" <?php echo set_radio('fixed_cart', '0'); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="fixed_cart" value="1" <?php echo set_radio('fixed_cart', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="fixed_cart" value="0" <?php echo set_radio('fixed_cart', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
									<label class="btn btn-default"><input type="radio" name="fixed_cart" value="1" <?php echo set_radio('fixed_cart', '1'); ?>><?php echo lang('text_yes'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('fixed_cart', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group" id="cart-fixed-offset">
						<label for="input-fixed-top-offset" class="col-sm-3 control-label"><?php echo lang('label_fixed_offset'); ?>
							<span class="help-block"><?php echo lang('help_fixed_offset'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="control-group control-group-2">
								<input type="text" name="fixed_top_offset" class="form-control" value="<?php echo $fixed_top_offset; ?>" />
								<input type="text" name="fixed_bottom_offset" class="form-control" value="<?php echo $fixed_bottom_offset; ?>" />
							</div>
							<?php echo form_error('fixed_top_offset', '<span class="text-danger">', '</span>'); ?>
							<?php echo form_error('fixed_bottom_offset', '<span class="text-danger">', '</span>'); ?>
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

	$('input[name="fixed_cart"]').on('change', function() {
		if (this.value == '1') {
			$('#cart-fixed-offset').fadeIn();
		} else {
			$('#cart-fixed-offset').fadeOut();
		}
	});

	$('input[name="fixed_cart"]:checked').trigger('change');
	$('input[name="show_cart_images"]:checked').trigger('change');
});
//--></script>