<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-9 page-content">
		<div class="order-lists row wrap-all">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th><?php echo $column_id; ?></th>
							<th><?php echo $column_status; ?></th>
							<th><?php echo $column_location; ?></th>
							<th><?php echo $column_date; ?></th>
							<th><?php echo $column_order; ?></th>
							<th><?php echo $column_items; ?></th>
							<th><?php echo $column_total; ?></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($orders) { ?>
						<?php foreach ($orders as $order) { ?>
						<tr>
							<td><a href="<?php echo $order['view']; ?>"><?php echo $order['order_id']; ?></a></td>
							<td><?php echo $order['status_name']; ?></td>
							<td><?php echo $order['location_name']; ?></td>
							<td><?php echo $order['order_time']; ?> - <?php echo $order['date_added']; ?></td>
							<td><?php echo $order['order_type']; ?></td>
							<td><?php echo $order['total_items']; ?></td>
							<td><?php echo $order['order_total']; ?></td>
							<td><a href="<?php echo $order['reorder']; ?>"><?php echo $text_reorder; ?></a></td>
							<td><a href="<?php echo $order['leave_review']; ?>"><?php echo $text_leave_review; ?></a></td>
						</tr>
						<?php } ?>
					<?php } else { ?>
						<tr>
							<td colspan="9"><?php echo $text_empty; ?></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row wrap-all">
			<div class="buttons col-xs-6 wrap-none">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
				<a class="btn btn-success" href="<?php echo $new_order_url; ?>"><?php echo $button_order; ?></a>
			</div>
	
			<div class="col-xs-6 wrap-none">
				<div class="pagination-box text-right">
					<?php echo $pagination['links']; ?>
					<div class="pagination-info"><?php echo $pagination['info']; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>