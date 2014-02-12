<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table border="0" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Telephone</th>
			<th class="right">Date Added</th>
			<th class="right">Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($customers) { ?>
		<?php foreach ($customers as $customer) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo $customer['customer_id']; ?>" name="delete[]" /></td>
			<td><?php echo $customer['first_name']; ?></td>
			<td><?php echo $customer['last_name']; ?></td>
			<td><?php echo $customer['email']; ?></td>
			<td><?php echo $customer['telephone']; ?></td>
			<td class="right"><?php echo $customer['date_added']; ?></td>
			<td class="right"><?php echo $customer['status']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $customer['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8" align="center"><?php echo $text_empty; ?></td>
		</tr>	
		<?php } ?>
	</table>
	</form>
	
	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
</div>
