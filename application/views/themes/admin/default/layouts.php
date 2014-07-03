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

		<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table border="0" class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th>Layout</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($layouts) { ?>
					<?php foreach ($layouts as $layout) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $layout['layout_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="btn btn-edit" title="Edit" href="<?php echo $layout['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
						<td><?php echo $layout['name']; ?></td>
						<td></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="3"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
</div>
<?php echo $footer; ?>