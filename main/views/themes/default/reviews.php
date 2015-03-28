<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">
<div class="row">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-9">
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
									<dl class="dl-horizontal dl-horizontal-rating">
										<dt><b>Quality:</b></dt>
										<dd><div class="rating rating-star" data-score="<?php echo $review['quality']; ?>" data-readonly="true"></div></dd>
										<dt><b>Delivery:</b></dt>
										<dd><div class="rating rating-star" data-score="<?php echo $review['delivery']; ?>" data-readonly="true"></div></dd>
										<dt><b>Service:</b></dt>
										<dd><div class="rating rating-star" data-score="<?php echo $review['service']; ?>" data-readonly="true"></div></dd>
									</dl>
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
				<div class="pagination-bar text-right">
					<div class="links"><?php echo $pagination['links']; ?></div>
					<div class="info"><?php echo $pagination['info']; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>