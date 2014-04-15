<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
	<table align=""class="form">
		<tr>
			<td><b>Name:</b></td>
			<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
		</tr>
	</table>
	<br /><br /><br />

	<div class="wrap-heading">
		<h2>Pages</h2>
	</div>

	<div class="wrap_content">
	<table align=""class="list">
		<tr>
			<th><b>URI Route</b></th>
			<th class="right"><b>Action</b></th>
		</tr>
		<?php $table_row = 0; ?>
		<?php foreach ($routes as $route) { ?>
		<tr id="table-row<?php echo $table_row; ?>">
			<td><select name="routes[<?php echo $table_row; ?>][uri_route]">
				<option value="">- please select -</option>
			<?php foreach ($uri_routes as $uri_route) { ?>
			<?php if ($uri_route['uri_route'] === $route['uri_route']) { ?>
				<option value="<?php echo $uri_route['uri_route']; ?>" selected="selected"><?php echo $uri_route['uri_route']; ?></option>
			<?php } else { ?>
				<option value="<?php echo $uri_route['uri_route']; ?>"><?php echo $uri_route['uri_route']; ?></option>
			<?php } ?>
			<?php } ?>
			</select></td>
			<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>
		</tr>
		<?php $table_row++; ?>
		<?php } ?>  
		<tr id="tfoot">
			<td colspan="1"></td>
			<td class="right"><img src="<?php echo base_url('assets/img/add32x32.png'); ?>" onclick="addRoute();" /></td>
		</tr>		 
	</table>
	</div>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRoute() {	
	html  = '<tr id="table-row' + table_row + '">';
	html += '	<td><select name="routes[' + table_row + '][uri_route]">';
	html += '		<option value="">- please select -</option>';
	<?php foreach ($uri_routes as $uri_route) { ?>
		html += '	<option value="<?php echo $uri_route['uri_route']; ?>"><?php echo $uri_route['uri_route']; ?></option>';
	<?php } ?>
	html += '	</select></td>';
	html += '	<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
	table_row++;
}
//--></script> 