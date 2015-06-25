<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<th class="action action-three"></th>
								<th><?php echo lang('column_name'); ?></th>
								<th class="id"><?php echo lang('column_id'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($payments) { ?>
							<?php foreach ($payments as $payment) { ?>
							<tr>
								<td class="action action-one"><input type="checkbox" value="<?php echo $payment['extension_id']; ?>" name="delete[]" /></td>
								<td class="action action-three">
                                    <?php if ($payment['options'] === TRUE AND $payment['installed'] === TRUE) {?>
                                        <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $payment['edit']; ?>"><i class="fa fa-pencil"></i></a>
                                    <?php } else { ?>
                                        <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" disabled="disabled"><i class="fa fa-pencil"></i></a>
                                    <?php } ?>
									&nbsp;&nbsp;&nbsp;
									<?php if ($payment['installed'] === TRUE) {?>
										<a class="btn btn-danger" title="<?php echo lang('text_uninstall'); ?>" href="<?php echo $payment['manage']; ?>"><i class="fa fa-stop"></i></a>
									<?php } else { ?>
										<a class="btn btn-info" title="<?php echo lang('text_install'); ?>" href="<?php echo $payment['manage']; ?>"><i class="fa fa-play"></i></a>
									<?php } ?>
								</td>
								<td><?php echo $payment['name']; ?></td>
								<td class="id"><?php echo $payment['extension_id']; ?></td>
							</tr>
							<?php } ?>
							<?php } else {?>
							<tr>
								<td colspan="4"><?php echo lang('text_empty'); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>