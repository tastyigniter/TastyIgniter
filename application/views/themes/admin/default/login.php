<div id="box-content" class="login-box">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
		<h2><center>Please enter your login details.</center></h2>
		<form accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
		<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
			<tbody>
				<tr>
					<td width="112">Username<br /><br /></td>
					<td width="188"><input name="user" type="text" class="textfield" id="user" /><br /><br /></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input name="password" type="password" class="textfield" id="password" /></td>
				</tr>
				<tr>
					<td><br />&nbsp;</td>
					<td><br /><input type="submit" name="Submit" value="Login" /></td>
				</tr>
			</tbody>
		</table>
		</form>
	</div>
</div>