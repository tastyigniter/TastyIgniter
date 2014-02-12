<div class="box">
	<div id="update-box" class="content">
	<h2>Currency Details</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
	<table class="form">
	<tr>
		<td><b>Title:</b></td>
    	<td><input type="text" name="currency_title" value="<?php echo set_value('currency_title', $currency_title); ?>" id="name" class="textfield" /></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Code:</b></td>
    	<td><input type="text" name="currency_code" value="<?php echo set_value('currency_code', $currency_code); ?>" id="name" class="textfield" size="5" /></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Symbol:</b></td>
    	<td><input type="text" name="currency_symbol" value="<?php echo set_value('currency_symbol', $currency_symbol); ?>" id="name" class="textfield" size="5" /></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Status:</b></td>
		<td><select name="currency_status">
			<option value="0" <?php echo set_select('currency_status', '0'); ?> >Disabled</option>
		<?php if ($currency_status === '1') { ?>
			<option value="1" <?php echo set_select('currency_status', '1', TRUE); ?> >Enabled</option>
		<?php } else { ?>  
			<option value="1" <?php echo set_select('currency_status', '1'); ?> >Enabled</option>
		<?php } ?>  
		</select></td>
	</tr>
	</table>
	</div>
	
</div>