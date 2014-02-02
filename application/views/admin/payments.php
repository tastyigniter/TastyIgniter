<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table border="0" align="center" class="list">
		<tr>
			<th>Name</th>
			<th>Status</th>
			<th class="right">Action</th>
		</tr>
		<tr>
			<td>COD</td>
			<td>Enabled</td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $cod_edit; ?>"></a></td>
		</tr>
		<tr>
			<td><?php echo $paypal_name; ?></td>
			<td><?php echo $paypal_status; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $paypal_edit; ?>"></a></td>
		</tr>
	</table>
	</form>
	</div>
</div>
