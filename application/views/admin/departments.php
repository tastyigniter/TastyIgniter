<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW STAFF DEPARTMENT</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>Name:</b></td>
			<td><input type="text" name="department_name" value="<?php echo set_value('department_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Access Permission:</b></td>
			<td><div class="selectbox">
			<table class="permission">
			<?php foreach ($paths as $key => $value) { ?>
			<tr>
				<td width="1"><input type="checkbox" name="permission[access][]" value="<?php echo $value; ?>" <?php echo set_checkbox('permission[access][]', $value); ?> /></td>
				<td><label for=""><?php echo $value; ?></label></td>
			</tr>
			<?php } ?>
			</table></div>
			<a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select All</a>&nbsp;&nbsp;/&nbsp;&nbsp;
			<a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect All</a>		
			</td>
			<td></td>
		</tr>
		<tr>
			<td><b>Modify Permission:</b></td>
			<td><div class="selectbox">
			<table class="permission">
				<?php foreach ($paths as $key => $value) { ?>
				<tr>
					<td width="1"><input type="checkbox" name="permission[modify][]" value="<?php echo $value; ?>" <?php echo set_checkbox('permission[modify][]', $value); ?> /></td>
					<td><label for=""><?php echo $value; ?></label></td>
				</tr>
				<?php } ?>
			</table></div>
			<a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select All</a>&nbsp;&nbsp;/&nbsp;&nbsp;
			<a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect All</a>		
			</td>
			<td></td>
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
			<th class="right">Action</th>
		</tr>
		<?php if ($departments) {?>
		<?php foreach ($departments as $department) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $department['department_id']; ?>" name="delete[]" /></td>
			<td><?php echo $department['department_name']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $department['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else {?>
		<tr>
			<td colspan="4" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>