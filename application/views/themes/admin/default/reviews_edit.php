<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Review Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-location" class="col-sm-2 control-label">Restaurant:</label>
						<div class="col-sm-5">
							<select name="location_id" id="input-location" class="form-control">
								<?php foreach ($locations as $location) { ?>
								<?php if ($location['location_id'] === $location_id) { ?>
									<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
								<?php } ?>  
								<?php } ?>  
							</select>
							<?php echo form_error('location_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order" class="col-sm-2 control-label">Order ID:</label>
						<div class="col-sm-5">
							<input type="text" name="order_id" id="input-order" class="form-control" value="<?php echo set_value('order_id', $order_id); ?>"/>
							<?php echo form_error('order_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-author" class="col-sm-2 control-label">Author:</label>
						<div class="col-sm-5">
							<input type="text" name="author" id="input-author" class="form-control" value="<?php echo set_value('author', $author); ?>"/>
							<input type="hidden" name="customer_id" value="<?php echo set_value('customer_id', $customer_id); ?>"/>
							<?php echo form_error('author', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-quality" class="col-sm-2 control-label">Quality Rating:</label>
						<div class="col-sm-5">
							<select name="quality" id="input-quality" class="form-control">
								<?php foreach ($ratings as $key => $rating) { ?>
								<?php if ($key == $quality) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $rating; ?></option>
								<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $rating; ?></option>
								<?php }?>
								<?php }?>
							</select>
							<?php echo form_error('quality', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-delivery" class="col-sm-2 control-label">Delivery Rating:</label>
						<div class="col-sm-5">
							<select name="delivery" id="input-delivery" class="form-control">
								<?php foreach ($ratings as $key => $rating) { ?>
								<?php if ($key == $delivery) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $rating; ?></option>
								<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $rating; ?></option>
								<?php }?>
								<?php }?>
							</select>
							<?php echo form_error('delivery', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-service" class="col-sm-2 control-label">Service Rating:</label>
						<div class="col-sm-5">
							<select name="service" id="input-service" class="form-control">
								<?php foreach ($ratings as $key => $rating) { ?>
								<?php if ($key == $service) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $rating; ?></option>
								<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $rating; ?></option>
								<?php }?>
								<?php }?>
							</select>
							<?php echo form_error('service', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-review-text" class="col-sm-2 control-label">Review Text:</label>
						<div class="col-sm-5">
							<textarea name="review_text" id="input-review-text" class="form-control" rows="7"><?php echo set_value('review_text', $review_text); ?></textarea>
							<?php echo form_error('review_text', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Review Status:</label>
						<div class="col-sm-5">
							<select name="review_status" id="input-status" class="form-control">
								<option value="0" <?php echo set_select('review_status', '0'); ?> >Pending Review</option>
								<?php if ($review_status === '1') { ?>
									<option value="1" <?php echo set_select('review_status', '1', TRUE); ?> >Approved</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('review_status', '1'); ?> >Approved</option>
								<?php } ?>  
							</select>
							<?php echo form_error('review_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$('input[name=\'menu\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/menus/autocomplete"); ?>?menu=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.menu_name,
						value: item.menu_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'menu\']').val(ui.item.label);
		$('input[name=\'menu_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'author\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/customers/autocomplete"); ?>?customer_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.customer_name,
						value: item.customer_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'author\']').val(ui.item.label);
		$('input[name=\'customer_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<?php echo $footer; ?>