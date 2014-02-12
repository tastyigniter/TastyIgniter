<div class="box">
	<div id="update-box" class="content">
	<h2>Department Details</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
	<table class="form">
	<tr>
		<td><b>Name:</b></td>
    	<td><input type="text" name="department_name" value="<?php echo set_value('department_name', $department_name); ?>" id="department_name" class="textfield" /></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Access Permission:</b></td>
    	<td><div class="selectbox">
    	<table class="permission">
		<?php foreach ($paths as $key => $value) { ?>
		<?php if (in_array($value, $access)) { ?>
		<tr>
    		<td width="1"><input type="checkbox" name="permission[access][]" value="<?php echo $value; ?>" checked="checked" /></td>
    		<td><label for=""><?php echo $value; ?></label></td>
    	</tr>
		<?php } else { ?>
		<tr>
    		<td width="1"><input type="checkbox" name="permission[access][]" value="<?php echo $value; ?>" /></td>
    		<td><label for=""><?php echo $value; ?></label></td>
    	</tr>
		<?php } ?>
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
			<?php if (in_array($value, $modify)) { ?>
			<tr>
				<td width="1"><input type="checkbox" name="permission[modify][]" value="<?php echo $value; ?>" checked="checked" /></td>
				<td><label for=""><?php echo $value; ?></label></td>
			</tr>
			<?php } else { ?>
			<tr>
				<td width="1"><input type="checkbox" name="permission[modify][]" value="<?php echo $value; ?>" /></td>
				<td><label for=""><?php echo $value; ?></label></td>
			</tr>
			<?php } ?>
			<?php } ?>
		</table></div>
		<a onclick="$(this).parent().find(':checkbox').attr('checked', true);">Select All</a>&nbsp;&nbsp;/&nbsp;&nbsp;
		<a onclick="$(this).parent().find(':checkbox').attr('checked', false);">Unselect All</a>		
		</td>
		<td></td>
    </tr>
	</table>
	</div>
	
</div>