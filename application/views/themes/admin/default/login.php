<div class="box login-box">
	<h3 align="center"><center>Please enter your login details.</center></h3>
	<?php echo form_open(current_url()) ?>
	<table width="300" border="0" align="center" cellpadding="2" cellspacing="0">
		<tbody>
			<tr>
				<td width="112">Username</td>
				<td width="188"><input name="user" type="text" class="textfield" id="user" /></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input name="password" type="password" class="textfield" id="password" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="Submit" value="Login" /></td>
			</tr>
		</tbody>
	</table>
	</form>
</div>