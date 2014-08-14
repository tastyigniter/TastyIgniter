<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>

<div id="notification" class="row">
<?php if (!empty($alert)) { ?>
	<div class="alert alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $alert; ?>
	</div>
<?php } ?>
</div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-8 page-content">
		<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>" role="form">
		<?php if ($address) { ?>
			<div class="row wrap-all">
				<div class="form-group">
					<label for=""><?php echo $entry_address_1; ?></label>
					<input type="text" name="address[address_1]" class="form-control" value="<?php echo set_value('address[address_1]', $address['address_1']); ?>" />
					<?php echo form_error('address[address_1]', '<span class="error help-block">', '</span>'); ?>
				</div>
				
				<div class="form-group">
					<label for=""><?php echo $entry_address_2; ?></label>
					<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]', $address['address_2']); ?>" />
					<?php echo form_error('address[address_2]', '<span class="error help-block">', '</span>'); ?>
				</div>
				
				<div class="form-group">
					<label for=""><?php echo $entry_city; ?></label>
					<input type="text" name="address[city]" class="form-control" value="<?php echo set_value('address[city]', $address['city']); ?>" />
					<?php echo form_error('address[city]', '<span class="error help-block">', '</span>'); ?>
				</div>
				
				<div class="form-group">
					<label for=""><?php echo $entry_postcode; ?></label>
					<input type="text" name="address[postcode]" class="form-control" value="<?php echo set_value('address[postcode]', $address['postcode']); ?>" />
					<?php echo form_error('address[postcode]', '<span class="error help-block">', '</span>'); ?>
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
					<?php echo form_error('address[country]', '<span class="error help-block">', '</span>'); ?>
				</div>
			</div>

		<?php } else { ?>

			<div id="new-address" class="row wrap-all">
				<div class="form-group">
					<label for=""><?php echo $entry_address_1; ?></label>
					<input type="text" name="address[address_1]" class="form-control" value="<?php echo set_value('address[address_1]'); ?>" />
					<?php echo form_error('address[address_1]', '<span class="error help-block">', '</span>'); ?>
				</div>
					
				<div class="form-group">
					<label for=""><?php echo $entry_address_2; ?></label>
					<input type="text" name="address[address_2]" class="form-control" value="<?php echo set_value('address[address_2]'); ?>" />
					<?php echo form_error('address[address_2]', '<span class="error help-block">', '</span>'); ?>
				</div>
					
				<div class="form-group">
					<label for=""><?php echo $entry_city; ?></label>
					<input type="text" name="address[city]" class="form-control" value="<?php echo set_value('address[city]'); ?>" />
					<?php echo form_error('address[city]', '<span class="error help-block">', '</span>'); ?>
				</div>
					
				<div class="form-group">
					<label for=""><?php echo $entry_postcode; ?></label>
					<input type="text" name="address[postcode]" class="form-control" value="<?php echo set_value('address[postcode]'); ?>" />
					<?php echo form_error('address[postcode]', '<span class="error help-block">', '</span>'); ?>
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
					<?php echo form_error('address[country]', '<span class="error help-block">', '</span>'); ?>
				</div>
			</div>
		<?php } ?>
			<div class="row wrap-all">
				<div class="buttons">
					<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
					<button type="submit" class="btn btn-success"><?php echo $button_update; ?></button>
				</div>
			</div>
		</form>
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
<?php echo $footer; ?>