<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
			</div>
			<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border table-sortable">
						<thead>
							<tr>
								<th class="action action-one"></th>
								<th class="action action-one"></th>
								<th><?php echo lang('column_question'); ?></th>
								<th class="id"><?php echo lang('column_id'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $table_row = 0; ?>
							<?php foreach ($questions as $question) { ?>
							<tr id="table-row<?php echo $table_row; ?>">
								<td class="action action-one text-center"><i class="fa fa-sort handle"></i></td>
								<td class="action action-one">
									<?php if (!is_numeric($question['question_id'])) { ?>
										<a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>
									<?php } else { ?>
										<a class="btn btn-danger" disabled="disabled"><i class="fa fa-times-circle"></i></a>
									<?php } ?>
								</td>
								<td>
									<input type="hidden" name="questions[<?php echo $table_row; ?>][question_id]" value="<?php echo set_value('questions['.$table_row.'][question_id]', $question['question_id']); ?>"/>
									<input type="text" name="questions[<?php echo $table_row; ?>][text]" class="form-control" value="<?php echo set_value('questions['.$table_row.'][text]', $question['text']); ?>" />
									<?php echo form_error('questions['.$table_row.'][question_id]', '<span class="text-danger">', '</span>'); ?>
									<?php echo form_error('questions['.$table_row.'][text]', '<span class="text-danger">', '</span>'); ?>
								</td>
								<td class="id"><?php echo $question['question_id']; ?></td>
							</tr>
							<?php $table_row++; ?>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr id="tfoot">
								<td class="action action-one text-center"><a class="btn btn-primary btn-lg" onclick="addQuestion();"><i class="fa fa-plus"></i></a></td>
								<td class="action action-one"></td>
								<td colspan=""></td>
								<td class="id"></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addQuestion() {
	html  = '<tr id="table-row' + table_row + '">';
	html += '	<td class="action action-one text-center"><i class="fa fa-sort handle"></i></td>';
	html += '	<td class="action action-one"><a class="btn btn-danger" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td><input type="hidden" name="questions[' + table_row + '][question_id]" value="0"/>';
	html += '		<input type="text" name="questions[' + table_row + '][text]" class="form-control" value="" /></td>';
	html += '	<td>-</td>';
	html += '</tr>';

	$('.table-sortable tbody').append(html);

	table_row++;
}
//--></script>
<script type="text/javascript"><!--
$(function  () {
	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="3"></td></tr>',
		handle: '.handle'
	})
});
//--></script>
<?php echo get_footer(); ?>