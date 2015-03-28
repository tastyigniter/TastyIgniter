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
						<?php if ($addresses) { ?>
							<ul class="list-group address-lists">
								<?php foreach ($addresses as $address) { ?>
								<li class="list-group-item address col-sm-4 col-md-4">
									<div class="col-sm-9">
										<?php echo $address['address']; ?>
									</div>
									<div class="col-sm-3">
										<a class="btn btn-primary" href="<?php echo $address['edit']; ?>"><?php echo $text_edit; ?></a>
									</div>
								</li>
								<?php } ?>
							</ul>
						<?php } else { ?>
							<p><?php echo $text_no_address; ?></p>
						<?php } ?>
					</div>

					<div class="col-md-12 page-spacing"></div>

					<div class="col-md-12">
						<div class="row">
							<div class="buttons col-sm-6">
								<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
								<a class="btn btn-success" href="<?php echo $continue; ?>"><?php echo $button_add; ?></a>
							</div>

							<div class="col-sm-6">
								<div class="pagination-bar text-right">
									<div class="links"><?php echo $pagination['links']; ?></div>
									<div class="info"><?php echo $pagination['info']; ?></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo $content_right; ?>
			<?php echo $content_bottom; ?>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#add-address').on('click', function() {
	  	if($('#new-address').is(':visible')) {
	     	$('#new-address').fadeOut();
		}else{
	   		$('#new-address').fadeIn();
		}
	});
});
//--></script>
<?php echo $footer; ?>