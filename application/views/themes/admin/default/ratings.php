<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table class="list sorted_table">
			<thead>
				<tr>
					<th width="2"></th>
					<th class="action action-one"></th>
					<th>Name</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php $table_row = 1; ?>
				<?php foreach ($ratings as $key => $value) { ?>
				<tr id="table-row<?php echo $table_row; ?>">
					<td><i class="handle"></i></td>
					<td class="action action-one"><i onclick="$(this).parent().parent().remove();" class="icon icon-delete"></i></td>
					<td><input type="text" name="ratings[<?php echo $table_row; ?>]" value="<?php echo set_value('ratings[$table_row]', $value); ?>" class="textfield" size="40" /></td>
					<td></td>
				</tr>
				<?php $table_row++; ?>
				<?php } ?>  
				<tr id="tfoot">
					<td></td>
					<td class="action action-one"><i class="icon icon-add" onclick="addRating();"></i></td>
					<td colspan="2"></td>
				</tr>		 
			</tbody>
		</table>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRating() {	
	html  = '<tr id="table-row' + table_row + '">';
    html += '	<td><i class="handle"></i></td>';
	html += '	<td class="action action-one"><i onclick="$(this).parent().parent().remove();" class="icon icon-delete"></i></td>';
	html += '	<td><input type="text" name="ratings[' + table_row + ']" value="<?php echo set_value("ratings[' + table_row + ']"); ?>" class="textfield" size="40" /></td>';
	html += '	<td></td>';
	html += '</tr>';
	
	$('.sorted_table tbody').append(html);
	
	table_row++;
}
//--></script>
<script src="<?php echo base_url("assets/js/jquery-sortable.js"); ?>"></script>
<script type="text/javascript"><!--
$(function () {
	$('.sorted_table').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="3"></td></tr>',
		handle: '.handle'
	})
})
//--></script> 
