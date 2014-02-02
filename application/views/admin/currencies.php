<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW CURRENCY</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form" width="">
		<tr>
			<td><b>Title:</b></td>
			<td><input type="text" name="currency_title" value="<?php echo set_value('currency_title'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Code:</b></td>
			<td><input type="text" name="currency_code" value="<?php echo set_value('currency_code'); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
			<td><b>Symbol:</b></td>
			<td><input type="text" name="currency_symbol" value="<?php echo set_value('currency_symbol'); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
			<td><b>Status:</b></td>
			<td><select name="currency_status">
				<option value="1" <?php echo set_select('currency_status', '1', TRUE); ?> >Enabled</option>
				<option value="0" <?php echo set_select('currency_status', '0'); ?> >Disabled</option>
			</select></td>
		</tr>
  	</table>
	</form>
	</div>
	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Title</th>
			<th>Code</th>
			<th>Symbol</th>
			<th>Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($currencies) {?>
		<?php foreach ($currencies as $currency) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $currency['currency_id']; ?>" name="delete[]" /></td>
			<td><?php echo $currency['currency_title']; ?></td>
			<td><?php echo $currency['currency_code']; ?></td>
			<td><?php echo $currency['currency_symbol']; ?></td>
			<td><?php echo ($currency['currency_status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $currency['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="6"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>
