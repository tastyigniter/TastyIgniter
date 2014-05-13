<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general" class="active">Category Details</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Name:</b></td>
						<td><input type="text" name="category_name" class="textfield" value="<?php echo set_value('category_name', $category_name); ?>"/></td>
					</tr>
					<tr>
						<td><b>Description:</b></td>
						<td><textarea name="category_description" rows="7" cols="50"><?php echo set_value('category_description', $category_description); ?></textarea></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>
