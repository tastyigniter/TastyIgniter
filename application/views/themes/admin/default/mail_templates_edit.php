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

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">General</a></li>
				<li><a href="#messages" data-toggle="tab">Messages</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-language" class="col-sm-2 control-label">Language:</label>
						<div class="col-sm-5">
							<select name="language_id" id="input-language" class="form-control">
								<option value="1" <?php echo set_select('language_id', '1'); ?> >English</option>
							</select>
							<?php echo form_error('language_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php if (empty($template_id)) { ?>
					<div class="form-group">
						<label for="input-clone_template" class="col-sm-2 control-label">Clone Template:</label>
						<div class="col-sm-5">
							<select name="clone_template_id" id="input-clone_template" class="form-control">
								<?php foreach ($templates as $template) { ?>
									<option value="<?php echo $template['template_id']; ?>" <?php echo set_select('clone_template_id', $template['template_id']); ?> ><?php echo $template['name']; ?></option>
								<?php } ?>
							</select>
							<?php echo form_error('clone_template_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<?php } ?>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<select name="status" id="input-status" class="form-control">
								<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
								<?php if ($status === '1') { ?>
									<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
								<?php } ?>  
							</select>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="messages" class="tab-pane row wrap-all">
					<table border="0" class="table table-striped table-border">
						<tbody>
							<tr>
								<th class="action action-one"></th>
								<th class="left" width="65%">Title</th>
								<th class="text-center">Date Added</th>
								<th class="text-center">Date Updated</th>
							</tr>
							<?php if ($template_data) { ?>
							<?php foreach ($template_data as $tpl_data) { ?>
							<tr>
								<td class="action action-one"><a class="btn btn-edit" title="Edit" href="<?php echo $tpl_data['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
								<td class="left"><?php echo $tpl_data['title']; ?></td>
								<td class="text-center"><?php echo $tpl_data['date_added']; ?></td>
								<td class="text-center"><?php echo $tpl_data['date_updated']; ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="4" class="center"><?php echo $text_empty; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>