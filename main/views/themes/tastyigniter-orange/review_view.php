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
					<div class="col-md-12">
						<div class="table-responsive">
						<table class="table table-none">
							<tr>
								<td><b>Restaurant:</b></td>
								<td><?php echo $location_name; ?></td>
							</tr>
							<tr>
								<td><b>Order ID:</b></td>
								<td><?php echo $sale_id; ?></td>
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

					<div class="col-md-12">
						<div class="buttons">
							<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
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