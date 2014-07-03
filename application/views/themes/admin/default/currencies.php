<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
			<div class="filter-bar">
				<div class="form-inline">
					<div class="row">
						<div class="col-md-3 pull-right text-right">
							<div class="form-group">
								<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search name or code." />&nbsp;&nbsp;&nbsp;
							</div>
							<a class="btn btn-grey input-sm" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
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
							<a class="btn btn-grey input-sm" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
							<a class="btn btn-grey input-sm" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
						</div>
					</div>
				</div>
			</div>
		</form>
		
		<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th><a class="sort" href="<?php echo $sort_name; ?>">Name<i class="fa fa-sort-<?php echo ($sort_by == 'currency_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a class="sort" href="<?php echo $sort_code; ?>">Code<i class="fa fa-sort-<?php echo ($sort_by == 'currency_code') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th><a class="sort" href="<?php echo $sort_country; ?>">Country<i class="fa fa-sort-<?php echo ($sort_by == 'country_name') ? $order_by_active : $order_by; ?>"></i></a></th>
						<th class="text-center">Symbol</th>
						<th class="text-center">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($currencies) {?>
					<?php foreach ($currencies as $currency) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $currency['currency_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="btn btn-edit" title="Edit" href="<?php echo $currency['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
						<td><?php echo $currency['currency_name']; ?>
							<?php if ($currency_id === $currency['currency_id']) { ?>
							<b>(Default)</b>
							<?php } ?>
						</td>
						<td><?php echo $currency['currency_code']; ?></td>
						<td><?php echo $currency['country_name']; ?></td>
						<td class="text-center"><?php echo $currency['currency_symbol']; ?></td>
						<td class="text-center"><?php echo $currency['currency_status']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="6"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	
		<div class="pagination-bar clearfix">
			<div class="links"><?php echo $pagination['links']; ?></div>
			<div class="info"><?php echo $pagination['info']; ?></div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo $footer; ?>