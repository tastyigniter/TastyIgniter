<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>

<div id="notification" class="row">
<?php if (!empty($alert)) { ?>
	<div class="alert alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $alert; ?>
	</div>
<?php } ?>
</div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-xs-9">
		<div class="row wrap-all">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th><?php echo $column_order_id; ?></th>
							<th><?php echo $column_restaurant; ?></th>
							<th><?php echo $column_rating; ?></th>
							<th><?php echo $column_date; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($reviews) { ?>
							<?php foreach ($reviews as $review) { ?>
							<tr>
								<td><a href="<?php echo $review['view']; ?>"><?php echo $review['order_id']; ?></a></td>
								<td><?php echo $review['location_name']; ?></td>
								<td>
									<b>Quality:</b> <?php echo $review['quality']; ?><br />
									<b>Delivery:</b> <?php echo $review['delivery']; ?><br />
									<b>Service:</b> <?php echo $review['service']; ?>
								</td>
								<td><?php echo $review['date']; ?></td>
							</tr>
							<?php } ?>
						<?php } else { ?>
							<tr>
								<td colspan="4"><?php echo $text_empty; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row wrap-all">
			<div class="buttons col-xs-6 wrap-none">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
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