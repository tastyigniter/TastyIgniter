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
					<div class="table-responsive">
						<table class="table table-none">
							<tr>
								<td width="20%"><b><?php echo lang('column_date'); ?>:</b></td>
								<td><?php echo $date_added; ?></td>
							</tr>
							<tr>
								<td><b><?php echo lang('column_subject'); ?>:</b></td>
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
						<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
						<a class="btn btn-danger"
						   href="<?php echo $delete_url; ?>"><?php echo lang('button_delete'); ?></a>
					</div>
				</div>
			</div>

			<?php echo get_partial('content_right'); ?>
			<?php echo get_partial('content_bottom'); ?>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>