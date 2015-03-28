<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
				</div>
			</div>
		</div>

		<div class="row">
			<?php echo $content_left; ?>
			<?php
				if (!empty($content_left) AND !empty($content_right)) {
					$class = "col-sm-6 col-md-6";
				} else if (!empty($content_left) OR !empty($content_right)) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<div class="row">
					<div class="col-md-12">
						<ul id="nav-tabs" class="nav nav-tabs nav-tabs-line">
							<li class="active"><a href="#details" data-toggle="tab"><?php echo $text_my_details; ?></a></li>
							<li><a href="#address" data-toggle="tab"><?php echo $text_default_address; ?></a></li>
							<li><a href="#cart" data-toggle="tab"><?php echo $text_cart; ?></a></li>
							<li><a href="#orders" data-toggle="tab"><?php echo $text_orders; ?></a></li>
							<li><a href="#reservations" data-toggle="tab"><?php echo $text_reservations; ?></a></li>
							<li><a href="#inbox" data-toggle="tab"><?php echo $text_inbox; ?></a></li>
						</ul>
					</div>

					<div class="col-md-12">
						<div class="tab-content tab-content-line">
							<div id="details" class="tab-pane active">
								<?php if ($customer_info) { ?>
								<div class="table-responsive">
									<table class="table table-none">
										<tbody>
											<tr>
												<td><b><?php echo $entry_first_name; ?></b></td>
												<td><?php echo $customer_info['first_name']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo $entry_last_name; ?></b></td>
												<td><?php echo $customer_info['last_name']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo $entry_email; ?></b></td>
												<td><?php echo $customer_info['email']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo $entry_password; ?></b></td>
												<td><a class="btn btn-default" href="<?php echo $password_url; ?>"><?php echo $text_password; ?></a></td>
											</tr>
											<tr>
												<td><b><?php echo $entry_telephone; ?></b></td>
												<td><?php echo $customer_info['telephone']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo $entry_s_question; ?></b></td>
												<td><?php echo $customer_info['security_question']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo $entry_s_answer; ?></b></td>
												<td><?php echo $customer_info['security_answer']; ?></td>
											</tr>
										</tbody>
									</table>
								</div>
								<?php } ?>
							</div>

							<div id="address" class="tab-pane">
								<div class="">
									<?php if ($address_info) { ?>
										<address><?php echo $address_info; ?></address>
									<?php } else { ?>
										<p><?php echo $text_no_default_add; ?></p>
									<?php } ?>
								</div>
							</div>

							<div id="cart" class="tab-pane">
								<?php if ($cart_items > 0) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
													<th><?php echo $column_cart_items; ?></th>
													<th><?php echo $column_cart_total; ?></th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $cart_items; ?></td>
													<td><?php echo $cart_total; ?></td>
													<td><a class="btn btn-success" href="<?php echo $button_checkout; ?>"><?php echo $text_checkout; ?></a></td>
												</tr>
											</tbody>
										</table>
									</div>
								<?php } else { ?>
									<div class="panel-body">
										<p><?php echo $text_no_cart_items; ?></p>
									</div>
								<?php } ?>
							</div>

							<div id="orders" class="tab-pane">
								<?php if (!empty($orders)) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
													<th><?php echo $column_id; ?></th>
													<th width="80%" class="text-center"><?php echo $column_status; ?></th>
													<th><?php echo $column_date; ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($orders as $order) { ?>
												<tr>
													<td><a href="<?php echo $order['view']; ?>"><?php echo $order['order_id']; ?></a></td>
													<td width="80%" class="text-center"><?php echo $order['status_name']; ?></td>
													<td><?php echo $order['order_time']; ?> - <?php echo $order['date_added']; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								<?php } else { ?>
									<div class="panel-body">
										<p><?php echo $text_no_orders; ?></p>
									</div>
								<?php } ?>
							</div>

							<div id="reservations" class="tab-pane">
								<?php if (!empty($reservations)) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
													<th><?php echo $column_id; ?></th>
													<th><?php echo $column_status; ?></th>
													<th><?php echo $column_date; ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($reservations as $reservation) { ?>
												<tr>
													<td><a href="<?php echo $reservation['view']; ?>"><?php echo $reservation['reservation_id']; ?></a></td>
													<td><?php echo $reservation['status_name']; ?></td>
													<td><?php echo $reservation['reserve_time']; ?> - <?php echo $reservation['reserve_date']; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								<?php } else { ?>
									<div class="panel-body">
										<p><?php echo $text_no_reservations; ?></p>
									</div>
								<?php } ?>
							</div>

							<div id="inbox" class="tab-pane">
								<?php if (!empty($messages)) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
													<th><?php echo $column_date; ?></th>
													<th><?php echo $column_subject; ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($messages as $message) { ?>
												<tr class="<?php echo $message['state']; ?>">
													<td>
														<a class="edit" href="<?php echo $message['view']; ?>"><?php echo $message['subject']; ?></a><br />
														<font size="1"><?php echo $message['body']; ?></font>
													</td>
													<td><?php echo $message['date_added']; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								<?php } else { ?>
									<div class="panel-body">
										<p><?php echo $text_no_inbox; ?></p>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo $content_right; ?>
			<?php echo $content_bottom; ?>
		</div>
	</div>
</div>
<?php echo $footer; ?>