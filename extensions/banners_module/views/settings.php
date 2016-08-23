<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
                    <div class="table-responsive">
                        <table class="table table-striped table-border">
                            <thead>
                                <tr>
                                    <th class="action action-one"></th>
                                    <th><?php echo lang('column_banner'); ?></th>
                                    <th><?php echo lang('column_layout_partial'); ?>&nbsp;&nbsp;<span title="<?php echo lang('alert_set_banners'); ?>" class="fa fa-exclamation-circle"></span></th>
                                    <th><?php echo lang('column_dimension'); ?></th>
                                    <th width="15%"><?php echo lang('column_status'); ?></th>
                                </tr>
                            </thead>
                            <tbody id="banners">
                            <?php $banner_row = 1; ?>
                            <?php foreach ($module_banners as $banner) { ?>
                                <tr id="banner-row<?php echo $banner_row; ?>">
                                    <td class="action action-one">
                                        <a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <select name="banners[<?php echo $banner_row; ?>][banner_id]" class="form-control banners">
                                                <?php foreach ($banners as $ban) { ?>
                                                    <?php if ($ban['banner_id'] === $banner['banner_id']) { ?>
                                                        <option value="<?php echo $ban['banner_id']; ?>" selected="selected"><?php echo $ban['name']; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $ban['banner_id']; ?>"><?php echo $ban['name']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <span class="input-group-btn">
                                                <a class="btn btn-edit" href="<?php echo $banner['edit']; ?>" title="<?php echo lang('text_edit_banner'); ?>"><i class="fa fa-pencil"></i></a>
                                            </span>
                                        </div>
                                        <?php echo form_error('banners['.$banner_row.'][banner_id]', '<span class="text-danger small">', '</span>'); ?>
                                    </td>
                                    <td>
                                        <select name="banners[<?php echo $banner_row; ?>][layout_partial]" class="form-control">
                                            <?php foreach ($layouts as $layout) { ?>
                                                <?php if ($layout['value'] === $banner['layout_partial']) { ?>
                                                    <option value="<?php echo $layout['value']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $layout['value']; ?>"><?php echo $layout['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('banners['.$banner_row.'][layout_partial]', '<span class="text-danger small">', '</span>'); ?>
                                    </td>
                                    <td>
                                        <div class="control-group control-group-2">
                                            <input type="text" name="banners[<?php echo $banner_row; ?>][width]" class="form-control" value="<?php echo $banner['width']; ?>" size="4" style="width: auto;" />
                                            <input type="text" name="banners[<?php echo $banner_row; ?>][height]" class="form-control" value="<?php echo $banner['height']; ?>" size="4" style="width: auto;" />
                                        </div>
                                        <?php echo form_error('banners['.$banner_row.'][width]', '<span class="text-danger small">', '</span>'); ?>
                                        <?php echo form_error('banners['.$banner_row.'][height]', '<span class="text-danger small">', '</span>'); ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <?php if ($banner['status'] === '1') { ?>
                                                <label class="btn btn-danger"><input type="radio" name="banners[<?php echo $banner_row; ?>][status]" value="0" <?php echo set_radio('banners['.$banner_row.'][status]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
                                                <label class="btn btn-success active"><input type="radio" name="banners[<?php echo $banner_row; ?>][status]" value="1" <?php echo set_radio('banners['.$banner_row.'][status]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
                                            <?php } else { ?>
                                                <label class="btn btn-danger active"><input type="radio" name="banners[<?php echo $banner_row; ?>][status]" value="0" <?php echo set_radio('banners['.$banner_row.'][status]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
                                                <label class="btn btn-success"><input type="radio" name="banners[<?php echo $banner_row; ?>][status]" value="1" <?php echo set_radio('banners['.$banner_row.'][status]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
                                            <?php } ?>
                                        </div>
                                        <?php echo form_error('banners['.$banner_row.'][status]', '<span class="text-danger small">', '</span>'); ?>
                                    </td>
                                </tr>
                                <?php $banner_row++; ?>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                            <tr id="tfoot">
                                <td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addBanner();"><i class="fa fa-plus"></i></a></td>
                                <td colspan="4"></td>
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
var banner_row = <?php echo $banner_row; ?>;
var banner_edit = '<?php echo admin_url('banners/edit'); ?>/';

function addBanner() {
    var html = '<tr id="banner-row' + banner_row + '">';
    html += '	<td class="action action-one"><a class="btn btn-danger" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
    html += '	<td><div class="input-group"><select name="banners[' + banner_row + '][banner_id]" class="form-control banners">';
    <?php foreach ($banners as $ban) { ?>
        html += '<option value="<?php echo $ban['banner_id']; ?>"><?php echo $ban['name']; ?></option>';
    <?php } ?>
    html += '</select><span class="input-group-btn"><a class="btn btn-edit" href="" title="<?php echo lang('text_edit_banner'); ?>"><i class="fa fa-pencil"></i></a></span></div></td>';
    html += '	<td><select name="banners[' + banner_row + '][layout_partial]" class="form-control">';
    <?php foreach ($layouts as $layout) { ?>
    html += '<option value="<?php echo $layout['value']; ?>"><?php echo $layout['name']; ?></option>';
    <?php } ?>
    html += '	</select></td>';
    html += '	<td><div class="control-group control-group-2"><input type="text" name="banners[' + banner_row + '][width]" class="form-control" value="" size="4" style="width: auto;" />';
    html += '	<input type="text" name="banners[' + banner_row + '][height]" class="form-control" value="" size="4" style="width: auto;" /></div></td>';
    html += '   <td><div class="btn-group btn-group-switch" data-toggle="buttons">';
    html += '   	<label class="btn btn-danger active"><input type="radio" name="banners[' + banner_row + '][status]" value="0" checked="checked"><?php echo lang('text_disabled'); ?></label>';
    html += '   	<label class="btn btn-success"><input type="radio" name="banners[' + banner_row + '][status]" value="1"><?php echo lang('text_enabled'); ?></label>';
    html += '   </div></td>';
    html += '</tr>';

    $('#banners').append(html);
    $('#banner-row' + banner_row + ' select.form-control').select2();
    $('#banner-row' + banner_row + ' select.banners').trigger('change');

    banner_row++;
}

$(document).on('change', 'select.banners', function() {
    var banner_id = this.value;

    $(this).parent().find('.btn-edit').attr('href', banner_edit + banner_id);
});
//--></script>