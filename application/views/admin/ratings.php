<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list sorted_table">
		<tr>
    		<th width="2"><b>Sort</b></th>
			<th>Rating Name</th>
			<th class="right">Action</th>
		</tr>
        <?php $table_row = 1; ?>
		<?php foreach ($ratings as $key => $value) { ?>
		<tr id="table-row<?php echo $table_row; ?>">
            <td><i class="handle"></i></td>
			<td><input type="text" name="ratings[<?php echo $table_row; ?>]" value="<?php echo set_value('ratings[$table_row]', $value); ?>" class="textfield" size="40" /></td>
			<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>
		</tr>
        <?php $table_row++; ?>
		<?php } ?>  
		<tr id="tfoot">
		  	<td colspan="2"></td>
		  	<td class="right"><img src="<?php echo base_url('assets/img/add32x32.png'); ?>" onclick="addRating();" /></td>
		</tr>		 
	</table>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRating() {	
	html  = '<tr id="table-row' + table_row + '">';
    html += '	<td><i class="handle"></i></td>';
	html += '	<td><input type="text" name="ratings[' + table_row + ']" value="<?php echo set_value("ratings[' + table_row + ']"); ?>" class="textfield" size="40" /></td>';
	html += '	<td class="right"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete32x32.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
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
		placeholder: '<tr class="placeholder"/>',
		handle: '.handle'
	})
})
//--></script> 
