<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label">Title:</label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

                    <div class="panel panel-default panel-table">
                        <div class="panel-heading">
                            <h3 class="panel-title">Banners</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-border">
                                <thead>
                                    <tr>
                                        <th class="action action-one"></th>
                                        <th>Banner</th>
                                        <th>Dimension (W x H)</th>
                                    </tr>
                                </thead>
                                <tbody id="banners">
                                <?php $banner_row = 1; ?>
                                <?php foreach ($module_banners as $banner) { ?>
                                    <tr id="banner-row<?php echo $banner_row; ?>">
                                        <td class="action action-one"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>
                                        <td><select name="banners[<?php echo $banner_row; ?>][banner_id]" class="form-control">
                                                <?php foreach ($banners as $ban) { ?>
                                                    <?php if ($ban['banner_id'] === $banner['banner_id']) { ?>
                                                        <option value="<?php echo $ban['banner_id']; ?>" selected="selected"><?php echo $ban['name']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $ban['banner_id']; ?>"><?php echo $ban['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('banners['.$banner_row.'][banner_id]', '<span class="text-danger small">', '</span>'); ?>
                                        </td>
                                        <td>
                                            <div class="control-group control-group-2">
                                                <input type="text" name="banners[<?php echo $banner_row; ?>][width]" class="form-control" value="<?php echo $banner['width']; ?>" />
                                                <input type="text" name="banners[<?php echo $banner_row; ?>][height]" class="form-control" value="<?php echo $banner['height']; ?>" />
                                            </div>
                                            <?php echo form_error('banners['.$banner_row.'][width]', '<span class="text-danger small">', '</span>'); ?>
                                            <?php echo form_error('banners['.$banner_row.'][height]', '<span class="text-danger small">', '</span>'); ?>
                                        </td>
                                    </tr>
                                    <?php $banner_row++; ?>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr id="tfoot">
                                    <td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addBanner();"><i class="fa fa-plus"></i></a></td>
                                    <td colspan="2"></td>
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
var banner_row = <?php echo $banner_row; ?>;

function addBanner() {
    var html = '<tr id="banner-row' + banner_row + '">';
    html += '	<td class="action action-one"><a class="btn btn-danger" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
    html += '	<td><select name="banners[' + banner_row + '][banner_id]" class="form-control">';
    <?php foreach ($banners as $ban) { ?>
        html += '<option value="<?php echo $ban['banner_id']; ?>"><?php echo $ban['name']; ?></option>';
    <?php } ?>
    html += '	</select></td>';
    html += '	<td><div class="control-group control-group-2"><input type="text" name="banners[' + banner_row + '][width]" class="form-control" value="" />';
    html += '	<input type="text" name="banners[' + banner_row + '][height]" class="form-control" value="" /></div></td>';
    html += '</tr>';

    $('#banners').append(html);
    $('#banner-row' + banner_row + ' select.form-control').select2();

    banner_row++;
}
//--></script>