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
						<?php if ($messages) {?>
							<div class="list-group">
								<?php foreach ($messages as $message) { ?>
									<a href="<?php echo $message['view']; ?>" class="list-group-item <?php echo $message['state']; ?>">
										<div class="row">
											<div class="col-sm-9 col-md-9">
												<span class=""><?php echo $message['subject']; ?></span>
												<span class="text-muted small" style="font-size: 11px;">- <?php echo $message['body']; ?></span>
											</div>
											<div class="col-sm-3 col-md-3 text-right">
												<span class="badge"><?php echo $message['date_added']; ?></span>
											</div>
										</div>
									</a>
								<?php } ?>
							</div>
						<?php } else { ?>
							<p><?php echo lang('text_empty'); ?></p>
						<?php } ?>
					</div>
				</div>

				<div class="row">
					<div class="buttons col-sm-6">
						<a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
					</div>

					<div class="col-sm-6">
						<div class="pagination-bar text-right">
							<div class="links"><?php echo $pagination['links']; ?></div>
							<div class="info"><?php echo $pagination['info']; ?></div>
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