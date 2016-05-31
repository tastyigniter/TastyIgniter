<?php echo get_header(); ?>
<div class="row content">
    <div class="col-md-12">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">
                <li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
                <li><a href="#menu-details" data-toggle="tab"><?php echo lang('text_tab_menu_details'); ?> </a></li>
                <li><a href="#menu-options" data-toggle="tab"><?php echo lang('text_tab_menu_option'); ?> </a></li>
                <li><a href="#specials" data-toggle="tab"><?php echo lang('text_tab_special'); ?> </a></li>
            </ul>
        </div>

        <form role="form" id="edit-form" class="form-horizontal" enctype="multipart/form-data" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
            <div class="tab-content">
                <div id="general" class="tab-pane row wrap-all active">
                    <div class="form-group">
                        <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="menu_name" id="input-name" class="form-control" value="<?php echo set_value('menu_name', $menu_name); ?>" />
                            <?php echo form_error('menu_name', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-description" class="col-sm-3 control-label"><?php echo lang('label_description'); ?></label>
                        <div class="col-sm-5">
                            <textarea name="menu_description" id="input-description" class="form-control" rows="5"><?php echo set_value('menu_description', $menu_description); ?></textarea>
                            <?php echo form_error('menu_description', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-price" class="col-sm-3 control-label"><?php echo lang('label_price'); ?></label>
                        <div class="col-sm-5">
                            <div class="input-group">
                                <input type="text" name="menu_price" id="input-price" class="form-control" value="<?php echo set_value('menu_price', $menu_price); ?>" />
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                            </div>
                            <?php echo form_error('menu_price', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_category'); ?></label>
                        <div class="col-sm-5">
                            <select name="menu_category" id="category" class="form-control">
                                <option value=""><?php echo lang('text_select_category'); ?></option>
                                <?php foreach ($categories as $category) { ?>
                                    <?php if ($menu_category === $category['category_id']) { ?>
                                        <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id'], TRUE); ?> ><?php echo $category['category_name']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('menu_category', $category['category_id']); ?> ><?php echo $category['category_name']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('menu_category', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo lang('label_image'); ?>
                            <span class="help-block"><?php echo lang('help_image'); ?></span>
                        </label>
                        <div class="col-sm-5">
                            <div class="thumbnail imagebox" id="selectImage">
                                <div class="preview">
                                    <img src="<?php echo $menu_image_url; ?>" class="thumb img-responsive" id="thumb">
                                </div>
                                <div class="caption">
                                    <span class="name text-center"><?php echo $image_name; ?></span>
                                    <input type="hidden" name="menu_photo" value="<?php echo set_value('menu_photo', $menu_image); ?>" id="field" />
                                    <p>
                                        <a id="select-image" class="btn btn-primary" onclick="mediaManager('field');"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo lang('text_select'); ?></a>
                                        <a class="btn btn-danger" onclick="$('#thumb').attr('src', '<?php echo $no_photo; ?>'); $('#field').attr('value', ''); $(this).parent().parent().find('.name').html('');"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;<?php echo lang('text_remove'); ?> </a>
                                    </p>
                                </div>
                            </div>
                            <?php echo form_error('menu_photo', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                </div>

                <div id="menu-details" class="tab-pane row wrap-all">
                    <div class="form-group">
                        <label for="input-mealtime" class="col-sm-3 control-label"><?php echo lang('label_mealtime'); ?>
                            <span class="help-block"><?php echo lang('help_mealtime'); ?></span>
                        </label>
                        <div class="col-sm-5">
                            <select name="mealtime_id" id="mealtime" class="form-control">
                                <option value="0"><?php echo lang('text_mealtime_all'); ?></option>
                                <?php foreach ($mealtimes as $mealtime) { ?>
                                    <?php if ($mealtime_id === $mealtime['mealtime_id']) { ?>
                                        <option value="<?php echo $mealtime['mealtime_id']; ?>" <?php echo set_select('mealtime_id', $mealtime['mealtime_id'], TRUE); ?> ><?php echo $mealtime['mealtime_name']; ?> <?php echo $mealtime['label']; ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $mealtime['mealtime_id']; ?>" <?php echo set_select('mealtime_id', $mealtime['mealtime_id']); ?> ><?php echo $mealtime['mealtime_name']; ?> <?php echo $mealtime['label']; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('mealtime_id', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-stock" class="col-sm-3 control-label"><?php echo lang('label_stock_qty'); ?>
                            <span class="help-block"><?php echo lang('help_stock_qty'); ?></span>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" name="stock_qty" id="input-stock" class="form-control" value="<?php echo set_value('stock_qty', $stock_qty); ?>" />
                            <?php echo form_error('stock_qty', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-minimum" class="col-sm-3 control-label"><?php echo lang('label_minimum_qty'); ?>
                            <span class="help-block"><?php echo lang('help_minimum_qty'); ?></span>
                        </label>
                        <div class="col-sm-5">
                            <input type="text" name="minimum_qty" id="input-minimum" class="form-control" value="<?php echo set_value('minimum_qty', $minimum_qty); ?>" />
                            <?php echo form_error('minimum_qty', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-subtract-stock" class="col-sm-3 control-label"><?php echo lang('label_subtract_stock'); ?></label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <?php if ($subtract_stock == '1') { ?>
                                    <label class="btn btn-danger"><input type="radio" name="subtract_stock" value="0" <?php echo set_radio('subtract_stock', '0'); ?>><?php echo lang('text_no'); ?></label>
                                    <label class="btn btn-success active"><input type="radio" name="subtract_stock" value="1" <?php echo set_radio('subtract_stock', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-danger active"><input type="radio" name="subtract_stock" value="0" <?php echo set_radio('subtract_stock', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
                                    <label class="btn btn-success"><input type="radio" name="subtract_stock" value="1" <?php echo set_radio('subtract_stock', '1'); ?>><?php echo lang('text_yes'); ?></label>
                                <?php } ?>
                            </div>
                            <?php echo form_error('subtract_stock', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <?php if ($menu_status == '1') { ?>
                                    <label class="btn btn-danger"><input type="radio" name="menu_status" value="0" <?php echo set_radio('menu_status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
                                    <label class="btn btn-success active"><input type="radio" name="menu_status" value="1" <?php echo set_radio('menu_status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-danger active"><input type="radio" name="menu_status" value="0" <?php echo set_radio('menu_status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
                                    <label class="btn btn-success"><input type="radio" name="menu_status" value="1" <?php echo set_radio('menu_status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
                                <?php } ?>
                            </div>
                            <?php echo form_error('menu_status', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-menu-priority" class="col-sm-3 control-label"><?php echo lang('label_menu_priority'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="menu_priority" id="input-menu-priority" class="form-control" value="<?php echo set_value('menu_priority', $menu_priority); ?>" />
                            <?php echo form_error('menu_priority', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                </div>

                <div id="menu-options" class="tab-pane row wrap-all">
                    <div class="form-group">
                        <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_option'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="menu_option" id="input-status" class="form-control" value="" />
                            <?php echo form_error('menu_option', '<span class="text-danger">', '</span>'); ?>
                        </div>
                        <div class="col-sm-3">
                            <a class="btn btn-default" href="<?php echo site_url('menu_options/edit'); ?>"><?php echo lang('button_add_menu_options'); ?></a>
                        </div>
                    </div>
                    <br />

                    <div id="menu-option" class="<?php echo (!$menu_options) ? 'hide' : ''; ?>">
                        <ul id="sub-tabs" class="nav nav-tabs">
                            <?php $option_row = 1; ?>
                            <?php foreach ($menu_options as $menu_option) { ?>
                                <li><a href="#option<?php echo $option_row; ?>" data-toggle="tab"><?php echo "{$menu_option['option_name']} ({$menu_option['display_type']})"; ?>&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="if (confirm('<?php echo lang('alert_warning_confirm'); ?>')) { $('#sub-tabs a[rel=#option1]').trigger('click'); $('#option<?php echo $option_row; ?>').remove(); $(this).parent().parent().remove(); return false; } else { return false;}"></i></a></li>
                                <?php $option_row++; ?>
                            <?php } ?>
                            <li id="last-tab"></li>
                        </ul>

                        <div id="option-content" class="tab-content">
                            <?php $option_row = 1; ?>
                            <?php $option_value_row = 1; ?>
                            <?php if ($menu_options) { ?>
                                <?php foreach ($menu_options as $menu_option) { ?>
                                    <div id="option<?php echo $option_row; ?>" class="tab-pane row wrap-all">
                                        <input type="hidden" name="menu_options[<?php echo $option_row; ?>][menu_option_id]" value="<?php echo $menu_option['menu_option_id']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $option_row; ?>][option_id]" value="<?php echo $menu_option['option_id']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $option_row; ?>][option_name]" value="<?php echo $menu_option['option_name']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $option_row; ?>][display_type]" value="<?php echo $menu_option['display_type']; ?>" />
                                        <input type="hidden" name="menu_options[<?php echo $option_row; ?>][priority]" value="<?php echo $menu_option['priority']; ?>" />

                                        <div class="form-group">
                                            <label for="input-required" class="col-sm-3 control-label"><?php echo lang('label_option_required'); ?>
                                                <span class="help-block"><?php echo lang('help_option_required'); ?></span>
                                            </label>
                                            <div class="col-sm-5">
                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                    <?php if ($menu_option['required'] === '1') { ?>
                                                        <label class="btn btn-danger"><input type="radio" name="menu_options[<?php echo $option_row; ?>][required]" value="0" <?php echo set_radio('menu_options['.$option_row.'][required]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
                                                        <label class="btn btn-success active"><input type="radio" name="menu_options[<?php echo $option_row; ?>][required]" value="1" <?php echo set_radio('menu_options['.$option_row.'][required]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
                                                    <?php } else { ?>
                                                        <label class="btn btn-danger active"><input type="radio" name="menu_options[<?php echo $option_row; ?>][required]" value="0" <?php echo set_radio('menu_options['.$option_row.'][required]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
                                                        <label class="btn btn-success"><input type="radio" name="menu_options[<?php echo $option_row; ?>][required]" value="1" <?php echo set_radio('menu_options['.$option_row.'][required]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
                                                    <?php } ?>
                                                </div>
                                                <?php echo form_error('menu_options['.$option_row.'][required]', '<span class="text-danger">', '</span>'); ?>
                                            </div>
                                        </div>

                                        <div class="panel panel-default panel-table">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-border table-sortable">
                                                    <thead>
                                                    <tr>
                                                        <th class="action action-one"></th>
                                                        <th class="col-sm-4"><?php echo lang('label_option_value'); ?></th>
                                                        <th><?php echo lang('label_option_price'); ?></th>
                                                        <th><?php echo lang('label_option_qty'); ?></th>
                                                        <th class="col-sm-2 text-center"><?php echo lang('label_subtract_stock'); ?></th>
                                                        <th class="text-center"><?php echo lang('label_option_default_value'); ?></th>
                                                        <th class="id"><?php echo lang('label_option_value_id'); ?></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach ($menu_option['option_values'] as $value) { ?>
                                                        <tr id="option-value<?php echo $option_value_row; ?>">
                                                            <td class="action action-one"><a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>
                                                            <td>
                                                                <select name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][option_value_id]" class="form-control">
                                                                    <?php if (isset($option_values[$menu_option['option_id']])) { ?>
                                                                        <?php foreach($option_values[$menu_option['option_id']] as $option_value) { ?>
                                                                            <?php if ($value['option_value_id'] == $option_value['option_value_id']) { ?>
                                                                                <option value="<?php echo $option_value['option_value_id']; ?>" selected="selected"><?php echo $option_value['value']; ?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['value']; ?></option>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                                <?php echo form_error('menu_options['.$option_row.'][option_values]['.$option_value_row.'][option_value_id]', '<span class="text-danger">', '</span>'); ?>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][price]" class="form-control" value="<?php echo set_value('menu_options['.$option_row.'][option_values]['.$option_value_row.'][price]', $value['price']); ?>" />
                                                                <?php echo form_error('menu_options['.$option_row.'][option_values]['.$option_value_row.'][price]', '<span class="text-danger">', '</span>'); ?>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][quantity]" class="form-control" value="<?php echo set_value('menu_options['.$option_row.'][option_values]['.$option_value_row.'][quantity]', $value['quantity']); ?>" />
                                                                <?php echo form_error('menu_options['.$option_row.'][option_values]['.$option_value_row.'][quantity]', '<span class="text-danger">', '</span>'); ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="btn-group btn-group-switch" data-toggle="buttons">
                                                                    <?php if ($value['subtract_stock'] === '1') { ?>
                                                                        <label class="btn btn-default"><input type="radio" name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][subtract_stock]" value="0"><?php echo lang('text_no'); ?></label>
                                                                        <label class="btn btn-default active"><input type="radio" name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][subtract_stock]" value="1" checked="checked"><?php echo lang('text_yes'); ?></label>
                                                                    <?php } else { ?>
                                                                        <label class="btn btn-default active"><input type="radio" name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][subtract_stock]" value="0" checked="checked"><?php echo lang('text_no'); ?></label>
                                                                        <label class="btn btn-default"><input type="radio" name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][subtract_stock]" value="1"><?php echo lang('text_yes'); ?></label>
                                                                    <?php } ?>
                                                                </div>
                                                                <?php echo form_error('menu_options['.$option_row.'][option_values]['.$option_value_row.'][subtract_stock]', '<span class="text-danger">', '</span>'); ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?php if ($menu_option['default_value_id'] == $value['menu_option_value_id']) { ?>
                                                                    <input type="radio" name="menu_options[<?php echo $option_row; ?>][default_value_id]" value="<?php echo $value['menu_option_value_id']; ?>" checked />
                                                                <?php } else { ?>
                                                                    <input type="radio" name="menu_options[<?php echo $option_row; ?>][default_value_id]" value="<?php echo $value['menu_option_value_id']; ?>" />
                                                                <?php } ?>
                                                            </td>
                                                            <td class="id">
                                                                <input type="hidden" name="menu_options[<?php echo $option_row; ?>][option_values][<?php echo $option_value_row; ?>][menu_option_value_id]" value="<?php echo $value['menu_option_value_id']; ?>" />
                                                                <?php echo $value['menu_option_value_id']; ?>
                                                            </td>
                                                        </tr>
                                                        <?php $option_value_row++; ?>
                                                    <?php } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr id="tfoot">
                                                        <td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addOptionValue(<?php echo $option_row; ?>);"><i class="fa fa-plus"></i></a></td>
                                                        <td colspan="5"></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <select id="option-values<?php echo $option_row; ?>" style="display:none;">
                                            <?php if (isset($option_values[$menu_option['option_id']])) { ?>
                                                <?php foreach($option_values[$menu_option['option_id']] as $option_value) { ?>
                                                    <option value="<?php echo $option_value['option_value_id']; ?>"><?php echo $option_value['value']; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>

                                    </div>
                                    <?php $option_row++; ?>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div id="specials" class="tab-pane row wrap-all">
                    <div class="form-group">
                        <label for="input-special-status" class="col-sm-3 control-label"><?php echo lang('label_special'); ?></label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <?php if ($special_status === '1') { ?>
                                    <label class="btn btn-danger"><input type="radio" name="special_status" value="0"><?php echo lang('text_disabled'); ?></label>
                                    <label class="btn btn-success active"><input type="radio" name="special_status" value="1" checked><?php echo lang('text_enabled'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-danger active"><input type="radio" name="special_status" value="0" checked><?php echo lang('text_disabled'); ?></label>
                                    <label class="btn btn-success"><input type="radio" name="special_status" value="1"><?php echo lang('text_enabled'); ?></label>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="special_id" value="<?php echo set_value('special_id', $special_id); ?>" />
                            <?php echo form_error('special_status', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div id="special-toggle">
                        <div class="form-group">
                            <label for="start-date" class="col-sm-3 control-label"><?php echo lang('label_start_date'); ?></label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="start_date" id="start-date" class="form-control" value="<?php echo set_value('start_date', $start_date); ?>" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <?php echo form_error('start_date', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end-date" class="col-sm-3 control-label"><?php echo lang('label_end_date'); ?></label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="end_date" id="end-date" class="form-control" value="<?php echo set_value('end_date', $end_date); ?>" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                                <?php echo form_error('end_date', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-special-price" class="col-sm-3 control-label"><?php echo lang('label_special_price'); ?></label>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" name="special_price" id="input-special-price" class="form-control" value="<?php echo set_value('special_price', $special_price); ?>" />
                                    <span class="input-group-addon">.00</span>
                                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                </div>
                                <?php echo form_error('special_price', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript"><!--
    $(document).ready(function() {
        $('#start-date, #end-date').datepicker({
            format: 'dd-mm-yyyy',
        });

        $('input[name="special_status"]').on('change', function() {
            if (this.value == '1') {
                $('#special-toggle').slideDown(300);
            } else {
                $('#special-toggle').slideUp(300);
            }
        });
    });
    //--></script>
<script type="text/javascript"><!--
    $('input[name=\'menu_option\']').select2({
        placeholder: 'Start typing...',
        minimumInputLength: 2,
        ajax: {
            url: '<?php echo site_url("/menu_options/autocomplete"); ?>',
            dataType: 'json',
            quietMillis: 100,
            data: function (term, page) {
                return {
                    term: term, //search term
                    page_limit: 10 // page size
                };
            },
            results: function (data, page, query) {
                return { results: data.results };
            }
        }
    });

    $('input[name=\'menu_option\']').on('select2-selecting', function(e) {
        if ($('#menu-option').hasClass('hide')) {
            $('#menu-option').removeClass('hide');
        }
        addOption(e.choice);
    });
    $('#sub-tabs a:first').tab('show');
    //--></script>
<script type="text/javascript"><!--
    var option_row = <?php echo (int)$option_row; ?>;
    var option_value_row = <?php echo $option_value_row; ?>;

    function addOption(data) {
        html  = '<div id="option' + option_row + '" class="tab-pane row wrap-all">';
        html += '	<input type="hidden" name="menu_options[' + option_row + '][menu_option_id]" id="" value="" />';
        html += '	<input type="hidden" name="menu_options[' + option_row + '][option_id]" id="" value="' + data.id + '" />';
        html += '	<input type="hidden" name="menu_options[' + option_row + '][option_name]" id="" value="' + data.text + '" />';
        html += '	<input type="hidden" name="menu_options[' + option_row + '][display_type]" id="" value="' + data.display + '" />';
        html += '	<input type="hidden" name="menu_options[' + option_row + '][priority]" id="" value="' + data.priority + '" />';
        html += '	<div class="form-group">';
        html += '		<label for="input-required" class="col-sm-3 control-label"><?php echo lang('label_option_required'); ?>';
        html += '			<span class="help-block"><?php echo lang('help_option_required'); ?></span>';
        html += '		</label>';
        html += '		<div class="col-sm-5">';
        html += '			<div class="btn-group btn-group-switch" data-toggle="buttons">';
        html += '				<label class="btn btn-danger active"><input type="radio" name="menu_options[' + option_row + '][required]" checked="checked"value="0"><?php echo lang('text_disabled'); ?></label>';
        html += '				<label class="btn btn-success"><input type="radio" name="menu_options[' + option_row + '][required]" value="1"><?php echo lang('text_enabled'); ?></label>';
        html += '			</div>';
        html += '		</div>';
        html += '	</div>';
        html += '	<div class="panel panel-default panel-table"><div class="table-responsive">';
        html += '	<table class="table table-striped table-border table-sortable">';
        html += '		<thead><tr>';
        html += '			<th class="action action-one"></th>';
        html += '			<th class="col-sm-4"><?php echo lang('label_option_value'); ?></th>';
        html += '			<th><?php echo lang('label_option_price'); ?></th>';
        html += '			<th><?php echo lang('label_option_qty'); ?></th>';
        html += '			<th class="col-sm-3 text-center"><?php echo lang('label_option_subtract_stock'); ?></th>';
        html += '			<th>ID</th>';
        html += '		</tr></thead>';
        html += '		<tbody></tbody>';
        html += '		<tfoot><tr id="tfoot">';
        html += '			<td class="action action-one"><a class="btn btn-primary btn-lg" onclick="addOptionValue(' + option_row + ');"><i class="fa fa-plus"></i></a></td>';
        html += '			<td colspan="5"></td>';
        html += '		</tr></tfoot>';
        html += '	</table>';
        html += '	</div></div>';
        html += '  <select id="option-values' + option_row + '" style="display: none;">';
        for (i = 0; i < data.option_values.length; i++) {
            html += '  <option value="' + data.option_values[i]['option_value_id'] + '">' + data.option_values[i]['value'] + '</option>';
        }
        html += '  </select>';
        html += '</div>';

        $('#option-content').append(html);
        $('#last-tab').before('<li><a href="#option' + option_row + '" data-toggle="tab">' + data.text + '&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="if (confirm(\'<?php echo lang('alert_warning_confirm'); ?>\')) { $(\'#sub-tabs a[rel=#option1]\').trigger(\'click\'); $(\'#option' + option_row + '\').remove(); $(this).parent().parent().remove(); return false;} else {return false;}"></i></a></li>');
        $('#sub-tabs a[href="#option' + option_row + '"]').tab('show');

        addOptionValue(option_row);
        option_row++;
    }

    function addOptionValue(option_row) {
        html  = '<tr id="option-value' + option_value_row + '">';
        html += '	<td class="action action-one"><a class="btn btn-danger" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
        html += '	<td><select name="menu_options[' + option_row + '][option_values][' + option_value_row + '][option_value_id]" class="form-control">';
        html += $('#option-values' + option_row).html();
        html += '	</select></td>';
        html += '	<td><input type="text" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][price]" class="form-control" value="" /></td>';
        html += '	<td><input type="text" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][quantity]" class="form-control" value="" /></td>';
        html += '	<td class="text-center"><div class="btn-group btn-group-switch" data-toggle="buttons">';
        html += '		<label class="btn btn-default active"><input type="radio" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][subtract_stock]" checked="checked"value="0"><?php echo lang('text_no'); ?></label>';
        html += '		<label class="btn btn-default"><input type="radio" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][subtract_stock]" value="1"><?php echo lang('text_yes'); ?></label>';
        html += '	</div></td>';
        html += '	<td class="text-center">-</td>';
        html += '	<td class="id"><input type="hidden" name="menu_options[' + option_row + '][option_values][' + option_value_row + '][menu_option_value_id]" class="form-control" value="" />-</td>';
        html += '</tr>';

        $('#option' + option_row + ' .table-sortable tbody').append(html);
        $('#option-value' + option_value_row + ' select.form-control').select2();

        option_value_row++;
    }
//--></script>
<?php echo get_footer(); ?>