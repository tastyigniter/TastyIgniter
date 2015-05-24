<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Coupon List</h3>
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
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search name or code." />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-8 pull-left">
									<div class="form-group">
										<select name="filter_type" class="form-control input-sm">
											<option value="">View all types</option>
										<?php if ($filter_type === 'F') { ?>
											<option value="F" <?php echo set_select('filter_type', 'F', TRUE); ?> >Fixed Amount</option>
											<option value="P" <?php echo set_select('filter_type', 'P'); ?> >Percentage</option>
										<?php } else if ($filter_type === 'P') { ?>
											<option value="F" <?php echo set_select('filter_type', 'F'); ?> >Fixed Amount</option>
											<option value="P" <?php echo set_select('filter_type', 'P', TRUE); ?> >Percentage</option>
										<?php } else { ?>
											<option value="F" <?php echo set_select('filter_type', 'F'); ?> >Fixed Amount</option>
											<option value="P" <?php echo set_select('filter_type', 'P'); ?> >Percentage</option>
										<?php } ?>
										</select>&nbsp;
									</div>
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
							<th><a class="sort" href="<?php echo $sort_name; ?>">Name<i class="fa fa-sort-<?php echo ($sort_by == 'name') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_code; ?>">Code<i class="fa fa-sort-<?php echo ($sort_by == 'code') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_type; ?>">Type<i class="fa fa-sort-<?php echo ($sort_by == 'type') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_discount; ?>">Discount<i class="fa fa-sort-<?php echo ($sort_by == 'discount') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_validity; ?>">Validity<i class="fa fa-sort-<?php echo ($sort_by == 'validity') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th class="text-center">Status</th>
						</tr>
					</thead>
					<tbody>
						<?php if ($coupons) {?>
						<?php foreach ($coupons as $coupon) { ?>
						<tr>
							<td class="action"><input type="checkbox" value="<?php echo $coupon['coupon_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
								<a class="btn btn-edit" title="Edit" href="<?php echo $coupon['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
							<td><?php echo $coupon['name']; ?></td>
							<td><?php echo $coupon['code']; ?></td>
							<td><?php echo $coupon['type']; ?></td>
							<td><?php echo $coupon['discount']; ?></td>
							<td><?php echo $coupon['validity']; ?></td>
							<td class="text-center"><?php echo $coupon['status']; ?></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="6"><?php echo $text_empty; ?></td>
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