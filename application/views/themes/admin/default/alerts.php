<?php echo $header; ?>
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
<div class="row content">
	<div class="col-md-12">
		<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter-bar">
			<div class="left">
				<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search sender or subject." />&nbsp;&nbsp;&nbsp;
				<a class="btn btn-grey input-sm" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
			</div>
		</div>
		</form>
	
		<form role="form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th>Subject</th>
						<th>Sender</th>
						<th class="text-center">Date</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($alerts) {?>
					<?php foreach ($alerts as $alert) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="Delete" name="delete[<?php echo $alert['message_id']; ?>]" />&nbsp;&nbsp;&nbsp;
							<a class="view" title="View" href="<?php echo $alert['view']; ?>"></a></td>
						<td><?php echo $alert['subject']; ?><br /><font size="1"><?php echo $alert['body']; ?></font></td>
						<td><?php echo $alert['sender']; ?></td>
						<td class="text-center"><?php echo $alert['date']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="4"><?php echo $text_empty; ?></td>
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