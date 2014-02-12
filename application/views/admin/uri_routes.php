<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align=""class="list">
		<tr>
    		<th><b>Priority</b></th>
    		<th><b>Route</b></th>
    		<th><b>Controller</b></th>
    		<th><b>Enabled</b></th>
    		<th class="right"><b>Action</b></th>
		</tr>
        <?php $table_row = 0; ?>
     	<?php foreach ($routes as $route) { ?>
		<tr id="table-row<?php echo $table_row; ?>">
            <td><input type="text" name="routes[<?php echo $table_row; ?>][priority]" value="<?php echo $route['priority']; ?>" size="2"/>
            <input type="hidden" name="routes[<?php echo $table_row; ?>][uri_route_id]" value="<?php echo $route['route_id']; ?>" /></td>
            <td><input type="text" name="routes[<?php echo $table_row; ?>][route]" value="<?php echo $route['route']; ?>" /></td>
            <td><input type="text" name="routes[<?php echo $table_row; ?>][controller]" value="<?php echo $route['controller']; ?>" /></td>
            <td><?php if ($route['status'] === '1') { ?>
            	<input type="checkbox" name="routes[<?php echo $table_row; ?>][status]" value="1" checked="checked" />
			<?php } else { ?>
            	<input type="checkbox" name="routes[<?php echo $table_row; ?>][status]" value="1" />
			<?php } ?></td>
			<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>
		</tr>
        <?php $table_row++; ?>
		<?php } ?>  
		<tr id="tfoot">
		  	<td colspan="4"></td>
		  	<td class="right"><img src="<?php echo base_url('assets/img/add32x32.png'); ?>" onclick="addRoute();" /></td>
		</tr>		 
	</table>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRoute() {	
	html  = '<tr id="table-row' + table_row + '">';
    html += '	<td><input type="text" name="routes[' + table_row + '][priority]" value="" size="2"/>';
	html += '	<td><input type="text" name="routes[' + table_row + '][route]" value="" /></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][controller]" value="" /></td>';
	html += '	<td><input type="checkbox" name="routes[' + table_row + '][status]" value="1" checked="checked"/></td>';
	html += '	<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
	table_row++;
}
//--></script> 