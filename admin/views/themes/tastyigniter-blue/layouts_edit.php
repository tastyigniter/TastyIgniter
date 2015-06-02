<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Layout</a></li>
				<li><a href="#routes" data-toggle="tab">Routes</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-bottom active">
                    <div class="wrap-all">
                        <div class="form-group">
                            <label for="input-name" class="col-sm-3 control-label">Name:</label>
                            <div class="col-sm-5">
                                <input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
                                <?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">
                            <h3 class="panel-title">Modules</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-border">
                                <thead>
                                <tr>
                                    <th class="action action-one"></th>
                                    <th>Module</th>
                                    <th>Position</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody id="modules">
                                <?php $module_row = 1; ?>
                                <?php foreach ($layout_modules as $module) { ?>
                                    <tr id="module-row<?php echo $module_row; ?>">
                                        <td class="action action-one"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>
                                        <td><select name="modules[<?php echo $module_row; ?>][module_code]" class="form-control">
                                                <?php foreach ($modules as $mod) { ?>
                                                    <?php if ($mod['module_code'] === $module['module_code']) { ?>
                                                        <option value="<?php echo $mod['module_code']; ?>" selected="selected"><?php echo $mod['title']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $mod['module_code']; ?>"><?php echo $mod['title']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('modules['.$module_row.'][module_code]', '<span class="text-danger small">', '</span>'); ?>
                                        </td>
                                        <td><select name="modules[<?php echo $module_row; ?>][position]" class="form-control">
                                                <?php foreach ($layout_positions as $key => $value) { ?>
                                                    <?php if ($key === $module['position']) { ?>
                                                        <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('modules['.$module_row.'][position]', '<span class="text-danger small">', '</span>'); ?>
                                        </td>
                                        <td><input type="text" name="modules[<?php echo $module_row; ?>][priority]" class="form-control" value="<?php echo $module['priority']; ?>" />
                                            <?php echo form_error('modules['.$module_row.'][priority]', '<span class="text-danger small">', '</span>'); ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <?php if ($module['status'] === '1') { ?>
                                                    <label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="modules[<?php echo $module_row; ?>][status]" value="0" <?php echo set_radio('modules['.$module_row.'][status]', '0'); ?>>Disabled</label>
                                                    <label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="modules[<?php echo $module_row; ?>][status]" value="1" <?php echo set_radio('modules['.$module_row.'][status]', '1', TRUE); ?>>Enabled</label>
                                                <?php } else { ?>
                                                    <label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="modules[<?php echo $module_row; ?>][status]" value="0" <?php echo set_radio('modules['.$module_row.'][status]', '0', TRUE); ?>>Disabled</label>
                                                    <label class="btn btn-default" data-btn="btn-success"><input type="radio" name="modules[<?php echo $module_row; ?>][status]" value="1" <?php echo set_radio('modules['.$module_row.'][status]', '1'); ?>>Enabled</label>
                                                <?php } ?>
                                            </div>
                                            <?php echo form_error('modules['.$module_row.'][status]', '<span class="text-danger small">', '</span>'); ?>
                                        </td>
                                    </tr>
                                    <?php $module_row++; ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr id="tfoot">
                                    <td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addModule();"><i class="fa fa-plus"></i></a></td>
                                    <td colspan="4"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

				<div id="routes" class="tab-pane row wrap-horizontal">
                    <div class="panel panel-default panel-table">
                        <div class="table-responsive">
                            <table class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th class="action action-one"></th>
                                        <th>URI Route</th>
                                    </tr>
                                </thead>
                                <tbody id="routes">
                                    <?php $table_row = 0; ?>
                                    <?php foreach ($layout_routes as $route) { ?>
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
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRoute() {
    var html = '<tr id="table-row' + table_row + '">';
	html += '	<td class="action action-one"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td><input type="text" name="routes[' + table_row + '][uri_route]" class="form-control" value="<?php echo set_value("routes[' + table_row + '][uri_route]"); ?>" size="50" />';
	html += '</tr>';

	$('#routes').append(html);

	table_row++;
}

var module_row = <?php echo $module_row; ?>;

function addModule() {
    var html = '<tr id="module-row' + module_row + '">';
	html += '	<td class="action action-one"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
    html += '	<td><select name="modules[' + module_row + '][module_code]" class="form-control">';
		<?php foreach ($modules as $mod) { ?>
    html += '<option value="<?php echo $mod['module_code']; ?>"><?php echo $mod['title']; ?></option>';
        <?php } ?>
    html += '	</select></td>';
    html += '	<td><select name="modules[' + module_row + '][position]" class="form-control">';
        <?php foreach ($layout_positions as $key => $value) { ?>
    html += '<option value="<?php echo $key; ?>"><?php echo $value; ?></option>';
        <?php } ?>
    html += '	</select></td>';
	html += '	<td><input type="text" name="modules[' + module_row + '][priority]" class="form-control" value="" /></td>';
	html += '   <td><div class="btn-group btn-group-toggle" data-toggle="buttons">';
	html += '   	<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="modules[' + module_row + '][status]" value="0" checked="checked">Disabled</label>';
	html += '   	<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="modules[' + module_row + '][status]" value="1">Enabled</label>';
	html += '   </div></td>';
	html += '</tr>';

	$('#modules').append(html);
	$('.btn-group-toggle input[type="radio"]:checked').trigger('change');

	$('#module-row' + module_row + ' select.form-control').select2();

	module_row++;
}
//--></script>
<?php echo get_footer(); ?>