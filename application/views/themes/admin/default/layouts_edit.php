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
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Layout</a></li>
				<li><a rel="#routes">Routes</a></li>
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

		<div id="routes" class="wrap_content" style="display:none;">
			<table align=""class="list sorted_table">
				<thead>
					<tr>
						<th class="action action-one"></th>
						<th>URI Route</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $table_row = 0; ?>
					<?php foreach ($routes as $route) { ?>
					<tr id="table-row<?php echo $table_row; ?>">
						<td class="action action-one"><a onclick="$(this).parent().parent().remove();"><i class="icon icon-delete"></i></a></td>
						<td><input type="text" name="routes[<?php echo $table_row; ?>][uri_route]" value="<?php echo $route['uri_route']; ?>" size="50" /></td>
						<td></td>
					</tr>
					<?php $table_row++; ?>
					<?php } ?>  
				</tbody>
				<tfoot>
					<tr id="tfoot">
						<td class="action action-one"><i class="icon icon-add" onclick="addRoute();"></i></td>
						<td></td>
						<td></td>
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

function addRoute() {	
	html  = '<tr id="table-row' + table_row + '">';
	html += '	<td class="action action-one"><a onclick="$(this).parent().parent().remove();"><i class="icon icon-delete"></i></a></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][uri_route]" value="<?php echo set_value("routes[' + table_row + '][uri_route]"); ?>" size="50" />';
	html += '	<td></td>';
	html += '</tr>';
	
	$('.sorted_table tbody').append(html);
	
	table_row++;
}
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>