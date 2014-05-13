<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table border="0" align="center" class="list list-height">
			<tbody>
				<tr>
					<th class="action action-one"></th>
					<th>Name</th>
					<th>Status</th>
				</tr>
				<tr>
					<td class="action action-one"><a class="edit" title="Edit" href="<?php echo $free_edit; ?>"></a></td>
					<td><?php echo $free_name; ?></td>
					<td><?php echo $free_status; ?></td>
				</tr>
				<tr>
					<td class="action action-one"><a class="edit" title="Edit" href="<?php echo $cod_edit; ?>"></a></td>
					<td><?php echo $cod_name; ?></td>
					<td><?php echo $cod_status; ?></td>
				</tr>
				<tr>
					<td class="action action-one"><a class="edit" title="Edit" href="<?php echo $paypal_edit; ?>"></a></td>
					<td><?php echo $paypal_name; ?></td>
					<td><?php echo $paypal_status; ?></td>
				</tr>
				<tr>
					<td class="action action-one"><a class="edit" title="Edit" href="<?php echo $google_edit; ?>"></a></td>
					<td><?php echo $google_name; ?></td>
					<td><?php echo $google_status; ?></td>
				</tr>
			</tbody>
		</table>
	</form>
	</div>
</div>
