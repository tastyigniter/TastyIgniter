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
					<div class="col-md-12">
						<div class="table-responsive">
						<table class="table table-none">
							<tr>
								<td><b><?php echo lang('column_restaurant'); ?></b></td>
								<td><?php echo $location_name; ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_sale_id'); ?></b></td>
								<td><?php echo $sale_id; ?> - <?php echo ucwords($sale_type); ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_author'); ?></b></td>
								<td><?php echo $author; ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_rating'); ?></b></td>
								<td>
									<ul class="list-inline rating-inline">
										<li><b><?php echo lang('label_quality'); ?></b><br />
											<div class="rating rating-star" data-score="<?php echo $quality; ?>" data-readonly="true"></div>
										</li>
										<li><b><?php echo lang('label_delivery'); ?></b><br />
											<div class="rating rating-star" data-score="<?php echo $delivery; ?>" data-readonly="true"></div>
										</li>
										<li><b><?php echo lang('label_service'); ?></b><br />
											<div class="rating rating-star" data-score="<?php echo $service; ?>" data-readonly="true"></div>
										</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td><b><?php echo lang('label_review'); ?></b></td>
								<td><?php echo $review_text; ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('label_date'); ?></b></td>
								<td><?php echo $date; ?></td>
							</tr>
						</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="buttons">
							<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
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