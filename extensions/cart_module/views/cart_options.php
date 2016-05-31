<div class="modal-dialog modal-menu-options">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><?php echo $text_heading; ?></h4>
		</div>

		<div class="modal-body" id="menu-options<?php echo $menu_id; ?>">
			<div class="row">
			    <div class="col-md-12">
                    <div id="cart-options-alert">
                        <?php if ($cart_option_alert) { ?>
                            <?php echo $cart_option_alert; ?>
                        <?php } ?>
                    </div>

                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object" src="<?php echo $menu_image; ?>">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading" id="media-heading"><?php echo $menu_name; ?></h4>
                            <?php if ($description) { ?>
                                <p class="description"><?php echo $description; ?></p>
                                <p class="price"><?php echo $menu_price; ?></p>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="menu-quantity form-group clearfix">
                        <div class="col-sm-3 wrap-none">
                            <label for="quantity"><?php echo lang('label_menu_quantity'); ?></label>
                        </div>
                        <div class="col-sm-3 wrap-none">
                            <div class="input-group quantity-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="dwn" type="button"><i class="fa fa-minus"></i></button>
                                    </span>
                                <input type="text" name="quantity" id="quantity" class="form-control text-center" value="<?php echo $quantity; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-dir="up" type="button"><i class="fa fa-plus"></i></button>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="menu-options">
                        <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>" />
                        <input type="hidden" name="row_id" value="<?php echo $row_id; ?>" />
                        <?php if ($menu_options) { ?>
                            <?php foreach ($menu_options as $key => $menu_option) { ?>
                                <?php if ($menu_option['display_type'] == 'radio') {?>
                                    <div class="option option-radio">
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />
                                        <label for=""><?php echo $menu_option['option_name']; ?></label>

                                        <?php if (isset($menu_option['option_values'])) { ?>
                                            <?php foreach ($menu_option['option_values'] as $option_value) { ?>
                                                <?php isset($cart_option_value_ids[$key]) OR $cart_option_value_ids[$key] = array() ?>
                                                <?php if (in_array($option_value['menu_option_value_id'], $cart_option_value_ids[$key]) OR (empty($cart_option_value_ids[$key]) AND $menu_option['default_value_id'] == $option_value['menu_option_value_id'])) { ?>
                                                    <div class="radio"><label>
                                                        <input type="radio" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" checked="checked" />
                                                        <?php echo $option_value['value']; ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } else { ?>
                                                    <div class="radio"><label>
                                                        <input type="radio" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" />
                                                        <?php echo $option_value['value']; ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <?php if ($menu_option['display_type'] == 'checkbox') {?>
                                    <div class="option option-checkbox">
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $key; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />
                                        <label for=""><?php echo $menu_option['option_name']; ?></label>

                                        <?php if (isset($menu_option['option_values'])) { ?>
                                            <?php foreach ($menu_option['option_values'] as $option_value) { ?>
                                                <?php isset($cart_option_value_ids[$key]) OR $cart_option_value_ids[$key] = array() ?>
                                                <?php if (in_array($option_value['menu_option_value_id'], $cart_option_value_ids[$key]) OR (empty($cart_option_value_ids[$key]) AND $menu_option['default_value_id'] == $option_value['menu_option_value_id'])) { ?>
                                                    <div class="checkbox"><label>
                                                        <input type="checkbox" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" checked="checked" />
                                                        <?php echo $option_value['value']; ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } else { ?>
                                                    <div class="checkbox"><label>
                                                        <input type="checkbox" name="menu_options[<?php echo $key; ?>][option_values][]" value="<?php echo $option_value['option_value_id']; ?>" />
                                                        <?php echo $option_value['value']; ?> <span class="price small"><?php echo $option_value['price']; ?></span>
                                                    </label></div>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                <?php } ?>

                                <?php if ($menu_option['display_type'] == 'select') {?>
                                    <div class="option option-select">
                                        <div class="form-group clearfix">
                                            <div class="col-sm-5 wrap-none">
                                                <input type="hidden" name="menu_options[<?php echo $key; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
                                                <input type="hidden" name="menu_options[<?php echo $key; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />

                                                <?php if (isset($menu_option['option_values'])) { ?>
                                                    <select name="menu_options[<?php echo $key; ?>][option_values][]" class="form-control">
                                                        <option value=""><?php echo $menu_option['option_name']; ?></option>
                                                        <?php foreach ($menu_option['option_values'] as $option_value) { ?>
                                                            <?php isset($cart_option_value_ids[$key]) OR $cart_option_value_ids[$key] = array() ?>
                                                            <?php if (in_array($option_value['menu_option_value_id'], $cart_option_value_ids[$key]) OR (empty($cart_option_value_ids[$key]) AND $menu_option['default_value_id'] == $option_value['menu_option_value_id'])) { ?>
                                                                <option value="<?php echo $option_value['option_value_id']; ?>" data-subtext="<?php echo $option_value['price']; ?>" selected="selected">
                                                                    <?php echo $option_value['value']; ?>
                                                                </option>
                                                            <?php } else { ?>
                                                                <option value="<?php echo $option_value['option_value_id']; ?>" data-subtext="<?php echo $option_value['price']; ?>">
                                                                    <?php echo $option_value['value']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </div>

                    <div class="form-group clearfix">
                        <div class="col-sm-10 wrap-none wrap-top">
                            <label for="comment"><?php echo lang('label_add_comment'); ?></label>
                            <textarea name="comment" class="form-control" rows="3"><?php echo $comment; ?></textarea>
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <br />
                            <?php if ($row_id) { ?>
                                <a class="btn btn-success btn-block" onclick="addToCart('<?php echo $menu_id; ?>');" title="<?php echo lang('text_update'); ?>"><?php echo lang('button_update'); ?></a>
                            <?php } else { ?>
                                <a class="btn btn-success btn-block" onclick="addToCart('<?php echo $menu_id; ?>');" title="<?php echo lang('text_add_to_order'); ?>"><?php echo lang('button_add_to_order'); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	//$('.option-select select.form-control').selectpicker({showSubtext:true});

	$('.quantity-control .btn').on('click', function() {
		var $button = $(this);
		var oldValue = $button.parent().parent().find('#quantity').val();

		if ($button.attr('data-dir') == 'up') {
			var newVal = parseFloat(oldValue) + 1;
		} else {
			var newVal = (oldValue > 0) ? parseFloat(oldValue) - 1 : 0;
		}

		$button.parent().parent().find('#quantity').val(newVal);
	});
});
//--></script>