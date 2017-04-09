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
				<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>">
					<div class="reservation-lists row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-none">
									<tr>
										<td><b><?php echo lang('column_id'); ?>:</b></td>
										<td><?php echo $reservation_id; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_date'); ?>:</b></td>
										<td><?php echo $reserve_time; ?> - <?php echo $reserve_date; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_table'); ?>:</b></td>
										<td><?php echo $table_name; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_guest'); ?>:</b></td>
										<td><?php echo $guest_num; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_location'); ?>:</b></td>
										<td><?php echo $location_name; ?><br /><?php echo $location_address; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_occasion'); ?>:</b></td>
										<td><?php echo $occasions[$occasion_id]; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_name'); ?>:</b></td>
										<td><?php echo $first_name; ?> <?php echo $last_name; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_email'); ?>:</b></td>
										<td><?php echo $email; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_telephone'); ?>:</b></td>
										<td><?php echo $telephone; ?></td>
									</tr>
									<tr>
										<td><b><?php echo lang('column_comment'); ?>:</b></td>
										<td><?php echo $comment; ?></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="col-md-12">
							<div class="buttons">
								<a class="btn btn-primary btn-lg" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
							</div>
						</div>
					</div>
				</form>
			</div>
			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>