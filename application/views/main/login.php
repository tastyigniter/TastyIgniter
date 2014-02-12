<div class="content">
<!--<h2><?php echo $text_login_register; ?></h2>
    <h3><?php echo $text_login; ?></h3>	-->

<div class="wrap left">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
    <table border="0" cellpadding="2" width="400px" align="center">
        <tr>
            <td align="right"><b><?php echo $entry_email; ?></b></td>
            <td><input name="email" type="text" class="textfield" id="email" /><br />
    			<?php echo form_error('email', '<span class="error">', '</span>'); ?>
    		</td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_password; ?></b></td>
            <td><input name="password" type="password" class="textfield" id="password" /><br />
    			<?php echo form_error('password', '<span class="error">', '</span>'); ?>
    		</td>
        </tr>
        <tr>
            <td align="right"></td>
            <td><a href="<?php echo site_url('account/password/reset'); ?>"><?php echo $text_forgot; ?></a></td>
        </tr>
        <tr>
        	<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $button_login; ?>" /></td>
        </tr>
    </table>
    </form>
</div>

<div id="register" class="wrap right">
</div>


</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#register').load('<?php echo site_url("account/register"); ?> .wrap > *');
});
//--></script> 