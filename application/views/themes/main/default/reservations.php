<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-xs-9">
		<div class="reservations-lists row wrap-all">
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
							<td><a href="<?php echo $reservation['leave_review']; ?>"><?php echo $text_leave_review; ?></a></td>
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

		<div class="row wrap-all">
			<div class="buttons col-xs-6 wrap-none">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
				<a class="btn btn-success" href="<?php echo $new_reserve_url; ?>"><?php echo $button_reserve; ?></a>
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