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
							<p><?php echo $text_empty; ?></p>
						<?php } ?>
					</div>
				</div>

				<div class="row">
					<div class="buttons col-sm-6">
						<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
					</div>

					<div class="col-sm-6">
						<div class="pagination-bar text-right">
							<div class="links"><?php echo $pagination['links']; ?></div>
							<div class="info"><?php echo $pagination['info']; ?></div>
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