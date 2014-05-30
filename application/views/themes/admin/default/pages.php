<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="list-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="right">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search name." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="left">
				<select name="filter_status">
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
				</select>&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-filter"></i></a>&nbsp;
				<a class="grey_icon" href="<?php echo page_url(); ?>"><i class="icon icon-cancel"></i></a>
			</div>
		</div>
		</form>
		
		<form id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table align="center" class="list list-height">
				<thead>
					<tr>
						<th class="action action-three"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th width="40%">Name</th>
						<th class="center">Langauge</th>
						<th class="center">Date Updated</th>
						<th class="center">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($pages) {?>
					<?php foreach ($pages as $page) { ?>
					<tr>
						<td class="action action-three"><input type="checkbox" value="<?php echo $page['page_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $page['edit']; ?>"></a>&nbsp;&nbsp;&nbsp;
							<a class="view" title="Preview" target="_blank" href="<?php echo $page['preview']; ?>"></a>
						</td>
						<td width="40%"><?php echo $page['name']; ?></td>
						<td class="center"><?php echo $page['language']; ?></td>
						<td class="center"><?php echo $page['date_updated']; ?></td>
						<td class="center"><?php echo $page['status']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="5" align="center"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>

		<div class="pagination">
			<?php echo $pagination['links']; ?><?php echo $pagination['info']; ?>
		</div>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>