<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table align="center" class="list">
		<tr>
			<th>Question</th>
			<th class="right">Action</th>
		</tr>
        <?php $table_row = 0; ?>
		<?php foreach ($questions as $question) { ?>
		<tr id="table-row<?php echo $table_row; ?>">
			<td><input type="hidden" name="questions[<?php echo $table_row; ?>][id]" value="<?php echo set_value('questions[$table_row][id]', $question['question_id']); ?>"/>
			<input type="text" name="questions[<?php echo $table_row; ?>][text]" value="<?php echo set_value('questions[$table_row][text]', $question['question_text']); ?>" class="textfield" size="40" /></td>
			<td class="left"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete.png'); ?>" /></td>
		</tr>
        <?php $table_row++; ?>
		<?php } ?>  
		<tr id="tfoot">
		  	<td colspan="1"></td>
		  	<td class="left"><img src="<?php echo base_url('assets/img/add.png'); ?>" onclick="addQuestion();" /></td>
		</tr>		 
	</table>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addQuestion() {	
	html  = '<tr id="table-row' + table_row + '">';
	html += '	<td><input type="text" name="questions[' + table_row + '][text]" value="<?php echo set_value('questions[$table_row][text]'); ?>" class="textfield" size="40" /></td>';
	html += '	<td class="left"><img onclick="$(this).parent().parent().remove();" src="<?php echo base_url('assets/img/delete.png'); ?>" /></td>';
	html += '</tr>';
	
	$('#tfoot').before(html);
	
	table_row++;
}
//--></script>