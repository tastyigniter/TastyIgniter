<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD NEW LAYOUT</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table align=""class="form">
		<tr>
			<td><b>Name:</b></td>
			<td><input type="text" name="name" value="<?php echo set_value('name'); ?>" class="textfield" /></td>
		</tr>
	</table>
	<br /><br /><br />

	<div class="wrap-heading">
		<h3>ROUTES</h3>
	</div>

	<div class="wrap-content">
	<table align=""class="list">
		<tr>
			<th><b>URI Route</b></th>
			<th><b>Action</b></th>
		</tr>
		<?php $table_row = 0; ?>
		<tr id="tfoot">
			<td colspan="1"></td>
			<td class="left"><img src="<?php echo base_url('assets/img/add.png'); ?>" onclick="addRoute();" /></td>
		</tr>		 
	</table>
	</div>
	</form>
	</div>
	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table border="0" align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Layout</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($layouts) { ?>
		<?php foreach ($layouts as $layout) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $layout['layout_id']; ?>" name="delete[]" /></td>
			<td><?php echo $layout['name']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $layout['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="3" align="center"><?php echo $text_no_layouts; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRoute() {	
	html  = '<tr id="table-row' + table_row + '">';
	html += '<td><select name="routes[' + table_row + '][uri_route_id]">';
	html += '<option value="">- please select -</option>';
	<?php foreach ($uri_routes as $uri_route) { ?>
		html += '<option value="<?php echo $uri_route['uri_route_id']; ?>" <?php echo set_select("routes[' + table_row + '][uri_route_id]", $uri_route['uri_route_id']); ?> ><?php echo $uri_route['route']; ?></option>';
	<?php } ?>
	html += '</select></td>';
	html += '	<td class="left"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
	table_row++;
}
//--></script> 