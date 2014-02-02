<div class="box">
	<div id="update-box" class="content">
	<h2>UPDATE: <?php echo $first_name; ?> <?php echo $last_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
    		<td><b>First Name:</b></td>
    		<td><input type="text" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Last Name:</b></td>
    		<td><input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><input type="text" name="email" value="<?php echo set_value('email', $email); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Telephone:</b></td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $telephone); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Password:</b></td>
    		<td><input type="password" name="password" value="<?php echo set_value('password'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Confirm Password:</b></td>
    		<td><input type="password" name="confirm_password" value="" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Security Question:</b></td>
    		<td><select name="security_question">
    		<option value=""> please select </option>
    		<?php foreach ($questions as $question) { ?>
    		<?php if ($question['id'] === $security_question) { ?>
    			<option value="<?php echo $question['id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
    		<?php } else { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
    		<?php } ?>
    		<?php } ?>
    		</select></td>
		</tr>
		<tr>
    		<td><b>Security Answer:</b></td>
    		<td><input type="text" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="status">
	   			<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
     		<?php if ($status === '1') { ?>
    			<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</select></td>
		</tr>
	</table>
	
    <?php $address_row = 1; ?>
    <?php foreach ($addresses as $address) { ?>
	<div class="wrap-heading">
		<h3>ADDRESS <?php echo $address_row; ?></h3>
	</div>

	<div class="wrap-content">
    <input type="hidden" name="address[<?php echo $address_row; ?>][address_id]" value="<?php echo set_value('address[<?php echo $address_row; ?>][address_id]', $address['address_id']); ?>" />
	<table class="form">
		<tr>
			<td><b>Address 1:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][address_1]" value="<?php echo set_value('address[<?php echo $address_row; ?>][address_1]', $address['address_1']); ?>" /></td>
		</tr>
		<tr>
			<td><b>Address 2:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][address_2]" value="<?php echo set_value('address[<?php echo $address_row; ?>][address_2]', $address['address_2']); ?>" /></td>
		</tr>
		<tr>
			<td><b>City:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][city]" value="<?php echo set_value('address[<?php echo $address_row; ?>][city]', $address['city']); ?>" /></td>
		</tr>
		<tr>
			<td><b>Postcode:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][postcode]" value="<?php echo set_value('address[<?php echo $address_row; ?>][postcode]', $address['postcode']); ?>" /></td>
		</tr>
		<tr>
			<td><b>Country:</b></td>
			<td><select name="address[<?php echo $address_row; ?>][country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $address['country_id']) { ?>
				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
			</select></td>
		</tr>
	</table>
	</div>
	<?php $address_row++; ?>
    <?php } ?>

	<div class="wrap-heading">
		<h3>ADDRESS <?php echo $address_row; ?></h3>
	</div>

	<div class="wrap-content">
    <input type="hidden" name="address[<?php echo $address_row; ?>][address_id]" value="<?php echo set_value('address[<?php echo $address_row; ?>][address_id]'); ?>" />
	<table class="form">
		<tr>
			<td><b>Address 1:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][address_1]" value="<?php echo set_value('address[<?php echo $address_row; ?>][address_1]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>Address 2:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][address_2]" value="<?php echo set_value('address[<?php echo $address_row; ?>][address_2]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>City:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][city]" value="<?php echo set_value('address[<?php echo $address_row; ?>][city]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>Postcode:</b></td>
			<td><input type="text" name="address[<?php echo $address_row; ?>][postcode]" value="<?php echo set_value('address[<?php echo $address_row; ?>][postcode]'); ?>" /></td>
		</tr>
		<tr>
			<td><b>Country:</b></td>
			<td><select name="address[<?php echo $address_row; ?>][country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $country_id) { ?>
				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
			</select></td>
		</tr>
	</table>
	</div>	
	</form>
	</div>
</div>
