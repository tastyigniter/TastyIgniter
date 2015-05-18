<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
				</div>
			</div>
		</div>

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

			<div class="<?php echo $class; ?>">
				<div class="row">
					<div class="table-responsive">
						<table class="table table-none">
							<tr>
								<td width="20%"><b><?php echo $column_date; ?>:</b></td>
								<td><?php echo $date_added; ?></td>
							</tr>
							<tr>
								<td><b><?php echo $column_subject; ?>:</b></td>
								<td><?php echo $subject; ?></td>
							</tr>
							<tr>
								<td colspan="2"><div class="msg_body"><?php echo $body; ?></div></td>
							</tr>
						</table>
					</div>
				</div>

				<div class="row wrap-all">
					<div class="buttons">
						<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
					</div>
				</div>
			</div>

			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>