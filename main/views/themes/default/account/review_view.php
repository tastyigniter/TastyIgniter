<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row">
	<?php echo get_partial('content_left'); ?><?php echo get_partial('content_right'); ?>

	<div class="col-md-8">
		<div class="row wrap-all">
			<div class="table-responsive">
				<table class="table table-none">
					<tr>
						<td><b>Restaurant:</b></td>
						<td><?php echo $location_name; ?></td>
					</tr>
					<tr>
						<td><b>Order ID:</b></td>
						<td><?php echo $order_id; ?></td>
					</tr>
					<tr>
						<td><b>Author:</b></td>
						<td><?php echo $author; ?></td>
					</tr>
					<tr>
						<td><b>Rating:</b></td>
						<td>
							<ul class="list-inline rating-inline">
								<li><b>Quality:</b><br />
									<div class="rating rating-star" data-score="<?php echo $quality; ?>" data-readonly="true"></div>
								</li>
								<li><b>Delivery:</b><br />
									<div class="rating rating-star" data-score="<?php echo $delivery; ?>" data-readonly="true"></div>
								</li>
								<li><b>Service:</b><br />
									<div class="rating rating-star" data-score="<?php echo $service; ?>" data-readonly="true"></div>
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td><b>Review Text:</b></td>
						<td><?php echo $review_text; ?></td>
					</tr>
					<tr>
						<td><b>Review Date:</b></td>
						<td><?php echo $date; ?></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="row wrap-all">
			<div class="buttons">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
			</div>
		</div>
	</form>
</div>
<?php echo get_footer(); ?>