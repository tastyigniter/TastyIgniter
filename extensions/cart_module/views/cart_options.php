<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			<h4><?php echo $heading; ?></h4>
		</div>

		<div class="modal-body">
			<div class="row">
				<div id="cart-options-alert" class="col-md-12">
					<?php if ($option_alert) { ?>
					<div class="alert alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<?php echo $option_alert; ?>
					</div>
					<?php } ?>
				</div>

				<?php if ($description) { ?>
					<div class="description col-md-12"><p><?php echo $description; ?></p><br /></div>
				<?php } ?>

				<div id="menu-options<?php echo $menu_id; ?>" class="menu-options col-md-12">
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
											<?php if (in_array($option_value['menu_option_value_id'], $menu_option_value_ids)) { ?>
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
								<br />
							<?php } ?>

							<?php if ($menu_option['display_type'] == 'checkbox') {?>
								<div class="option option-checkbox">
									<input type="hidden" name="menu_options[<?php echo $key; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
									<input type="hidden" name="menu_options[<?php echo $key; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />
									<label for=""><?php echo $menu_option['option_name']; ?></label>

									<?php if (isset($menu_option['option_values'])) { ?>
										<?php foreach ($menu_option['option_values'] as $option_value) { ?>
											<?php if (in_array($option_value['menu_option_value_id'], $menu_option_value_ids)) { ?>
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
								<br />
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
														<?php if (in_array($option_value['menu_option_value_id'], $menu_option_value_ids)) { ?>
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

					<div class="form-group clearfix">
						<div class="col-sm-5 wrap-none">
							<label for="quantity">Menu Quantity</label>
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

					<div class="form-group clearfix">
						<div class="col-sm-10 wrap-none wrap-top">
							<label for="comment">Add Comment</label>
							<textarea name="comment" class="form-control" rows="3"></textarea>
						</div>
					</div>
					<div class="clearfix"></div>

					<div class="row">
						<div class="col-xs-12 col-md-6">
							<br />
							<?php if ($row_id) { ?>
								<a class="btn btn-success btn-block" onclick="addToCart('<?php echo $menu_id; ?>');" title="Update">UPDATE</a>
							<?php } else { ?>
								<a class="btn btn-success btn-block" onclick="addToCart('<?php echo $menu_id; ?>');" title="Add to order">ADD TO ORDER</a>
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