<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align=""class="list sorted_table">
		<thead> 
		<tr>
    		<th width="2"><b>Sort</b></th>
    		<th><b>URI Route</b></th>
    		<th><b>Controller</b></th>
    		<th class="right"><b>Action</b></th>
		</tr>
		</thead> 
		<tbody> 
        <?php $table_row = 0; ?>
     	<?php foreach ($routes as $route) { ?>
		<tr id="table-row<?php echo $table_row; ?>">
            <td><i class="handle"></i></td>
            <td><input type="text" name="routes[<?php echo $table_row; ?>][uri_route]" value="<?php echo set_value('routes[$table_row][uri_route]', $route['uri_route']); ?>" size="30" /></td>
            <td><input type="text" name="routes[<?php echo $table_row; ?>][controller]" value="<?php echo set_value('routes[$table_row][controller]', $route['controller']); ?>" size="30" /></td>
			<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>
		</tr>
        <?php $table_row++; ?>
		<?php } ?>  
		</tbody> 
		<tfoot> 
		<tr id="tfoot">
		  	<td colspan="3"></td>
		  	<td class="right"><img src="<?php echo base_url('assets/img/add32x32.png'); ?>" onclick="addRoute();" /></td>
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
	html += '	<td><input type="text" name="routes[' + table_row + '][uri_route]" value="<?php echo set_value("routes[' + table_row + '][uri_route]"); ?>" size="30" /></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][controller]" value="<?php echo set_value("routes[' + table_row + '][controller]"); ?>" size="30" /></td>';
	html += '	<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
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
		placeholder: '<tr class="placeholder"/>',
		handle: '.handle'
	})
})
//--></script> 
