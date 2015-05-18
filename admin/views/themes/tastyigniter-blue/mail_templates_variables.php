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
						<a href="#" class="list-group-item"><span class="badge">{site_logo}</span> Site Logo</a>
						<a href="#" class="list-group-item"><span class="badge">{site_name}</span> Site Name</a>
						<a href="#" class="list-group-item"><span class="badge">{location_name}</span> Location Name</a>
						<a href="#" class="list-group-item"><span class="badge">{signature}</span> Email Signature</a>

						<a href="#" class="list-group-item"><span class="badge">{full_name}</span> Customer Full name</a>
						<a href="#" class="list-group-item"><span class="badge">{first_name}</span> Customer First Name</a>
						<a href="#" class="list-group-item"><span class="badge">{last_name}</span> Customer Last Name</a>
						<a href="#" class="list-group-item"><span class="badge">{email}</span> Customer Email Address</a>

						<a href="#" class="list-group-item"><span class="badge">{login_link}</span> Account Login Link</a>
						<a href="#" class="list-group-item"><span class="badge">{created_password}</span> Create password on password reset</a>

						<a href="#" class="list-group-item"><span class="badge">{order_number}</span> Order Number</a>
						<a href="#" class="list-group-item"><span class="badge">{order_link}</span> Order Access Link</a>
						<a href="#" class="list-group-item"><span class="badge">{order_type}</span> Order Type</a>
						<a href="#" class="list-group-item"><span class="badge">{order_time}</span> Order Delivery/Collection Time</a>
						<a href="#" class="list-group-item"><span class="badge">{order_date}</span> Order Delivery/Collection Date</a>
						<a href="#" class="list-group-item"><span class="badge">{order_address}</span> Order Delivery Address</a>
						<a href="#" class="list-group-item"><span class="badge">{order_totals}</span> Order Total List (Array)</a>
						<a href="#" class="list-group-item"><span class="badge">{title}</span> Order Total Title</a>
						<a href="#" class="list-group-item"><span class="badge">{value}</span> Order Total Value</a>

						<a href="#" class="list-group-item"><span class="badge">{reserve_number}</span> Reservation Number</a>
						<a href="#" class="list-group-item"><span class="badge">{reserve_date}</span> Reservation Date</a>
						<a href="#" class="list-group-item"><span class="badge">{reserve_time}</span> Reservation Time</a>
						<a href="#" class="list-group-item"><span class="badge">{reserve_guest}</span> Reservation Guest Number</a>

						<a href="#" class="list-group-item"><span class="badge">{menus}</span> Ordered Menus List (Array)</a>
						<a href="#" class="list-group-item"><span class="badge">{option_name}</span> Ordered Menu Option Name</a>
						<a href="#" class="list-group-item"><span class="badge">{option_price}</span> Ordered Menu Option Price</a>
						<a href="#" class="list-group-item"><span class="badge">{quantity}</span> Ordered Menu Quantity</a>
						<a href="#" class="list-group-item"><span class="badge">{price}</span> Ordered Menu Price</a>
						<a href="#" class="list-group-item"><span class="badge">{subtotal}</span> Ordered Menu Subtotal</a>

						<a href="#" class="list-group-item"><span class="badge">{contact_topic}</span> Contact topic</a>
						<a href="#" class="list-group-item"><span class="badge">{contact_telephone}</span> Contact telephone</a>
						<a href="#" class="list-group-item"><span class="badge">{contact_message}</span> Contact Message Body</a>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>