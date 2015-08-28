<div id="newsletter-box" class="module-box">
	<div class="newsletter-subscribe">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="subscribe-form col-sm-8 center-block">
						<div id="newsletter-alert" class="col-md-12" style="display: <?php echo ($newsletter_alert) ? 'block' : 'none'; ?>">
							<div class="newsletter-alert">
								<?php echo $newsletter_alert; ?>
							</div>
						</div>

						<span><?php echo lang('text_subscribe'); ?></span>
						<form class="subscribeForm" method="POST">
							<div class="input-group subscribe-group">
								<input type="text" id="subscribe-email" class="form-control" name="subscribe_email">
								<button type="submit" id="submitButton" class="input-group-addon"><i class="fa fa-paper-plane-o"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>