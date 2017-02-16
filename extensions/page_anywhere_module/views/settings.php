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
                                <th><?php echo lang('column_page'); ?></th>
                                <th><?php echo lang('column_layout_partial'); ?>&nbsp;&nbsp;<span title="<?php echo lang('alert_set_module'); ?>" class="fa fa-exclamation-circle"></span></th>
                                <th width="15%"><?php echo lang('column_status'); ?></th>
                            </tr>
                            </thead>
                            <tbody id="pageRefs">
                            <?php $par_row = 1; ?>
                            <?php foreach ($page_anywhere_refs as $pageRef) { ?>
                                <tr class="pageRefRow" id="par-row<?php echo $par_row; ?>">
                                    <td class="action action-one">
                                        <input type="hidden" name="pagerefs[<?php echo $par_row; ?>][pa_id]" value="<?php echo $pageRef['pa_id']; ?>" />
                                        <input type="hidden" id="deletePa_<?php echo $par_row; ?>" name="pagerefs[<?php echo $par_row; ?>][delete_pa]" value="" />
                                        <a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? deletePageRef('#deletePa_<?php echo $par_row; ?>', <?php echo $pageRef['pa_id']; ?>, this) : false;"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                    <td>
                                        <select name="pagerefs[<?php echo $par_row; ?>][page_id]" class="form-control pages">
                                            <?php foreach ($pages as $page) { ?>
                                                <?php if ($page['page_id'] == $pageRef['page_id']) { ?>
                                                    <option value="<?php echo $page['page_id']; ?>" selected="selected"><?php echo $page['name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $page['page_id']; ?>"><?php echo $page['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('pagerefs['.$par_row.'][page_id]', '<span class="text-danger small">', '</span>'); ?>
                                    </td>
                                    <td>
                                        <select name="pagerefs[<?php echo $par_row; ?>][layout_partial]" class="form-control">
                                            <?php foreach ($layouts as $layout) {
                                                $joined_layoutPartial = $pageRef['layout_id'].'|'.$pageRef['partial'];
                                                ?>
                                                <?php if ($layout['value'] == $joined_layoutPartial) { ?>
                                                    <option value="<?php echo $layout['value']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $layout['value']; ?>"><?php echo $layout['name']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <?php echo form_error('pagerefs['.$par_row.'][layout_partial]', '<span class="text-danger small">', '</span>'); ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-switch" data-toggle="buttons">
                                            <?php if ($pageRef['status'] == '1') { ?>
                                                <label class="btn btn-danger"><input type="radio" name="pagerefs[<?php echo $par_row; ?>][status]" value="0" <?php echo set_radio('pagerefs['.$par_row.'][status]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
                                                <label class="btn btn-success active"><input type="radio" name="pagerefs[<?php echo $par_row; ?>][status]" value="1" <?php echo set_radio('pagerefs['.$par_row.'][status]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
                                            <?php } else { ?>
                                                <label class="btn btn-danger active"><input type="radio" name="pagerefs[<?php echo $par_row; ?>][status]" value="0" <?php echo set_radio('pagerefs['.$par_row.'][status]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
                                                <label class="btn btn-success"><input type="radio" name="pagerefs[<?php echo $par_row; ?>][status]" value="1" <?php echo set_radio('pagerefs['.$par_row.'][status]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
                                            <?php } ?>
                                        </div>
                                        <?php echo form_error('pagerefs['.$par_row.'][status]', '<span class="text-danger small">', '</span>'); ?>
                                    </td>
                                </tr>
                                <?php $par_row++; ?>
                            <?php } ?>
                            </tbody>
                            <tfoot>
                            <tr id="tfoot">
                                <td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addPageRefRow();"><i class="fa fa-plus"></i></a></td>
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
    var par_row = <?php echo $par_row; ?>;

    function addPageRefRow() {
        var html = '<tr id="par-row' + par_row + '">';
        html += '	<td class="action action-one">' +
            '<a class="btn btn-danger" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>'+
            '<input type="hidden" name="pagerefs[' + par_row + '][pa_id]" value="' + par_row + '" /></td>';
        html += '	<td><select name="pagerefs[' + par_row + '][page_id]" class="form-control pages">';
        <?php foreach ($pages as $page) { ?>
        html += '<option value="<?php echo $page['page_id']; ?>"><?php echo $page['name']; ?></option>';
        <?php } ?>
        html += '</select></td>';
        html += '	<td><select name="pagerefs[' + par_row + '][layout_partial]" class="form-control">';
        <?php foreach ($layouts as $layout) { ?>
        html += '<option value="<?php echo $layout['value']; ?>"><?php echo $layout['name']; ?></option>';
        <?php } ?>
        html += '	</select></td>';
        html += '   <td><div class="btn-group btn-group-switch" data-toggle="buttons">';
        html += '   	<label class="btn btn-danger active"><input type="radio" name="pagerefs[' + par_row + '][status]" value="0" checked="checked"><?php echo lang('text_disabled'); ?></label>';
        html += '   	<label class="btn btn-success"><input type="radio" name="pagerefs[' + par_row + '][status]" value="1"><?php echo lang('text_enabled'); ?></label>';
        html += '   </div></td>';
        html += '</tr>';

        $('#pageRefs').append(html);
        $('#par-row' + par_row + ' select.form-control').select2();

        par_row++;
    }

    function deletePageRef(delInput, pa_id, deleteButton) {
        $(delInput).val(pa_id);
        $(deleteButton).parent().parent().hide();
    }
    //--></script>