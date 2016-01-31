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
				<div class="reservations-lists row">
					<div class="col-md-12">
						<div class="table-responsive">
						<table class="table table-hover">
							<thead>
								<tr>
									<th><?php echo lang('column_id'); ?></th>
									<th><?php echo lang('column_status'); ?></th>
									<th><?php echo lang('column_location'); ?></th>
									<th><?php echo lang('column_date'); ?></th>
									<th><?php echo lang('column_table'); ?></th>
									<th><?php echo lang('column_guest'); ?></th>
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
									<td><a title="<?php echo lang('text_leave_review'); ?>" href="<?php echo $reservation['leave_review']; ?>"><i class="fa fa-heart"></i></a></td>
								</tr>
								<?php } ?>
							<?php } else { ?>
								<tr>
									<td colspan="7"><?php echo lang('text_empty'); ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						</div>
					</div>

					<div class="col-md-12">
						<div class="buttons col-xs-6 wrap-none">
							<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
							<a class="btn btn-primary btn-lg" href="<?php echo $new_reservation_url; ?>"><?php echo lang('button_reserve'); ?></a>
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
<?php echo get_footer(); ?>