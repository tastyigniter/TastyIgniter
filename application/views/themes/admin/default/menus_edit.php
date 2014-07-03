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
				<li class="active"><a href="#general" data-toggle="tab">Menu</a></li>
				<li><a href="#menu-options" data-toggle="tab">Menu Options</a></li>
				<li><a href="#specials" data-toggle="tab">Specials</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="menu_name" id="input-name" class="form-control" value="<?php echo set_value('menu_name', $menu_name); ?>" />
							<?php echo form_error('menu_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-2 control-label">Description:</label>
						<div class="col-sm-5">
							<textarea name="menu_description" id="input-description" class="form-control" rows="5"><?php echo set_value('menu_description', $menu_description); ?></textarea>
							<?php echo form_error('menu_description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-price" class="col-sm-2 control-label">Price:</label>
						<div class="col-sm-5">
							<input type="text" name="menu_price" id="input-price" class="form-control" value="<?php echo set_value('menu_price', $menu_price); ?>" />
							<?php echo form_error('menu_price', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Category:</label>
						<div class="col-sm-5">
							<select name="menu_category" id="category" class="form-control">
								<option value="">Select category</option>
							<?php foreach ($categories as $category) { ?>
							<?php if ($menu_category === $category['category_id']) { ?>
								<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
							<?php } ?>
							<?php } ?>
							</select>
							<?php echo form_error('menu_category', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-2 control-label">Photo:
							<span class="help-block">Select a file to update menu photo, otherwise leave blank.</span>
						</label>
						<div class="col-sm-5">
							<div class="thumbnail imagebox" id="selectImage">
								<div class="preview">
									<img src="<?php echo $menu_image_url; ?>" class="thumb img-responsive" id="thumb">
								</div>
								<div class="caption">
									<center class="name"><?php echo $image_name; ?></center>
									<input type="hidden" name="menu_photo" value="<?php echo set_value('menu_photo', $menu_image); ?>" id="field" />
									<p>
										<a id="select-image" class="btn btn-select-image" onclick="imageUpload('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;Select</a>
										<a class="btn btn-times" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', 'data/no_photo.png'); $(this).parent().parent().find('center').html('no_photo.png');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Remove</a>
									</p>
								</div>
							</div>
							<?php echo form_error('menu_photo', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-stock" class="col-sm-2 control-label">Stock Quantity:
							<span class="help-block">Set to 0 for unlimited stock quantity.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="stock_qty" id="input-stock" class="form-control" value="<?php echo set_value('stock_qty', $stock_qty); ?>" />
							<?php echo form_error('stock_qty', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-minimum" class="col-sm-2 control-label">Minimum Quantity:
							<span class="help-block">The minimum quantity that can be ordered. Default is 1, unless set otherwise.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="minimum_qty" id="input-minimum" class="form-control" value="<?php echo set_value('minimum_qty', $minimum_qty); ?>" />
							<?php echo form_error('minimum_qty', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-subtract-stock" class="col-sm-2 control-label">Subtract Stock:</label>
						<div class="col-sm-5">
							<select name="subtract_stock" id="input-subtract-stock" class="form-control">
								<option value="0" <?php echo set_select('subtract_stock', '0'); ?> >No</option>
							<?php if ($subtract_stock === '1') { ?>
								<option value="1" <?php echo set_select('subtract_stock', '1', TRUE); ?> >Yes</option>
							<?php } else { ?>  
								<option value="1" <?php echo set_select('subtract_stock', '1'); ?> >Yes</option>
							<?php } ?>  
							</select>
							<?php echo form_error('subtract_stock', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<select name="menu_status" id="input-status" class="form-control">
								<option value="0" <?php echo set_select('menu_status', '0'); ?> >Disabled</option>
							<?php if ($menu_status === '1') { ?>
								<option value="1" <?php echo set_select('menu_status', '1', TRUE); ?> >Enabled</option>
							<?php } else { ?>  
								<option value="1" <?php echo set_select('menu_status', '1'); ?> >Enabled</option>
							<?php } ?>  
							</select>
							<?php echo form_error('menu_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="menu-options" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Menu Options:</label>
						<div class="col-sm-5">
							<input type="text" name="menu_option" id="input-status" class="form-control" value="" />
							<?php echo form_error('menu_option', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label"></label>
						<div id="menu-option" class="col-sm-5">
							<div class="table-responsive panel-selected">
								<table class="table table-striped table-border">
									<thead>
										<tr>
											<th>Option Name</th>
											<th>Option Price</th>
											<th>Remove</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach ($menu_options as $menu_option) { ?>
										<?php if (in_array($menu_option['option_id'], $has_options)) { ?>
										<tr id="menu-option<?php echo $menu_option['option_id']; ?>">
											<td class="name"><?php echo $menu_option['option_name']; ?></td>
											<td><?php echo $menu_option['option_price']; ?></td>
											<td class="img">
												<a class="btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>
												<input type="hidden" name="menu_options[]" value="<?php echo $menu_option['option_id']; ?>" />
											</td>
										</tr>
										<?php } ?>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>

				<div id="specials" class="tab-pane row wrap-all">
					<div class="form-group">
						<label for="start-date" class="col-sm-2 control-label">Start Date</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="start_date" id="start-date" class="form-control" value="<?php echo set_value('start_date', $start_date); ?>" />
								<span id="discount-addon" class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
							<?php echo form_error('start_date', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="end-date" class="col-sm-2 control-label">End Date</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="end_date" id="end-date" class="form-control" value="<?php echo set_value('end_date', $end_date); ?>" />
								<span id="discount-addon" class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
							<?php echo form_error('end_date', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-special-price" class="col-sm-2 control-label">Special Price</label>
						<div class="col-sm-5">
							<input type="text" name="special_price" id="input-special-price" class="form-control" value="<?php echo set_value('special_price', $special_price); ?>" />
							<?php echo form_error('special_price', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-special-status" class="col-sm-2 control-label">Special Status</label>
						<div class="col-sm-5">
							<select name="special_status" id="input-special-status" class="form-control">
							<?php if ($special_status) { ?>
								<option value="0" <?php echo set_select('special_status', '0'); ?> >Disabled</option>
								<option value="1" selected="selected" <?php echo set_select('special_status', '1'); ?> >Enabled</option>
							<?php } else { ?>
								<option value="0" <?php echo set_select('special_status', '0'); ?> >Disabled</option>
								<option value="1" <?php echo set_select('special_status', '1'); ?> >Enabled</option>
							<?php } ?>
							</select>
							<input type="hidden" name="special_id" value="<?php echo set_value('special_id', $special_id); ?>" />
							<?php echo form_error('special_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'dd-mm-yy',
	});
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'menu_option\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/menu_options/autocomplete"); ?>?option_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.option_name,
						value: item.option_id,
						price: item.option_price
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#menu-option' + ui.item.value).remove();
		$('#menu-option table tbody').append('<tr id="menu-option' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.price + '</td><td class="img">' + '<a class="btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a>' + '<input type="hidden" name="menu_options[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/fancybox/jquery.fancybox.css"); ?>">
<script src="<?php echo base_url("assets/js/fancybox/jquery.fancybox.js"); ?>"></script>
<script type="text/javascript"><!--
function imageUpload(field) {
	$('#image-manager').remove();
		
	var iframe_url = js_site_url('admin/image_manager?popup=iframe&field_id=') + encodeURIComponent(field);

	$('body').prepend('<div id="image-manager" style="padding: 3px 0px 0px 0px;"><iframe src="'+ iframe_url +'" width="980" height="550" frameborder="0"></iframe></div>');
	
	$.fancybox({	
 		href:"#image-manager",
		autoScale: false,
		afterClose: function() {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: js_site_url('admin/image_manager/resize?image=') + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'json',
					success: function(json) {
						var thumb = $('#' + field).parent().parent().find('.thumb');
						$(thumb).replaceWith('<img src="' + json + '" alt="" class="thumb" id="thumb" />');
					}
				});
			}
		}
	});
};
//--></script>
<?php echo $footer; ?>