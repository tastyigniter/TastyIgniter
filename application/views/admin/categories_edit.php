<div class="box">
	<div id="update-box" class="content">
	<h2>UPDATE: <?php echo $category_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="category_name" class="textfield" value="<?php echo set_value('category_name', $category_name); ?>"/>
    		</td>
   		</tr>
		<tr>
			<td><b>Description:</b></td>
			<td><textarea name="category_description" rows="7" cols="50"><?php echo set_value('category_description', $category_description); ?></textarea></td>
		</tr>
	</form>
	</table>
	</div>
</div>
