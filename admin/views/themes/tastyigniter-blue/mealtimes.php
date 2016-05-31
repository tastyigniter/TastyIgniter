<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
			</div>
			<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border table-mealtimes">
						<thead>
							<tr>
								<th class="action action-one"></th>
								<th style="width:30%"><?php echo lang('column_mealtime_name'); ?></th>
								<th><?php echo lang('column_start_time'); ?></th>
								<th><?php echo lang('column_end_time'); ?></th>
								<th style="width:15%"><?php echo lang('column_mealtime_status'); ?></th>
								<th class="id"><?php echo lang('column_mealtime_id'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php $table_row = 0; ?>
							<?php foreach ($mealtimes as $mealtime) { ?>
							<tr id="table-row<?php echo $table_row; ?>">
								<td class="action action-one">
									<?php if (empty($mealtime['mealtime_id'])) { ?>
										<a class="btn btn-danger" onclick="confirm('<?php echo lang('alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a>
									<?php } else { ?>
										<a class="btn btn-danger" disabled="disabled"><i class="fa fa-times-circle"></i></a>
									<?php } ?>
								</td>
								<td>
									<input type="hidden" name="mealtimes[<?php echo $table_row; ?>][mealtime_id]" value="<?php echo set_value('mealtimes['.$table_row.'][mealtime_id]', $mealtime['mealtime_id']); ?>"/>
									<input type="text" name="mealtimes[<?php echo $table_row; ?>][mealtime_name]" class="form-control" value="<?php echo set_value('mealtimes['.$table_row.'][mealtime_name]', $mealtime['mealtime_name']); ?>" />
									<?php echo form_error('mealtimes['.$table_row.'][mealtime_id]', '<span class="text-danger">', '</span>'); ?>
									<?php echo form_error('mealtimes['.$table_row.'][mealtime_name]', '<span class="text-danger">', '</span>'); ?>
								</td>
								<td>
									<div class="input-group">
										<input type="text" name="mealtimes[<?php echo $table_row; ?>][start_time]" class="form-control time" value="<?php echo set_value('mealtimes['.$table_row.'][start_time]', $mealtime['start_time']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<?php echo form_error('mealtimes['.$table_row.'][start_time]', '<span class="text-danger">', '</span>'); ?>
								</td>
								<td>
									<div class="input-group">
										<input type="text" name="mealtimes[<?php echo $table_row; ?>][end_time]" class="form-control time" value="<?php echo set_value('mealtimes['.$table_row.'][end_time]', $mealtime['end_time']); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<?php echo form_error('mealtimes['.$table_row.'][end_time]', '<span class="text-danger">', '</span>'); ?>
								</td>
								<td>
									<div class="btn-group btn-group-switch" data-toggle="buttons">
										<?php if ($mealtime['mealtime_status'] === '1') { ?>
											<label class="btn btn-danger"><input type="radio" name="mealtimes[<?php echo $table_row; ?>][mealtime_status]" value="0" <?php echo set_radio('mealtimes['.$table_row.'][mealtime_status]', '0'); ?>><?php echo lang('text_disabled'); ?></label>
											<label class="btn btn-success active"><input type="radio" name="mealtimes[<?php echo $table_row; ?>][mealtime_status]" value="1" <?php echo set_radio('mealtimes['.$table_row.'][mealtime_status]', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
										<?php } else { ?>
											<label class="btn btn-danger active"><input type="radio" name="mealtimes[<?php echo $table_row; ?>][mealtime_status]" value="0" <?php echo set_radio('mealtimes['.$table_row.'][mealtime_status]', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
											<label class="btn btn-success"><input type="radio" name="mealtimes[<?php echo $table_row; ?>][mealtime_status]" value="1" <?php echo set_radio('mealtimes['.$table_row.'][mealtime_status]', '1'); ?>><?php echo lang('text_enabled'); ?></label>
										<?php } ?>
									</div>
									<?php echo form_error('mealtimes['.$table_row.'][mealtime_status]', '<span class="text-danger">', '</span>'); ?>
								</td>
								<td class="id"><?php echo $mealtime['mealtime_id']; ?></td>
							</tr>
							<?php $table_row++; ?>
							<?php } ?>
						</tbody>
						<tfoot>
							<tr id="tfoot">
								<td class="action action-one text-center"><a class="btn btn-primary btn-lg" onclick="addMealtime();"><i class="fa fa-plus"></i></a></td>
								<td colspan="5"></td>
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

function addMealtime() {
	var html  = '<tr id="table-row' + table_row + '">';
	html += '	<td class="action action-one"><a class="btn btn-danger" onclick="confirm(\'<?php echo lang('alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td><input type="hidden" name="mealtimes[' + table_row + '][mealtime_id]" value="0" />';
	html += '		<input type="text" name="mealtimes[' + table_row + '][mealtime_name]" class="form-control" value="" /></td>';
	html += '	<td><div class="input-group">';
	html += '	<input type="text" name="mealtimes[' + table_row + '][start_time]" class="form-control time" value="12:00 AM" />';
	html += '	<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>';
	html += '	</div></td>';
	html += '	<td><div class="input-group">';
	html += '		<input type="text" name="mealtimes[' + table_row + '][end_time]" class="form-control time" value="11:59 PM" />';
	html += '		<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>';
	html += '	</div></td>';
	html += '	<td><div class="btn-group btn-group-switch" data-toggle="buttons">';
	html += '		<label class="btn btn-danger"><input type="radio" name="mealtimes[' + table_row + '][mealtime_status]" value="0" /><?php echo lang('text_disabled'); ?></label>';
	html += '		<label class="btn btn-success active"><input type="radio" name="mealtimes[' + table_row + '][mealtime_status]" value="1" checked="checked" /><?php echo lang('text_enabled'); ?></label>';
	html += '	</div></td>';
	html += '	<td>-</td>';
	html += '</tr>';

	$('.table-mealtimes tbody').append(html);

	$('#table-row' + table_row + ' .time').timepicker({defaultTime: '11:45 AM'});

	table_row++;
}
//--></script>
<script type="text/javascript"><!--
$(function  () {
	$('.time').timepicker({
		defaultTime: '11:45 AM'
	});
});
//--></script>
<?php echo get_footer(); ?>