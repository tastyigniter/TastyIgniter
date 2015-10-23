<div class="modal fade" id="mail-variables" tabindex="-1" role="dialog" aria-labelledby="<?php echo $this->template->getHeading(); ?>" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel"><?php echo $this->template->getHeading(); ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="list-group supported-var">
						<a href="#" class="list-group-item"><h4 class="list-group-item-heading">General</h4></a>
						<a href="#" class="list-group-item"><span class="text-muted">{site_logo}</span> Site Logo</a>
						<a href="#" class="list-group-item"><span class="text-muted">{site_url}</span> Site URL</a>
						<a href="#" class="list-group-item"><span class="text-muted">{site_name}</span> Site Name</a>
						<a href="#" class="list-group-item"><span class="text-muted">{location_name}</span> Location Name</a>
						<a href="#" class="list-group-item"><span class="text-muted">{signature}</span> Email Signature</a>

						<a href="#" class="list-group-item"><h4 class="list-group-item-heading">Customer</h4></a>
						<a href="#" class="list-group-item"><span class="text-muted">{full_name}</span> Customer Full name</a>
						<a href="#" class="list-group-item"><span class="text-muted">{first_name}</span> Customer First Name</a>
						<a href="#" class="list-group-item"><span class="text-muted">{last_name}</span> Customer Last Name</a>
						<a href="#" class="list-group-item"><span class="text-muted">{email}</span> Customer Email Address</a>

						<a href="#" class="list-group-item"><h4 class="list-group-item-heading">Staff</h4></a>
						<a href="#" class="list-group-item"><span class="text-muted">{staff_name}</span> Staff Name</a>

						<a href="#" class="list-group-item"><h4 class="list-group-item-heading">Registration</h4></a>
						<a href="#" class="list-group-item"><span class="text-muted">{login_link}</span> Account Login Link</a>
						<a href="#" class="list-group-item"><span class="text-muted">{created_password}</span> Create password on password reset</a>

						<a href="#" class="list-group-item"><h4 class="list-group-item-heading">Order</h4></a>
						<a href="#" class="list-group-item"><span class="text-muted">{order_number}</span> Order Number</a>
						<a href="#" class="list-group-item"><span class="text-muted">{order_link}</span> Order Access Link</a>
						<a href="#" class="list-group-item"><span class="text-muted">{order_type}</span> Order Type</a>
						<a href="#" class="list-group-item"><span class="text-muted">{order_time}</span> Order Delivery/Collection Time</a>
						<a href="#" class="list-group-item"><span class="text-muted">{order_date}</span> Order Delivery/Collection Date</a>
						<a href="#" class="list-group-item"><span class="text-muted">{order_address}</span> Order Delivery Address</a>
						<a href="#" class="list-group-item"><span class="text-muted">{order_totals}</span> Order Total List (Array)</a>
						<a href="#" class="list-group-item"><span class="text-muted">{title}</span> Order Total Title</a>
						<a href="#" class="list-group-item"><span class="text-muted">{value}</span> Order Total Value</a>

						<a href="#" class="list-group-item"><span class="text-muted">{menus}</span> Ordered Menus List (Array)</a>
						<a href="#" class="list-group-item"><span class="text-muted">{option_name}</span> Ordered Menu Option Name</a>
						<a href="#" class="list-group-item"><span class="text-muted">{option_price}</span> Ordered Menu Option Price</a>
						<a href="#" class="list-group-item"><span class="text-muted">{quantity}</span> Ordered Menu Quantity</a>
						<a href="#" class="list-group-item"><span class="text-muted">{price}</span> Ordered Menu Price</a>
						<a href="#" class="list-group-item"><span class="text-muted">{subtotal}</span> Ordered Menu Subtotal</a>

						<a href="#" class="list-group-item"><h4 class="list-group-item-heading">Reservation</h4></a>
						<a href="#" class="list-group-item"><span class="text-muted">{reserve_number}</span> Reservation Number</a>
						<a href="#" class="list-group-item"><span class="text-muted">{reserve_date}</span> Reservation Date</a>
						<a href="#" class="list-group-item"><span class="text-muted">{reserve_time}</span> Reservation Time</a>
						<a href="#" class="list-group-item"><span class="text-muted">{reserve_guest}</span> Reservation Guest Number</a>

						<a href="#" class="list-group-item"><h4 class="list-group-item-heading">Contact</h4></a>
						<a href="#" class="list-group-item"><span class="text-muted">{contact_topic}</span> Contact topic</a>
						<a href="#" class="list-group-item"><span class="text-muted">{contact_telephone}</span> Contact telephone</a>
						<a href="#" class="list-group-item"><span class="text-muted">{contact_message}</span> Contact Message Body</a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>