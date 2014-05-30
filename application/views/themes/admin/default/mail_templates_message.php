<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box" class="content">
	<h2><?php echo $message_title; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<table class="form">
			<tbody>
				<tr>
					<td><b>Subject:</b></td>
					<td><input type="text" name="subject" value="<?php echo set_value('subject', $subject); ?>" class="textfield" size="40" /></td>
				</tr>
				<tr>
					<td><b>Text:</b></td>
					<td><textarea name="body" style="height:300px;width:800px;"><?php echo set_value('body', $body); ?></textarea></td>
				</tr>
				<tr>
					<td><b>Supported Variables:</b></td>
					<td><a class="show_hide" onclick="$('.supported_var').toggle()">Show/Hide</a>
						<ul class="supported_var" style="display:none;">
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
					</td>
				</tr>
			</tbody>
  		</table>
	</form>
	</div>
	</div>
</div>
<script src="<?php echo base_url("assets/js/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript"><!--
window.onload = function() {
    CKEDITOR.replace('body');
};
//--></script>
