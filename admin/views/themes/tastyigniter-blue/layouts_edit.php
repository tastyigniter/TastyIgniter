<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Layout</a></li>
				<li><a href="#routes" data-toggle="tab">Routes</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="routes" class="tab-pane row wrap-all">
					<div class="table-responsive">
						<table class="table table-striped table-border table-sortable">
							<thead>
								<tr>
									<th class="action action-one"></th>
									<th>URI Route</th>
								</tr>
							</thead>
							<tbody>
								<?php $table_row = 0; ?>
								<?php foreach ($routes as $route) { ?>
								<tr id="table-row<?php echo $table_row; ?>">
									<td class="action action-one"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>
									<td><input type="text" name="routes[<?php echo $table_row; ?>][uri_route]" class="form-control" value="<?php echo $route['uri_route']; ?>" />
										<?php echo form_error('routes['.$table_row.'][uri_route]', '<span class="text-danger">', '</span>'); ?>
									</td>
								</tr>
								<?php $table_row++; ?>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr id="tfoot">
									<td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addRoute();"><i class="fa fa-plus"></i></a></td>
									<td></td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRoute() {
	html  = '<tr id="table-row' + table_row + '">';
	html += '	<td class="action action-one"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][uri_route]" class="form-control" value="<?php echo set_value("routes[' + table_row + '][uri_route]"); ?>" size="50" />';
	html += '</tr>';

	$('.table-sortable tbody').append(html);
	$('select.form-control').selectpicker('refresh');

	table_row++;
}
//--></script>
<?php echo $footer; ?>