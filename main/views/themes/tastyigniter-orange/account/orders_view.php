<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
				</div>
			</div>
		</div>

		<div class="row">
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

			<div class="<?php echo $class; ?>">
				<div class="order-lists row">
				<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-none">
								<tr>
									<td><b><?php echo $column_id; ?>:</b></td>
									<td><?php echo $order_id; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $column_date; ?>:</b></td>
									<td><?php echo $order_time; ?> - <?php echo $date_added; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $column_order; ?>:</b></td>
									<td><?php echo $order_type; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $column_delivery; ?>:</b></td>
									<td><?php echo $delivery_address; ?></td>
								</tr>
								<tr>
									<td><b><?php echo $column_location; ?>:</b></td>
									<td><?php echo $location_name; ?><br /><?php echo $location_address; ?></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="heading-section">
							<h4>Order Menus</h4>
							<span class="under-heading"></span>
						</div>
						<div class="table-responsive">
							<table class="table table-hover">
								<tr>
									<th width="1"></th>
									<th align="left" width="70%">Name/Options</th>
									<th class="center">Price</th>
									<th class="right">Total</th>
								</tr>
								<?php foreach ($menus as $menu) { ?>
								<tr id="<?php echo $menu['id']; ?>">
									<td width="1"><?php echo $menu['qty']; ?>x</td>
									<td class="food_name"><?php echo $menu['name']; ?><br />
									<?php if (!empty($menu['options'])) { ?>
										<div><font size="1">+ <?php echo $menu['options']; ?></font></div>
									<?php } ?>
									</td>
									<td class="center"><?php echo $menu['price']; ?></td>
									<td class="right"><?php echo $menu['subtotal']; ?></td>
								</tr>
								<?php } ?>
								<?php foreach ($totals as $total) { ?>
								<tr>
									<td width="1"></td>
									<td></td>
									<td class="center"><b><?php echo $total['title']; ?></b></td>
									<td class="right"><b><?php echo $total['value']; ?></b></td>
								</tr>
								<?php } ?>
								<tr>
									<td width="1"></td>
									<td></td>
									<td class="center"><b>TOTAL</b></td>
									<td class="right"><b><?php echo $order_total; ?></b></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="buttons">
							<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo $button_back; ?></a>
							<a class="btn btn-primary" href="<?php echo $reorder_url; ?>"><?php echo $button_reorder; ?></a>
						</div>
					</div>
				</form>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>