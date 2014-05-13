<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#settings">Settings</a></li>
			</ul>
		</div>

		<div id="settings" class="wrap_content" style="display:none;">
			<table class="form">
				<tbody>
					<tr>
						<td><span class="red">*</span> <b>Allowed Image Extensions:</b><br />
						<font size="1">List of extensions allowed to be uploaded separated with “|”. e.g png|jpg</font></td>
						<td><textarea name="allowed_img" cols="50" rows="3"><?php echo set_value('allowed_img', $allowed_img); ?></textarea></td>
					</tr>
					<tr>
						<td><span class="red">*</span> <b>Allowed File Extensions:</b><br />
						<font size="1">List of extensions allowed to be uploaded separated with “|”. e.g css|php</font></td>
						<td><textarea name="allowed_file" cols="50" rows="3"><?php echo set_value('allowed_file', $allowed_file); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Hidden Files:</b><br />
						<font size="1">List of files to hide separated with “|”. e.g file1.jpg|file2.txt</font></td>
						<td><textarea name="hidden_files" cols="50" rows="5"><?php echo set_value('hidden_files', $hidden_files); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Hidden Folders:</b><br />
						<font size="1">List of folders to hide separated with “|”. e.g folder1|folder2</font></td>
						<td><textarea name="hidden_folders" cols="50" rows="5"><?php echo set_value('hidden_folders', $hidden_folders); ?></textarea></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>