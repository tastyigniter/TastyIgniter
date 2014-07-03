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

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table class="table table-striped table-border table-sortable">
				<thead>
					<tr>
						<th class="action action-one"></th>
						<th class="action action-one"></th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					<?php $table_row = 1; ?>
					<?php foreach ($ratings as $key => $value) { ?>
						<tr id="table-row<?php echo $table_row; ?>">
							<td class="action action-one"><i class="fa fa-sort handle"></i></td>
							<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>
							<td>
								<input type="text" name="ratings[<?php echo $table_row; ?>]" class="form-control" value="<?php echo set_value('ratings[$table_row]', $value); ?>" />
								<?php echo form_error('ratings['.$table_row.']', '<span class="text-danger">', '</span>'); ?>
							</td>
						</tr>
					<?php $table_row++; ?>
					<?php } ?>  
				</tbody>
				<tfoot>
					<tr id="tfoot">
						<td class="action action-one"><i class="fa fa-plus" onclick="addRating();"></i></td>
						<td></td>
						<td></td>
					</tr>		 
				</tfoot>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addRating() {	
	html  = '<tr id="table-row' + table_row + '">';
    html += '	<td class="action action-one"><i class="fa fa-sort handle"></i></td>';
	html += '	<td class="action action-one"><a class="btn btn-times" onclick="$(this).parent().parent().remove();"><i class="fa fa-times-circle"></i></a></td>';
	html += '	<td><input type="text" name="ratings[' + table_row + ']" class="form-control" value="<?php echo set_value("ratings[' + table_row + ']"); ?>" /></td>';
	html += '</tr>';
	
	$('.table-sortable tbody').append(html);
	$('select.form-control').selectpicker({iconBase:'fa', tickIcon:'fa-check'});
	
	table_row++;
}
//--></script>
<script src="<?php echo base_url("assets/js/jquery-sortable.js"); ?>"></script>
<script type="text/javascript"><!--
$(function () {
	$('.table-sortable').sortable({
		containerSelector: 'table',
		itemPath: '> tbody',
		itemSelector: 'tr',
		placeholder: '<tr class="placeholder"><td colspan="3"></td></tr>',
		handle: '.handle'
	})
})
//--></script> 
<?php echo $footer; ?>