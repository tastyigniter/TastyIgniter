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
								<div class="col-md-8">
									<div class="form-group">
										<select name="filter_type" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_status'); ?></option>
											<?php if ($filter_type === 'order') { ?>
												<option value="order" <?php echo set_select('filter_type', 'order', TRUE); ?> ><?php echo lang('text_order'); ?></option>
												<option value="reserve" <?php echo set_select('filter_type', 'reserve'); ?> ><?php echo lang('text_reservation'); ?></option>
											<?php } else if ($filter_type === 'reserve') { ?>
												<option value="order" <?php echo set_select('filter_type', 'order'); ?> ><?php echo lang('text_order'); ?></option>
												<option value="reserve" <?php echo set_select('filter_type', 'reserve', TRUE); ?> ><?php echo lang('text_reservation'); ?></option>
											<?php } else { ?>
												<option value="order" <?php echo set_select('filter_type', 'order'); ?> ><?php echo lang('text_order'); ?></option>
												<option value="reserve" <?php echo set_select('filter_type', 'reserve'); ?> ><?php echo lang('text_reservation'); ?></option>
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

			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
                    <table class="table table-striped table-border">
                        <thead>
                            <tr>
                                <th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
                                <th><a class="sort" href="<?php echo $sort_name; ?>"><?php echo lang('column_name'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'status_name') ? $order_by_active : $order_by; ?>"></i></a></th>
                                <th><?php echo lang('column_comment'); ?></th>
                                <th><a class="sort" href="<?php echo $sort_type; ?>"><?php echo lang('column_type'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'status_for') ? $order_by_active : $order_by; ?>"></i></a></th>
                                <th class="text-center"><a class="sort" href="<?php echo $sort_notify; ?>"><?php echo lang('column_notify'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'notify_customer') ? $order_by_active : $order_by; ?>"></i></a></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($statuses) {?>
                            <?php foreach ($statuses as $status) { ?>
                            <tr>
                                <td class="action"><input type="checkbox" value="<?php echo $status['status_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $status['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
                                <td><?php echo $status['status_name']; ?></td>
                                <td><?php echo $status['status_comment']; ?></td>
                                <td><?php echo $status['status_for']; ?></td>
                                <td class="text-center"><?php echo $status['notify_customer']; ?></td>
                            </tr>
                            <?php } ?>
                            <?php } else { ?>
                            <tr>
                                <td colspan="5"><?php echo lang('text_empty'); ?></td>
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