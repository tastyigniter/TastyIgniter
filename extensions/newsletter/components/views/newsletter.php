<div id="newsletter-box" class="module-box">
	<div class="newsletter-subscribe">
		<div class="container">
			<div class="row">
                <div id="newsletter-alert" class="col-md-12" style="display: <?php echo ($newsletter_alert) ? 'block' : 'none'; ?>">
                    <div class="newsletter-alert">
                        <?php echo $newsletter_alert; ?>
                    </div>
                </div>

                <div class="col-md-12">
					<div class="subscribe-form col-sm-8 center-block">
						<h3><?php echo lang('text_subscribe'); ?></h3>
						<form class="subscribeForm" method="POST" action="<?php echo $subscribe_url; ?>">
							<div class="input-group subscribe-group">
								<input type="text" id="subscribe-email" class="form-control" name="subscribe_email">
                                <a id="subscribeButton" class="input-group-addon btn btn-default" onclick="subscribeEmail()"><i class="fa fa-paper-plane-o"></i></a>
                            </div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	function subscribeEmail() {
		var subscribe_email = $('input[name=\'subscribe_email\']').val();

		$.ajax({
			url: js_site_url('newsletter/newsletter/subscribe'),
			type: 'POST',
			data: 'subscribe_email=' + subscribe_email,
			dataType: 'json',
			success: function(json) {
				var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
				var newsletter_alert = $('#newsletter-alert .newsletter-alert');
				var alert_message = '';

				if (json['redirect']) {
					window.location.href = json['redirect'];
				}

				if (json['error']) {
					alert_message = '<div class="alert alert-danger">' + alert_close + json['error'] + '</div>';
				}

				if (json['success']) {
					alert_message = '<div class="alert alert-success">' + alert_close + json['success'] + '</div>';
                    $('input[name=\'subscribe_email\']').val('');
				}

				newsletter_alert.empty();
				newsletter_alert.append(alert_message);
				$('#newsletter-alert').fadeIn('slow').fadeTo('fast', 0.5).fadeTo('fast', 1.0);
			}
		});
	}
//--></script>
