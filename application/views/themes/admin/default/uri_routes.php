<div class="box">
	<p>Typically there is a one-to-one relationship between a URI Route and its corresponding controller class/method.<br />
	You can match literal values or you can use two wildcard types:<br />
	<b>(:num)</b> will match a segment containing only numbers.<br />
	<b>(:any)</b> will match a segment containing any character.</p>
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table class="list sorted_table">
		<thead> 
			<tr>
				<th class="action"></th>
				<th class="action action-one"></th>
				<th>URI Route</th>
				<th>Controller</th>
			</tr>
		</thead> 
		<tbody> 
			<?php $table_row = 0; ?>
			<?php foreach ($routes as $route) { ?>
			<tr id="table-row<?php echo $table_row; ?>">
				<td class="action"><i class="handle"></i></td>
				<td class="action action-one"><i onclick="$(this).parent().parent().remove();" class="icon icon-delete"></i></td>
				<td><input type="text" name="routes[<?php echo $table_row; ?>][uri_route]" value="<?php echo set_value('routes[$table_row][uri_route]', $route['uri_route']); ?>" size="50" /></td>
				<td><input type="text" name="routes[<?php echo $table_row; ?>][controller]" value="<?php echo set_value('routes[$table_row][controller]', $route['controller']); ?>" size="50" /></td>
			</tr>
			<?php $table_row++; ?>
			<?php } ?>  
		</tbody> 
		<tfoot> 
			<tr id="tfoot">
				<td></td>
				<td class="action action-one"><i class="icon icon-add" onclick="addRoute();"></i></td>
				<td colspan="2"></td>
			</tr>		
		</tfoot> 
	</table>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRoute() {	
	html  = '<tr id="table-row' + table_row + '">';
    html += '	<td><i class="handle"></i>';
	html += '	<td class="action action-one"><i onclick="$(this).parent().parent().remove();" class="icon icon-delete"></i></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][uri_route]" value="<?php echo set_value("routes[' + table_row + '][uri_route]"); ?>" size="50" /></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][controller]" value="<?php echo set_value("routes[' + table_row + '][controller]"); ?>" size="50" /></td>';
	html += '</tr>';
	
	$('.sorted_table tbody').append(html);
	
	table_row++;
}
//--></script> 
<script src="<?php echo base_url("assets/js/jquery-sortable.js"); ?>"></script>
<script type="text/javascript"><!--
$(function  () {
	$('.sorted_table').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="4"></td></tr>',
		handle: '.handle'
	})
})
//--></script> 
