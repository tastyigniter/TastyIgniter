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
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label"><?php echo lang('label_title'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>

					<div class="form-group">
						<label for="input-menus" class="col-sm-3 control-label"><?php echo lang('label_menus'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="menus" value="" id="input-menus" class="form-control" />
							<?php echo form_error('menus', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="" class="col-sm-3 control-label"></label>
						<div id="featured-menus-box" class="col-sm-5">
							<div class="table-responsive panel-selected">
								<table class="table table-striped table-no-spacing">
									<thead>
									<tr>
										<th><?php echo lang('column_menu_name'); ?></th>
										<th class="text-center"><?php echo lang('column_menu_remove'); ?></th>
									</tr>
									</thead>
									<tbody>
									<?php foreach ($featured_menus as $menu) { ?>
                                        <tr id="menu-box<?php echo $menu['menu_id']; ?>">
                                            <td><?php echo $menu['menu_name']; ?></td>
                                            <td class="img">
                                                <a class="btn btn-danger btn-xs" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;">
                                                    <i class="fa fa-times-circle"></i>
                                                </a>
                                                <input type="hidden" name="featured_menu[]" value="<?php echo $menu['menu_id']; ?>" />
                                            </td>
                                        </tr>
									<?php } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label for="input-limit" class="col-sm-3 control-label"><?php echo lang('label_limit'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="limit" id="input-limit" class="form-control" value="<?php echo set_value('limit', $limit); ?>" />
                            <?php echo form_error('limit', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-per-row" class="col-sm-3 control-label"><?php echo lang('label_items_per_row'); ?>
                            <span class="help-block"><?php echo lang('help_items_per_row'); ?></span>
                        </label>
                        <div class="col-sm-5">
	                        <select name="items_per_row" class="form-control">
		                        <?php foreach (array('1' => 'One','2' => 'Two','3' => 'Three','4' => 'Four','6' => 'Six',) as $key => $value) { ?>
			                        <?php if ($key == $items_per_row) { ?>
				                        <option value="<?php echo $key; ?>" <?php echo set_select('items_per_row', $items_per_row, TRUE); ?>><?php echo $value; ?></option>
			                        <?php } else { ?>
				                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
			                        <?php } ?>
		                        <?php } ?>
	                        </select>
                            <?php echo form_error('items_per_row', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label"><?php echo lang('label_dimension'); ?>
                            <span class="help-block"><?php echo lang('help_dimension'); ?></span>
                        </label>
                        <div class="col-sm-5">
                            <div class="control-group control-group-2">
                                <input type="text" name="dimension_w" class="form-control" value="<?php echo $dimension_w; ?>" />
                                <input type="text" name="dimension_h" class="form-control" value="<?php echo $dimension_h; ?>" />
                            </div>
                            <?php echo form_error('dimension_w', '<span class="text-danger">', '</span>'); ?>
                            <?php echo form_error('dimension_h', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                </div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
    $('input[name=\'menus\']').select2({
        placeholder: 'Start typing...',
        minimumInputLength: 2,
        ajax: {
            url: '<?php echo site_url("/menus/autocomplete"); ?>',
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

    $('input[name=\'menus\']').on('select2-selecting', function(e) {
        $('#menu-box' + e.choice.id).remove();
        $('#featured-menus-box table tbody').append('<tr id="menu-box' + e.choice.id +
            '"><td class="name">' + e.choice.text + '</td><td class="img">' +
            '<a class="btn btn-danger btn-xs" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>' +
            '<input type="hidden" name="featured_menu[]" value="' + e.choice.id + '" /></td></tr>');
    });
//--></script>