<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>

<?php if ($this->alert->get()) { ?>
    <div id="notification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->alert->display(); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div id="page-content">
	<div class="container">
		<div class="row top-spacing">
			<?php echo get_partial('content_left'); ?>
			<?php
				if (partial_exists('content_left') AND partial_exists('content_right')) {
					$class = "col-sm-6 col-md-6";
				} else if (partial_exists('content_left') OR partial_exists('content_right')) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="content-wrap <?php echo $class; ?>">
				<div class="row">
					<div class="col-md-12">
						<ul id="nav-tabs" class="nav nav-tabs nav-tabs-line">
							<li class="active"><a href="#details" data-toggle="tab"><?php echo lang('text_my_details'); ?></a></li>
							<li><a href="#address" data-toggle="tab"><?php echo lang('text_default_address'); ?></a></li>
							<li><a href="#cart" data-toggle="tab"><?php echo lang('text_cart'); ?></a></li>
							<li><a href="#orders" data-toggle="tab"><?php echo lang('text_orders'); ?></a></li>
							<li><a href="#reservations" data-toggle="tab"><?php echo lang('text_reservations'); ?></a></li>
							<li><a href="#inbox" data-toggle="tab"><?php echo sprintf(lang('text_inbox'), $inbox_total); ?></a></li>
						</ul>
					</div>

					<div class="col-md-12">
						<div class="tab-content tab-content-line wrap-top">
							<div id="details" class="tab-pane active">
								<?php if ($customer_info) { ?>
								<div class="table-responsive">
									<table class="table table-none">
										<tbody>
											<tr>
												<td><b><?php echo lang('label_first_name'); ?></b></td>
												<td><?php echo $customer_info['first_name']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo lang('label_last_name'); ?></b></td>
												<td><?php echo $customer_info['last_name']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo lang('label_email'); ?></b></td>
												<td><?php echo $customer_info['email']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo lang('label_password'); ?></b></td>
												<td><a class="btn btn-default" href="<?php echo $password_url; ?>"><?php echo lang('text_change_password'); ?></a></td>
											</tr>
											<tr>
												<td><b><?php echo lang('label_telephone'); ?></b></td>
												<td><?php echo $customer_info['telephone']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo lang('label_s_question'); ?></b></td>
												<td><?php echo $customer_info['security_question']; ?></td>
											</tr>
											<tr>
												<td><b><?php echo lang('label_s_answer'); ?></b></td>
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
                                    <div class="btn-group btn-group-md col-md-12">
                                        <label class="btn btn-default wrap-all col-xs-3">
                                            <a class="edit-address pull-right" href="<?php echo $address_info_edit; ?>" data-original-title="" title=""><?php echo lang('text_edit'); ?></a>
                                            <address class="text-left"><?php echo $address_info; ?></address>
                                        </label>
                                    </div>
									<?php } else { ?>
										<p><?php echo lang('text_no_default_address'); ?></p>
									<?php } ?>
								</div>
							</div>

							<div id="cart" class="tab-pane">
								<?php if ($cart_items > 0) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
													<th><?php echo lang('column_cart_items'); ?></th>
													<th><?php echo lang('column_cart_total'); ?></th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?php echo $cart_items; ?></td>
													<td><?php echo $cart_total; ?></td>
													<td><a class="btn btn-primary" href="<?php echo $checkout_url; ?>"><?php echo lang('text_checkout'); ?></a></td>
												</tr>
											</tbody>
										</table>
									</div>
								<?php } else { ?>
									<div class="panel-body">
										<p><?php echo lang('text_no_cart_items'); ?></p>
									</div>
								<?php } ?>
							</div>

							<div id="orders" class="tab-pane">
								<?php if (!empty($orders)) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
													<th><?php echo lang('column_id'); ?></th>
													<th width="80%" class="text-center"><?php echo lang('column_status'); ?></th>
													<th><?php echo lang('column_date'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($orders as $order) { ?>
												<tr>
													<td><a href="<?php echo $order['view']; ?>"><?php echo $order['order_id']; ?></a></td>
													<td width="80%" class="text-center"><?php echo $order['status_name']; ?></td>
													<td><?php echo $order['order_time']; ?> - <?php echo $order['order_date']; ?></td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								<?php } else { ?>
									<div class="panel-body">
										<p><?php echo lang('text_no_orders'); ?></p>
									</div>
								<?php } ?>
							</div>

							<div id="reservations" class="tab-pane">
								<?php if (!empty($reservations)) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
                                                    <th><?php echo lang('column_id'); ?></th>
                                                    <th><?php echo lang('column_status'); ?></th>
                                                    <th><?php echo lang('column_date'); ?></th>
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
										<p><?php echo lang('text_no_reservations'); ?></p>
									</div>
								<?php } ?>
							</div>

							<div id="inbox" class="tab-pane">
								<?php if (!empty($messages)) { ?>
									<div class="table-responsive">
										<table class="table table-none">
											<thead>
												<tr>
                                                    <th><?php echo lang('column_date'); ?></th>
                                                    <th><?php echo lang('column_subject'); ?></th>
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
                                        <p><?php echo lang('text_no_inbox'); ?></p>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>