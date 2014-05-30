<div class="content">
<div class="img_inner">
	<h3><?php echo $text_reservation_msg; ?></h3>
	<form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="reserve-form">
    <table border="0" cellpadding="2" width="60%" id="personal-details">
  		<tr>
    		<td colspan="2"><?php echo $text_login_register; ?></td>
		</tr>
  		<tr>
    		<td align="right"><label for="first_name"><?php echo $entry_first_name; ?></label></td>
    		<td><input type="text" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" class="textfield" /><br />
    			<?php echo form_error('first_name', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
  		<tr>
    		<td align="right"><label for="last_name"><?php echo $entry_last_name; ?></label></td>
    		<td><input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" class="textfield" /><br />
    			<?php echo form_error('last_name', '<span class="error">', '</span>'); ?>
    		</td>
		</tr>
  		<tr>
    		<td align="right"><label for="email"><?php echo $entry_email; ?></label></td>
    		<td><input type="text" name="email" value="<?php echo set_value('email', $email); ?>" class="textfield" /><br />
    			<?php echo form_error('email', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
  		<tr>
    		<td align="right"><label for="confirm_email"><?php echo $entry_confirm_email; ?></label></td>
    		<td><input type="text" name="confirm_email" value="<?php echo set_value('confirm_email'); ?>" class="textfield" /><br />
    			<?php echo form_error('confirm_email', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
        <tr>
            <td align="right"><label for="telephone"><?php echo $entry_telephone; ?></label></td>
            <td><input type="text" name="telephone" value="<?php echo set_value('telephone', $telephone); ?>" /><br />
    			<?php echo form_error('telephone', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
       	<tr>
            <td align="right"><label for="comment"><?php echo $entry_comments; ?></label></td>
            <td><textarea name="comment" rows="5" cols="40"><?php echo set_value('comment', $comment); ?></textarea><br />
    			<?php echo form_error('comment', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
	</table>
	</form>
</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#check-postcode').on('click', function() {
		$('.check-local').show();
		$('.display-local').hide();
	});	

	$('#date').datepicker({
		dateFormat: 'dd-mm-yy',
	});
});
//--></script>