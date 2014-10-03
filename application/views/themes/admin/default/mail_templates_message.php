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

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="row wrap-all">
				<div class="form-group">
					<label for="input-title" class="col-sm-2">Title:</label>
					<div class="col-sm-7">
						<b><?php echo $message_title; ?></b>
						<a class="show_hide pull-right">Show/Hide supported variables</a>
					</div>
				</div>
				<div class="form-group">
					<label for="input-subject" class="col-sm-2 control-label">Subject:</label>
					<div class="col-sm-10">
						<input type="text" name="subject" id="input-subject" class="form-control" value="<?php echo set_value('subject', $subject); ?>" />
						<?php echo form_error('subject', '<span class="text-danger">', '</span>'); ?>
					</div>
				</div>

				<div class="form-group">
					<div id="input-body" class="col-md-12">
						<textarea name="body" style="height:300px;width:100%;" class="form-control"><?php echo set_value('body', $body); ?></textarea>
					</div>
					<div id="supported-var" class="col-md-3 border-all border-top border-bottom hide">
						<h4 class="border-bottom wrap-bottom">Supported Variables</h4>
						<ul class="list-group supported-var">
							<li><span>{site_logo}</span>Site Logo</li>
							<li><span>{site_name}</span>Site Name</li>
							<li><span>{location_name}</span>Location Name</li>
							<li><span>{signature}</span>Email Signature</li>

							<li><span>{full_name}</span>Customer Full name</li>
							<li><span>{first_name}</span>Customer First Name</li>
							<li><span>{last_name}</span>Customer Last Name</li>
							<li><span>{email}</span>Customer Email Address</li>

							<li><span>{login_link}</span>Account Login Link</li>
							<li><span>{created_password}</span>Create password on password reset</li>

							<li><span>{order_number}</span>Order Number</li>
							<li><span>{order_link}</span>Order Access Link</li>
							<li><span>{order_type}</span>Order Type</li>
							<li><span>{order_time}</span>Order Delivery/Collection Time</li>
							<li><span>{order_date}</span>Order Delivery/Collection Date</li>
							<li><span>{order_address}</span>Order Delivery Address</li>
							<li><span>{order_totals}</span>Order Total List (Array)</li>
							<li><span>{title}</span>Order Total Title</li>
							<li><span>{value}</span>Order Total Value</li>

							<li><span>{reserve_number}</span>Reservation Number</li>
							<li><span>{reserve_date}</span>Reservation Date</li>
							<li><span>{reserve_time}</span>Reservation Time</li>
							<li><span>{reserve_guest}</span>Reservation Guest Number</li>

							<li><span>{menus}</span>Ordered Menus List (Array)</li>
							<li><span>{option_name}</span>Ordered Menu Option Name</li>
							<li><span>{option_price}</span>Ordered Menu Option Price</li>
							<li><span>{quantity}</span>Ordered Menu Quantity</li>
							<li><span>{price}</span>Ordered Menu Price</li>
							<li><span>{subtotal}</span>Ordered Menu Subtotal</li>

							<li><span>{contact_topic}</span>Contact topic</li>
							<li><span>{contact_telephone}</span>Contact telephone</li>
							<li><span>{contact_message}</span>Contact Message Body</li>
						</ul>
					</div>
				</div>
			</div>
		</form>

		<div id="panel-supported-var" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display:none;">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
						<h4>Supported Variables</h4>
					</div>
		
					<div class="modal-body">
						<ul class="supported-var">
							<li><span>{site_logo}</span> -  Site Logo</li>
							<li><span>{site_name}</span> -  Site Name</li>
							<li><span>{location_name}</span> -  The Location Name</li>
							<li><span>{signature}</span> -  Email Signature</li>

							<li><span>{full_name}</span> -  Customer Full name</li>
							<li><span>{first_name}</span> -  Customer First Name</li>
							<li><span>{last_name}</span> -  Customer Last Name</li>
							<li><span>{email}</span> -  Customer Email Address</li>

							<li><span>{login_link}</span> -  Account Login Link</li>
							<li><span>{created_password}</span> -  Create password on password reset</li>

							<li><span>{order_number}</span> -  Order Number</li>
							<li><span>{order_link}</span> -  Order Access Link</li>
							<li><span>{order_type}</span> -  Order Type</li>
							<li><span>{order_time}</span> -  Order Delivery/Collection Time</li>
							<li><span>{order_date}</span> -  Order Delivery/Collection Date</li>
							<li><span>{order_address}</span> -  Order Delivery Address</li>
							<li><span>{order_totals}</span> -  Order Total List (Array)</li>
							<li><span>{title}</span> -  Order Total Title</li>
							<li><span>{value}</span> -  Order Total Value</li>

							<li><span>{reserve_number}</span> -  Reservation Number</li>
							<li><span>{reserve_date}</span> -  Reservation Date</li>
							<li><span>{reserve_time}</span> -  Reservation Time</li>
							<li><span>{reserve_guest}</span> -  Reservation Guest Number</li>

							<li><span>{menus}</span> -  Ordered Menus List (Array)</li>
							<li><span>{option_name}</span> -  Ordered Menu Option Name</li>
							<li><span>{option_price}</span> -  Ordered Menu Option Price</li>
							<li><span>{quantity}</span> -  Ordered Menu Quantity</li>
							<li><span>{price}</span> -  Ordered Menu Price</li>
							<li><span>{subtotal}</span> -  Ordered Menu Subtotal</li>

							<li><span>{contact_topic}</span> -  Contact topic</li>
							<li><span>{contact_telephone}</span> -  Contact telephone</li>
							<li><span>{contact_message}</span> -  Contact Message Body</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/tinymce/tinymce.js"); ?>"></script>
<script type="text/javascript">
tinymce.init({
    selector: 'textarea',
    menubar: false,
	plugins : 'table link image code charmap autolink lists textcolor variable',
	toolbar1: 'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | formatselect | bullist numlist | table hr code',
	toolbar2: 'forecolor backcolor | outdent indent | undo redo | link unlink anchor image | subscript superscript | charmap variable',
	removed_menuitems: 'newdocument',
	skin : 'tiskin',
	convert_urls : false,
    file_browser_callback : imageManager
});

$(document).on('click', '.show_hide', function() {
	if ($('#supported-var').hasClass('hide')) {
		$('#input-body').removeClass('col-md-12').addClass('col-md-9');
		$('#supported-var').removeClass('hide');
	} else {
		$('#input-body').removeClass('col-md-9').addClass('col-md-12');
		$('#supported-var').addClass('hide');
	}
});
</script>
<?php echo $footer; ?>