<div class="content">
<h2><?php echo $text_login_register; ?></h2>
<div class="wrap">
    <h3><?php echo $text_register; ?></h3>	
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
	<table cellpadding="2" border="0" width="400px" align="center">
    	<tr>
        	<td colspan="2" align="center"><font size="1" color="red"><?php echo $text_required; ?></font></td>
        </tr>
  		<tr>
    		<td align="right"><label for="first_name"><?php echo $entry_first_name; ?></label></td>
    		<td><input type="text" value="<?php echo set_value('first_name'); ?>" class="textfield" name="first_name"><br />
    			<?php echo form_error('first_name', '<span class="error">', '</span>'); ?></td>
		</tr>
	  	<tr>
    		<td align="right"><label for="last_name"><?php echo $entry_last_name; ?></label></td>
    		<td><input type="text" value="<?php echo set_value('last_name'); ?>" class="textfield" name="last_name"><br />
    			<?php echo form_error('last_name', '<span class="error">', '</span>'); ?></td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="email"><?php echo $entry_email; ?></label></td>
    		<td><input type="text" value="<?php echo set_value('email'); ?>" class="textfield" name="email"><br />
    			<?php echo form_error('email', '<span class="error">', '</span>'); ?></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="password"><?php echo $entry_password; ?></label></td>
    		<td><input type="password" value="" class="textfield" name="password"><br />
    			<?php echo form_error('password', '<span class="error">', '</span>'); ?></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="password_confirm"><?php echo $entry_password_confirm; ?></label></td>
    		<td><input type="password" class="textfield" name="password_confirm" value=""><br />
    			<?php echo form_error('password_confirm', '<span class="error">', '</span>'); ?></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="telephone"><?php echo $entry_telephone; ?></label></td>
    		<td><input type="text" value="<?php echo set_value('telephone'); ?>" class="textfield" name="telephone"><br />
    			<?php echo form_error('telephone', '<span class="error">', '</span>'); ?></td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="security_question"><?php echo $entry_s_question; ?></label></td>
    		<td><select name="security_question">
    		<?php foreach ($questions as $question) { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
    		<?php } ?>
    		</select><br />
    		<?php echo form_error('security_question', '<span class="error">', '</span>'); ?></td>
	 	</tr>
  		<tr>
    		<td align="right"><label for="security_answer"><?php echo $entry_s_answer; ?></label></td>
    		<td><input type="text" class="textfield" name="security_answer"><br />
    			<?php echo form_error('security_answer', '<span class="error">', '</span>'); ?></td>
	 	</tr>
        <tr>
        	<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $button_register; ?>" /></td>
        </tr>
	</table>
	</form>
</div>
</div>