<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-9">
		<div class="order-lists row wrap-all">
		<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
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

			<h4>Order Menus</h4>
			<div class="table-responsive">
				<table class="table table-striped">
					<tr>
						<th width="1"></th>
						<th align="left" width="35%">Name/Options</th>
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

			<div class="row wrap-all">
				<div class="buttons">
					<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo $button_back; ?></a>
					<a class="btn btn-success" href="<?php echo $reorder_url; ?>"><?php echo $button_reorder; ?></a>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>