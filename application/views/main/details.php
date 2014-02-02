<div class="content">
	<div class="wrap">
  	<h2><?php echo $text_details; ?></h2>
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
  	<table class="form">
  		<tr>
    		<td align="right"><label for="first_name"><b><?php echo $entry_first_name; ?></b></label></td>
    		<td><input type="text" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" /><br />
    			<?php echo form_error('first_name', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
  		<tr>
    		<td align="right"><label for="last_name"><b><?php echo $entry_last_name; ?></b></label></td>
    		<td><input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" /><br />
    			<?php echo form_error('last_name', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
  		<tr>
    		<td align="right"><label for="email"><b><?php echo $entry_email; ?></b></label></td>
    		<td><input type="text" name="email" value="<?php echo $email; ?>" /></td>
  		</tr>
  		<tr>
    		<td align="right"><label for="telephone"><b><?php echo $entry_telephone; ?></b></label></td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $telephone); ?>" /><br />
    			<?php echo form_error('telephone', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
   		<tr>
    		<td align="right"><label for="security_question"><b><?php echo $entry_s_question; ?></b></label></td>
    		<td><select name="security_question">
    		<option value=""><?php echo $text_select; ?></option>
    		<?php foreach ($questions as $question) { ?>
    		<?php if ($question['id'] === $security_question) { ?>
    			<option value="<?php echo $question['id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
    		<?php } else { ?>
    			<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
    		<?php } ?>
    		<?php } ?>
    		</select><br />
    			<?php echo form_error('security_question', '<span class="error">', '</span>'); ?>
    		</td>
	 	</tr>
 		<tr>
    		<td align="right"><label for="security_answer"><b><?php echo $entry_s_answer; ?></b></label></td>
    		<td><input type="text" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" /><br />
    			<?php echo form_error('security_answer', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
  	</table>
  	</div>

	<div class="wrap">
	<h3><?php echo $text_password; ?></h3>
  	<table class="form">
  		<tr>
    		<td align="right"><label for="old_password"><b><?php echo $entry_old_password; ?></b></label></td>
    		<td><input type="password" name="old_password" value="" /><br />
    			<?php echo form_error('old_password', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
  		<tr>
    		<td align="right"><label for="new_password"><b><?php echo $entry_password; ?></b></label></td>
    		<td><input type="password" name="new_password" value="" /><br />
    			<?php echo form_error('new_password', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
  		<tr>
    		<td align="right"><label for="confirm_new_password"><b><?php echo $entry_password_confirm; ?></b></label></td>
    		<td><input type="password" name="confirm_new_password" value="" /><br />
    			<?php echo form_error('confirm_new_password', '<span class="error">', '</span>'); ?>
    		</td>
  		</tr>
  		<tr>
			<td colspan="2" align="center"></td>
		</tr>
  	</table>
  	</div>

	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
		<div class="right"><input type="submit" name="submit" value="<?php echo $button_save; ?>" /></div>
	</div>
	</form>
</div>