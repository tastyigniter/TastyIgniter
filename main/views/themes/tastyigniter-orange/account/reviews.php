<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>

<?php if ($this->alert->get()) { ?>
    <div id="notification">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $this->alert->display(); ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div id="page-content">
	<div class="container top-spacing">
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

			<div class="content-wrap <?php echo $class; ?>">
				<div class="row">
					<div class="col-md-12 reviews-list">
						<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?php echo lang('column_sale_id'); ?></th>
									<th><?php echo lang('column_sale_type'); ?></th>
									<th><?php echo lang('column_restaurant'); ?></th>
									<th class="text-center"><?php echo lang('column_rating'); ?></th>
									<th><?php echo lang('column_date'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($reviews) { ?>
									<?php foreach ($reviews as $review) { ?>
									<tr>
										<td><a href="<?php echo $review['view']; ?>"><?php echo $review['sale_id']; ?></a></td>
										<td><?php echo ucwords($review['sale_type']); ?></td>
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
										<td colspan="4"><?php echo lang('text_empty'); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="buttons col-xs-6 wrap-none">
							<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
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
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	var ratings = <?php echo json_encode(array_values($ratings)); ?>;
	displayRatings(ratings);
});
//--></script>
<?php echo get_footer(); ?>