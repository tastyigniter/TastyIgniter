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
					<div class="order-lists col-md-12">
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
										<td><a class="text-info" title="<?php echo $text_reorder; ?>" href="<?php echo $order['reorder']; ?>"><i class="fa fa-mail-reply"></i></a></td>
										<td><a title="<?php echo $text_leave_review; ?>" href="<?php echo $order['leave_review']; ?>"><i class="fa fa-heart"></i></a></td>
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

					<div class="col-md-12">
						<div class="buttons col-xs-6 wrap-none">
							<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
							<a class="btn btn-primary" href="<?php echo $new_order_url; ?>"><?php echo $button_order; ?></a>
						</div>

						<div class="col-xs-6">
							<div class="pagination-bar text-right">
								<div class="links"><?php echo $pagination['links']; ?></div>
								<div class="info"><?php echo $pagination['info']; ?></div>
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