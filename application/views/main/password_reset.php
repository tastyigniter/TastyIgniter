<div class="content">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
    <table border="0" cellpadding="2" width="" align="center" id="email-check">
		<?php if (empty($customer_email)) { ?>
     	<tr>
        	<td align="right"><b><?php echo $entry_email; ?></b></td>
        	<td><input name="email" type="text" value="<?php echo set_value('email'); ?>" class="textfield" id="email" /><br />
    			<?php echo form_error('email', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
  		<tr>
    		<td align="right"><label for="security_question"><?php echo $entry_s_question; ?></label></td>
	<?php echo form_open('main/password_reset') ?>
    <table border="0" cellpadding="2" width="" align="center" id="email-check">
     	<tr>
        	<td align="right"><b>Email:</b></td>
        	<td><input name="email" type="text" value="<?php echo set_value('email'); ?>" class="textfield" id="email" /></td>
    	</tr>
     	<tr>
            <td align="right"><b>Your Security Question:</b></td>
    		<td><select name="security_question">
    		<?php foreach ($questions as $question) { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
    		<?php } ?>
    		</select><br />
    		<?php echo form_error('security_question', '<span class="error">', '</span>'); ?></td>
	 	</tr>
     	<tr>
    		<td align="right"><label for="security_answer"><?php echo $entry_s_answer; ?></label></td>
        	<td><input type="text" name="security_answer" class="textfield" id="security-answer" /><br />
    			<?php echo form_error('security_answer', '<span class="error">', '</span>'); ?>
    		</td>
     	</tr>
	    <tr>
        	<td align="left"></td>
        	<td align="right"><input type="submit" name="submit" value="<?php echo $button_reset_password; ?>" /></td>
    	</tr>
		<?php } ?>
    </table>
	</form>
</div>
    		</select></td>
     	</tr>
     	<tr>
            <td align="right"><b>Your Security Answer:</b></td>
        	<td><input type="text" name="security_answer" class="textfield" id="security-answer" /></td>
     	</tr>
     	<tr>
            <td align="right"><b>New Password:</b></td>
        	<td><input type="password" name="new_password" class="textfield" id="new-password" /></td>
     	</tr>
     	<tr>
            <td align="right"><b>Confirm New Password:</b></td>
        	<td><input type="password" name="confirm_new_password" class="textfield" id="confirm-new-password" /></td>
     	</tr>
	    <tr>
        	<td colspan="2" align="right"><input type="submit" name="submit" value="Reset Password" /></td>
    	</tr>
    </table>
	</form>
</div>
