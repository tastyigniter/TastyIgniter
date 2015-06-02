<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Permission List</h3>
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
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search permission name." />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-8 pull-left">
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value="">View all status</option>
										<?php if ($filter_status === '1') { ?>
											<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> >Enabled</option>
											<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
										<?php } else if ($filter_status === '0') { ?>
											<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
											<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> >Disabled</option>
										<?php } else { ?>
											<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
											<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
										<?php } ?>
										</select>
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
				<table class="table table-striped table-border">
					<thead>
						<tr>
							<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
							<th class="sorter"><a class="sort" href="<?php echo $sort_name; ?>">Name<i class="fa fa-sort-<?php echo ($sort_by == 'name') ? $order_by_active : $order_by; ?>"></i></a></th>
                            <th>Action</th>
                            <th>Description</th>
							<th class="sorter"><a class="sort" href="<?php echo $sort_status; ?>">Status<i class="fa fa-sort-<?php echo ($sort_by == 'status') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th class="id"><a class="sort" href="<?php echo $sort_id; ?>">ID<i class="fa fa-sort-<?php echo ($sort_by == 'permission_id') ? $order_by_active : $order_by; ?>"></i></a></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($permissions) {?>
                            <?php foreach ($permissions as $permission) { ?>
                                <tr>
                                    <td class="action"><input type="checkbox" value="<?php echo $permission['permission_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-edit" title="Edit" href="<?php echo $permission['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
                                    <td class="sorter"><?php echo $permission['name']; ?></td>
                                    <td><?php echo $permission['action']; ?></td>
                                    <td><?php echo $permission['description']; ?></td>
                                    <td class="sorter"><?php echo $permission['status']; ?></td>
                                    <td class="id"><?php echo $permission['permission_id']; ?></td>
                                </tr>
                            <?php } ?>
						<?php } else { ?>
                            <tr>
                                <td colspan="5"><?php echo $text_empty; ?></td>
                            </tr>
						<?php } ?>
					</tbody>
				</table>
				</div>
			</form>

			<div class="pagination-bar clearfix">
				<div class="links"><?php echo $pagination['links']; ?></div>
				<div class="info"><?php echo $pagination['info']; ?></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo get_footer(); ?>