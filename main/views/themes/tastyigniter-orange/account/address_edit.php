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
					<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>" role="form">
						<?php if ($address) { ?>
							<div class="col-md-12">
								<div class="form-group">
									<label for=""><?php echo $entry_address_1; ?></label>
									<input type="text" name="address[address_1]" class="form-control" value="<?php echo set_value('address[address_1]', $address['address_1']); ?>" />
									<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="form-group">
									<label for=""><?php echo $entry_address_2; ?></label>
									<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]', $address['address_2']); ?>" />
									<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6">
										<div class="form-group">
                                            <label for=""><?php echo $entry_city; ?></label>
                                            <input type="text" class="form-control" value="<?php echo set_value('address[city]', $address['city']); ?>" name="address[city]" placeholder="<?php echo $entry_city; ?>">
											<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6">
										<div class="form-group">
                                            <label for=""><?php echo $entry_postcode; ?></label>
											<input type="text" class="form-control" name="address[postcode]" value="<?php echo set_value('address[postcode]', $address['postcode']); ?>" placeholder="<?php echo $entry_postcode; ?>">
											<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for=""><?php echo $entry_country; ?></label>
									<select name="address[country]" class="form-control">
									<?php foreach ($countries as $country) { ?>
									<?php if ($country['country_id'] === $address['country_id']) { ?>
										<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
									<?php } ?>
									<?php } ?>
									</select>
									<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>

						<?php } else { ?>

							<div id="new-address" class="col-md-12">
								<div class="form-group">
									<label for=""><?php echo $entry_address_1; ?></label>
									<input type="text" name="address[address_1]" class="form-control" value="<?php echo set_value('address[address_1]'); ?>" />
									<?php echo form_error('address[address_1]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="form-group">
									<label for=""><?php echo $entry_address_2; ?></label>
									<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]'); ?>" />
									<?php echo form_error('address[address_2]', '<span class="text-danger">', '</span>'); ?>
								</div>

								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" value="<?php echo set_value('address[city]'); ?>" name="address[city]" placeholder="<?php echo $entry_city; ?>">
											<?php echo form_error('address[city]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-6">
										<div class="form-group">
											<input type="text" class="form-control" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" placeholder="<?php echo $entry_postcode; ?>">
											<?php echo form_error('address[postcode]', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for=""><?php echo $entry_country; ?></label>
									<select name="address[country]" class="form-control">
									<?php foreach ($countries as $country) { ?>
									<?php if ($country['country_id'] === $country_id) { ?>
										<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
									<?php } ?>
									<?php } ?>
									</select>
									<?php echo form_error('address[country]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
						<?php } ?>
						<div class="col-md-12">
							<div class="buttons">
								<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
								<button type="submit" class="btn btn-success"><?php echo $button_update; ?></button>
							</div>
						</div>
					</form>
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

  	$('#add-address').on('click', function() {

  	if($('#new-address').is(':visible')){
     	$('#new-address').fadeOut();
	}else{
   		$('#new-address').fadeIn();
	}
	});



});
//--></script>
<?php echo get_footer(); ?>