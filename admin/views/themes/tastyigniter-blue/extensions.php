<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
                <div class="pull-right">
                    <button class="btn btn-filter btn-xs"><i class="fa fa-filter"></i></button>
                </div>
            </div>

            <div class="panel-body panel-filter">
                <form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
                    <div class="filter-bar">
                        <div class="form-inline">
                            <div class="row">
                                <div class="col-md-3 pull-right text-right">
                                    <div class="form-group">
                                        <input type="text" name="filter_search" class="form-control input-sm" value="<?php echo set_value('filter_search', $filter_search); ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
                                    </div>
                                    <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
                                </div>
                                <div class="col-md-8 pull-left">
                                    <div class="form-group">
                                        <select name="filter_status" class="form-control input-sm">
                                            <option value=""><?php echo lang('text_filter_status'); ?></option>
                                            <?php if ($filter_status === '1') { ?>
                                                <option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> ><?php echo lang('text_installed'); ?></option>
                                                <option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_uninstalled'); ?></option>
                                            <?php } else if ($filter_status === '0') { ?>
                                                <option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_installed'); ?></option>
                                                <option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> ><?php echo lang('text_uninstalled'); ?></option>
                                            <?php } else { ?>
                                                <option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_installed'); ?></option>
                                                <option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_uninstalled'); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
                                    <a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-md-12 wrap-vertical">
                    <ul id="nav-tabs" class="nav nav-tabs">
                        <?php if ($filter_type === 'payment') { ?>
                            <li><a href="<?php echo site_url('extensions?filter_type=module'); ?>"><?php echo lang('text_tab_module'); ?></a></li>
                            <li class="active"><a href="<?php echo site_url('extensions?filter_type=payment'); ?>"><?php echo lang('text_tab_payment'); ?></a></li>
                        <?php } else { ?>
                            <li class="active"><a href="<?php echo site_url('extensions?filter_type=module'); ?>"><?php echo lang('text_tab_module'); ?></a></li>
                            <li><a href="<?php echo site_url('extensions?filter_type=payment'); ?>"><?php echo lang('text_tab_payment'); ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action action-three"></th>
                                <th class="name sorter"><a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('column_name'); ?> / <?php echo lang('column_desc'); ?> <i class="fa fa-sort-<?php echo ($sort_by === 'name') ? $order_by_active : $order_by; ?>"></i></a></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($extensions) { ?>
							<?php foreach ($extensions as $extension) { ?>
							<tr>
								<td class="action action-three">
                                    <?php if ($extension['settings'] === TRUE AND $extension['status'] === '1') { ?>
                                        <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $extension['edit']; ?>"><i class="fa fa-pencil"></i></a>
                                        &nbsp;&nbsp;&nbsp;
                                    <?php } else if ($extension['installed'] === TRUE AND $extension['status'] === '1') { ?>
	                                    <a class="btn btn-edit disabled" title="<?php echo lang('text_edit'); ?>"><i class="fa fa-pencil"></i></a>
	                                    &nbsp;&nbsp;&nbsp;
                                    <?php } ?>
									<?php if ($extension['installed'] === TRUE AND $extension['status'] === '1') { ?>
										<a class="btn btn-danger" title="<?php echo lang('text_uninstall'); ?>" href="<?php echo $extension['manage']; ?>"><i class="fa fa-pause"></i></a>
									<?php } else { ?>
										<a class="btn btn-success" title="<?php echo lang('text_install'); ?>" href="<?php echo $extension['manage']; ?>"><i class="fa fa-play"></i></a>
                                    <?php } ?>
                                    &nbsp;&nbsp;&nbsp;
									<?php if ($extension['installed'] !== TRUE OR $extension['status'] !== '1') {?>
										<a class="btn btn-danger delete" title="<?php echo lang('button_delete'); ?>" href="<?php echo $extension['delete']; ?>"><i class="fa fa-trash-o"></i></a>
                                    <?php } ?>
								</td>
								<td>
									<strong><?php echo $extension['title']; ?></strong>
                                    <div class="extension_desc text-muted"><?php echo $extension['description']; ?></div>
                                    <div class="extension_meta text-muted small">
                                        <span><?php echo lang('column_version'); ?>: <?php echo $extension['version']; ?></span>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <span><?php echo lang('column_author'); ?>: <?php echo $extension['author']; ?></span>
                                    </div>

                                </td>
							</tr>
							<?php } ?>
							<?php } else {?>
							<tr>
								<td colspan="2"><?php echo lang('text_empty'); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
    function filterList() {
        $('#filter-form').submit();
    }
//--></script>
<?php echo get_footer(); ?>