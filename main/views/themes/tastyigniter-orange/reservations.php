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
				<div class="reservations-lists row">
					<div class="col-md-12">
						<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?php echo $column_id; ?></th>
									<th><?php echo $column_status; ?></th>
									<th><?php echo $column_location; ?></th>
									<th><?php echo $column_date; ?></th>
									<th><?php echo $column_table; ?></th>
									<th><?php echo $column_guest; ?></th>
									<th></th>
								</tr>
							</thead>
							<tbody>
							<?php if ($reservations) { ?>
								<?php foreach ($reservations as $reservation) { ?>
								<tr>
									<td><a href="<?php echo $reservation['view']; ?>"><?php echo $reservation['reservation_id']; ?></a></td>
									<td><?php echo $reservation['status_name']; ?></td>
									<td><?php echo $reservation['location_name']; ?></td>
									<td><?php echo $reservation['reserve_time']; ?> - <?php echo $reservation['reserve_date']; ?></td>
									<td><?php echo $reservation['table_name']; ?></td>
									<td><?php echo $reservation['guest_num']; ?></td>
									<td><a title="<?php echo $text_leave_review; ?>" href="<?php echo $reservation['leave_review']; ?>"><i class="fa fa-heart"></i></a></td>
								</tr>
								<?php } ?>
							<?php } else { ?>
								<tr>
									<td colspan="7"><?php echo $text_empty; ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="buttons col-xs-6 wrap-none">
							<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
							<a class="btn btn-success" href="<?php echo $new_reserve_url; ?>"><?php echo $button_reserve; ?></a>
						</div>

						<div class="col-xs-6 wrap-none">
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