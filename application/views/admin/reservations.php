<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table border="0" align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>ID</th>
			<th>Location</th>
			<th>Customer Name</th>
			<th class="center">Guest(s)</th>
			<th class="center">Table</th>
			<th class="center">Status</th>
			<th class="center">Assigned Staff</th>
			<th class="right">Reserve Time - Date</th>
			<th class="right">Action</th>
		</tr>
  	<?php if ($reservations) { ?>
  	<?php foreach ($reservations as $reservation) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $reservation['reservation_id']; ?>" name="delete[]" /></td>
			<td><?php echo $reservation['reservation_id']; ?></td>
			<td><?php echo $reservation['location_name']; ?></td>
			<td><?php echo $reservation['first_name'] .' '. $reservation['last_name']; ?></td>
			<td class="center"><?php echo $reservation['guest_num']; ?></td>
			<td class="center"><?php echo $reservation['table_name']; ?></td>
			<td class="center"><?php echo $reservation['status_name']; ?></td>
			<td class="center"><?php echo $reservation['staff_name'] ? $reservation['staff_name'] : 'NONE'; ?></td>
			<td class="right"><?php echo $reservation['reserve_time']; ?> - <?php echo $reservation['reserve_date']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $reservation['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="10" align="center"><?php echo $text_empty; ?></td>
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
