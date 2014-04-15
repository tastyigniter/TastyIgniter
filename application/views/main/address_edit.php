<div class="content">
<div class="img_inner">
	<h3><?php echo $text_heading; ?></h3>
</div>  
<div class="img_inner">
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
	<?php if ($address) { ?>
  		<table width="50%" class="form">
	    <tr>
            <td align="right"><b><?php echo $entry_address_1; ?></b></td>
            <td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]', $address['address_1']); ?>" /><br />
    			<?php echo form_error('address[address_1]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_address_2; ?></b></td>
            <td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]', $address['address_2']); ?>" /><br />
    			<?php echo form_error('address[address_2]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_city; ?></b></td>
            <td><input type="text" name="address[city]" value="<?php echo set_value('address[city]', $address['city']); ?>" /><br />
    			<?php echo form_error('address[city]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_postcode; ?></b></td>
            <td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]', $address['postcode']); ?>" /><br />
    			<?php echo form_error('address[postcode]', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
		<tr>
			<td align="right"><b><?php echo $entry_country; ?></b></td>
			<td><select name="address[country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $address['country_id']) { ?>
				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
			</select><br />
    			<?php echo form_error('address[country]', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
 		</table>
	<?php } else { ?>

		<div id="new-address">
			<table border="0" cellpadding="2" width="50%" class="form">	
			<tr>
				<td align="right"><b><?php echo $entry_address_1; ?></b></td>
				<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]'); ?>" /><br />
					<?php echo form_error('address[address_1]', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			<tr>
				<td align="right"><b><?php echo $entry_address_2; ?></b></td>
				<td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]'); ?>" /><br />
					<?php echo form_error('address[address_2]', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			<tr>
				<td align="right"><b><?php echo $entry_city; ?></b></td>
				<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]'); ?>" /><br />
					<?php echo form_error('address[city]', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			<tr>
				<td align="right"><b><?php echo $entry_postcode; ?></b></td>
				<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" /><br />
					<?php echo form_error('address[postcode]', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			<tr>
				<td align="right"><b><?php echo $entry_country; ?></b></td>
				<td><select name="address[country]">
				<?php foreach ($countries as $country) { ?>
				<?php if ($country['country_id'] === $country_id) { ?>
					<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
				<?php } else { ?>  
					<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
				<?php } ?>  
				<?php } ?>  
				</select><br />
					<?php echo form_error('address[country]', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			</table>
	<?php } ?>
	</div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_address; ?></a></div>
		<div class="right"><input type="submit" name="submit" value="<?php echo $button_update; ?>" /></div>
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
