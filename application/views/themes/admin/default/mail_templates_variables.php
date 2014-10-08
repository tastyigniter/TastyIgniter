<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Supported Variables</title>
	<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/css/bootstrap.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/css/stylesheet.css'); ?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/js/jquery-1.10.2.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo base_url(APPPATH .'views/themes/'.ADMIN_URI.'/default/js/bootstrap.js'); ?>"></script>
</head>
<body>
    <div class="container">
		<div class="row content">
			<div class="list-group supported-var">
				<a href="#" class="list-group-item"><span>{site_logo}</span> - Site Logo</a>
				<a href="#" class="list-group-item"><span>{site_name}</span> - Site Name</a>
				<a href="#" class="list-group-item"><span>{location_name}</span> - Location Name</a>
				<a href="#" class="list-group-item"><span>{signature}</span> - Email Signature</a>

				<a href="#" class="list-group-item"><span>{full_name}</span> - Customer Full name</a>
				<a href="#" class="list-group-item"><span>{first_name}</span> - Customer First Name</a>
				<a href="#" class="list-group-item"><span>{last_name}</span> - Customer Last Name</a>
				<a href="#" class="list-group-item"><span>{email}</span> - Customer Email Address</a>

				<a href="#" class="list-group-item"><span>{login_link}</span> - Account Login Link</a>
				<a href="#" class="list-group-item"><span>{created_password}</span> - Create password on password reset</a>

				<a href="#" class="list-group-item"><span>{order_number}</span> - Order Number</a>
				<a href="#" class="list-group-item"><span>{order_link}</span> - Order Access Link</a>
				<a href="#" class="list-group-item"><span>{order_type}</span> - Order Type</a>
				<a href="#" class="list-group-item"><span>{order_time}</span> - Order Delivery/Collection Time</a>
				<a href="#" class="list-group-item"><span>{order_date}</span> - Order Delivery/Collection Date</a>
				<a href="#" class="list-group-item"><span>{order_address}</span> - Order Delivery Address</a>
				<a href="#" class="list-group-item"><span>{order_totals}</span> - Order Total List (Array)</a>
				<a href="#" class="list-group-item"><span>{title}</span> - Order Total Title</a>
				<a href="#" class="list-group-item"><span>{value}</span> - Order Total Value</a>

				<a href="#" class="list-group-item"><span>{reserve_number}</span> - Reservation Number</a>
				<a href="#" class="list-group-item"><span>{reserve_date}</span> - Reservation Date</a>
				<a href="#" class="list-group-item"><span>{reserve_time}</span> - Reservation Time</a>
				<a href="#" class="list-group-item"><span>{reserve_guest}</span> - Reservation Guest Number</a>

				<a href="#" class="list-group-item"><span>{menus}</span> - Ordered Menus List (Array)</a>
				<a href="#" class="list-group-item"><span>{option_name}</span> - Ordered Menu Option Name</a>
				<a href="#" class="list-group-item"><span>{option_price}</span> - Ordered Menu Option Price</a>
				<a href="#" class="list-group-item"><span>{quantity}</span> - Ordered Menu Quantity</a>
				<a href="#" class="list-group-item"><span>{price}</span> - Ordered Menu Price</a>
				<a href="#" class="list-group-item"><span>{subtotal}</span> - Ordered Menu Subtotal</a>

				<a href="#" class="list-group-item"><span>{contact_topic}</span> - Contact topic</a>
				<a href="#" class="list-group-item"><span>{contact_telephone}</span> - Contact telephone</a>
				<a href="#" class="list-group-item"><span>{contact_message}</span> - Contact Message Body</a>
			</div>
		</div>
		<script type="text/javascript">
		</script>    
</body>
</html>
