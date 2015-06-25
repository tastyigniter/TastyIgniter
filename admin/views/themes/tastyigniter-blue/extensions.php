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
								<th class="action action-three"></th>
								<th><?php echo lang('column_name'); ?></th>
								<th class="id"><?php echo lang('column_id'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($extensions) { ?>
							<?php foreach ($extensions as $extension) { ?>
							<tr>
								<td class="action action-three">
                                    <?php if ($extension['options'] === TRUE AND $extension['installed'] === TRUE) {?>
                                        <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $extension['edit']; ?>"><i class="fa fa-pencil"></i></a>
                                    <?php } else { ?>
                                        <a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" disabled="disabled"><i class="fa fa-pencil"></i></a>
                                    <?php } ?>
                                    &nbsp;&nbsp;&nbsp;
									<?php if ($extension['installed'] === TRUE) {?>
										<a class="btn btn-danger" title="<?php echo lang('text_uninstall'); ?>" href="<?php echo $extension['manage']; ?>"><i class="fa fa-stop"></i></a>
									<?php } else { ?>
										<a class="btn btn-info" title="<?php echo lang('text_install'); ?>" href="<?php echo $extension['manage']; ?>"><i class="fa fa-play"></i></a>
                                    <?php } ?>
								</td>
								<td><?php echo $extension['title']; ?></td>
								<td class="id">
                                    <?php if (!is_numeric($extension['extension_id'])) { ?>
                                        <a class="btn btn-danger" title="<?php echo lang('button_delete'); ?>" href="<?php echo $extension['delete']; ?>"><i class="fa fa-times"></i></a>
                                    <?php } else { ?>
                                        <?php echo $extension['extension_id']; ?>
                                    <?php } ?>
                                </td>
							</tr>
							<?php } ?>
							<?php } else {?>
							<tr>
								<td colspan="3"><?php echo lang('text_empty'); ?></td>
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