<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a class="active" rel="#general">General</a></li>
				<li><a rel="#layouts">Layouts</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table align=""class="form">
				<tbody> 
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
					</tr>
				</tbody> 
			</table>
		</div>

		<div id="layouts" class="wrap_content" style="display:none;">
			<table align=""class="list sorted_table">
				<thead> 
					<tr>
						<th class="action action-one"></th>
						<th>Layout</th>
						<th>Position</th>
						<th>Priority</th>
						<th>Status</th>
					</tr>
				</thead> 
				<tbody> 
					<?php $table_row = 0; ?>
					<?php foreach ($modules as $module) { ?>
					<tr id="module-row<?php echo $table_row; ?>">
						<td class="action action-one"><a onclick="$(this).parent().parent().remove();"><i class="icon icon-delete"></i></a></td>
						<td><select name="modules[<?php echo $table_row; ?>][layout_id]">
						<?php foreach ($layouts as $layout) { ?>
						<?php if ($layout['layout_id'] === $module['layout_id']) { ?>
							<option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
						<td><select name="modules[<?php echo $table_row; ?>][position]">
							<?php if ($module['position'] === 'right') { ?>
								<option value="right" selected="selected">Right</option>
								<option value="left">Left</option>
							<?php } else if ($module['position'] === 'left') { ?>  
								<option value="right">Right</option>
								<option value="left" selected="selected">Left</option>
							<?php } else { ?>  
								<option value="right">Right</option>
								<option value="left">Left</option>
							<?php } ?>  
						</select></td>
						<td><input type="text" name="modules[<?php echo $table_row; ?>][priority]" value="<?php echo $module['priority']; ?>" size="5" /></td>
						<td><select name="modules[<?php echo $table_row; ?>][status]">
							<option value="0" >Disabled</option>
						<?php if ($module['status'] === '1') { ?>
							<option value="1" selected="selected">Enabled</option>
						<?php } else { ?>  
							<option value="1" >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
					<?php $table_row++; ?>
					<?php } ?>  
				</tbody> 
				<tfoot> 
					<tr id="tfoot">
						<td class="action action-one"><i class="icon icon-add" onclick="addModule();"></i></td>
						<td colspan="4"></td>
					</tr>		 
				</tfoot> 
			</table>
		</div>

	</form>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addModule() {	
	html  = '<tr id="module-row' + table_row + '">';
	html += '	<td class="action action-one"><a onclick="$(this).parent().parent().remove();"><i class="icon icon-delete"></i></a></td>';
    html += '	<td><select name="modules[' + table_row + '][layout_id]">';
		<?php foreach ($layouts as $layout) { ?>
			html += '	<option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>';
		<?php } ?>  
    html += '	</select></td>';
    html += '	<td><select name="modules[' + table_row + '][position]">';    
		html += '	<option value="right">Right</option>';
		html += '	<option value="left">Left</option>';
		html += '	<option value="top">Top</option>';
    html += '	</select></td>';    
	html += '	<td><input type="text" name="modules[' + table_row + '][priority]" value="" size="5" /></td>';
	html += '   <td><select name="modules[' + table_row + '][status]">';
    html += '      <option value="1">Enabled</option>';
    html += '      <option value="0">Disabled</option>';
    html += '   </select></td>';
	html += '</tr>';
	
	$('.sorted_table tbody').append(html);
	
	table_row++;
}

$('#tabs a').tabs();

//--></script> 