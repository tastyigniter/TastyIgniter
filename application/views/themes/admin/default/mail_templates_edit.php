<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a class="active" rel="#general">General</a></li>
				<li><a rel="#messages">Messages</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table align=""class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
					</tr>
					<tr>
						<td><b>Language:</b></td>
						<td><select name="language_id">
							<option value="1" <?php echo set_select('language_id', '1'); ?> >English</option>
						</select></td>
					</tr>
					<?php if (empty($template_id)) { ?>
					<tr>
						<td><b>Clone Template:</b></td>
						<td><select name="clone_template_id">
						<?php foreach ($templates as $template) { ?>
							<option value="<?php echo $template['template_id']; ?>" <?php echo set_select('clone_template_id', $template['template_id']); ?> ><?php echo $template['name']; ?></option>
						<?php } ?>
						</select></td>
					</tr>
					<?php } ?>
					<tr>
						<td><b>Status:</b></td>
						<td><select name="status">
							<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
						<?php if ($status === '1') { ?>
							<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="messages" class="wrap_content" style="display:none;">
			<table align=""class="list list-height">
				<tbody>
					<tr>
						<th class="action action-one"></th>
						<th class="left" width="65%">Title</th>
						<th class="center">Date Added</th>
						<th class="center">Date Updated</th>
					</tr>
					<?php if ($template_data) { ?>
					<?php foreach ($template_data as $tpl_data) { ?>
					<tr>
						<td class="action action-one"><a class="edit" title="Edit" href="<?php echo $tpl_data['edit']; ?>"></a></td>
						<td class="left"><?php echo $tpl_data['title']; ?></td>
						<td class="center"><?php echo $tpl_data['date_added']; ?></td>
						<td class="center"><?php echo $tpl_data['date_updated']; ?></td>
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

	</form>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>