<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW MENU OPTION</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>Name:</b></td>
			<td><input type="text" name="option_name" value="<?php echo set_value('option_name'); ?>" id="option-name" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Price:</b></td>
			<td><input type="text" name="option_price" value="<?php echo set_value('option_price'); ?>" size="5" id="option-price" class="textfield" /></td>
		</tr>
	</table>
	</form>
	</div>
	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th>Price</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($menu_options) {?>
		<?php foreach ($menu_options as $menu_option) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo $menu_option['option_id']; ?>" name="delete[]" /></td>
			<td><?php echo $menu_option['option_name']; ?></td>
			<td><?php echo $menu_option['option_price']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $menu_option['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="7"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>

	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
</div>
