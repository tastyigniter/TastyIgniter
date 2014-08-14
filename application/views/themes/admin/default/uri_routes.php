<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<p>Typically there is a one-to-one relationship between a URI Route and its corresponding controller class/method.<br />
		You can match literal values or you can use two wildcard types:<br />
		<b>(:num)</b> will match a segment containing only numbers.<br />
		<b>(:any)</b> will match a segment containing any character.</p>
		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table border="0" class="table table-striped table-border table-sortable">
				<thead> 
					<tr>
						<th class="action action-one"></th>
						<th class="action action-one"></th>
						<th>URI Route</th>
						<th>Controller</th>
					</tr>
				</thead> 
				<tbody> 
					<?php $table_row = 0; ?>
					<?php foreach ($routes as $route) { ?>
					<tr id="table-row<?php echo $table_row; ?>">
						<td class="action action-one"><i class="fa fa-sort handle"></i></td>
						<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>
						<td><input type="text" name="routes[<?php echo $table_row; ?>][uri_route]" class="form-control" value="<?php echo set_value('routes[$table_row][uri_route]', $route['uri_route']); ?>" /></td>
						<td><input type="text" name="routes[<?php echo $table_row; ?>][controller]" class="form-control" value="<?php echo set_value('routes[$table_row][controller]', $route['controller']); ?>" /></td>
					</tr>
					<?php $table_row++; ?>
					<?php } ?>  
				</tbody> 
				<tfoot> 
					<tr id="tfoot">
						<td></td>
						<td class="action action-one"><i class="fa fa-plus" onclick="addRoute();"></i></td>
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
    html += '	<td><i class="fa fa-sort handle"></i>';
	html += '	<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][uri_route]" class="form-control" value="<?php echo set_value("routes[' + table_row + '][uri_route]"); ?>" /></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][controller]" class="form-control" value="<?php echo set_value("routes[' + table_row + '][controller]"); ?>" /></td>';
	html += '</tr>';
	
	$('.table-sortable tbody').append(html);
	
	table_row++;
}
//--></script> 
<script src="<?php echo base_url("assets/js/jquery-sortable.js"); ?>"></script>
<script type="text/javascript"><!--
$(function  () {
	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="4"></td></tr>',
		handle: '.handle'
	})
})
//--></script> 
<?php echo $footer; ?>