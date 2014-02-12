<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table border="0" align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>ID</th>
			<th>Location</th>
			<th>Customer Name</th>
			<th width="4" class="right">Guest(s)</th>
			<th class="right">Table</th>
			<th>Status</th>
			<th>Assigned Staff</th>
			<th class="center">Time</th>
			<th class="center">Date</th>
			<th class="right">Action</th>
		</tr>
  	<?php if ($reservations) { ?>
  	<?php foreach ($reservations as $reservation) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $reservation['reservation_id']; ?>" name="delete[]" /></td>
			<td><?php echo $reservation['reservation_id']; ?></td>
			<td><?php echo $reservation['location_name']; ?></td>
			<td><?php echo $reservation['first_name'] .' '. $reservation['last_name']; ?></td>
			<td class="right"><?php echo $reservation['guest_num']; ?></td>
			<td class="right"><?php echo $reservation['table_name']; ?></td>
			<td><?php echo $reservation['status_name']; ?></td>
			<td><?php echo $reservation['staff_name'] ? $reservation['staff_name'] : 'NONE'; ?></td>
			<td class="center"><?php echo $reservation['reserve_time']; ?></td>
			<td class="center"><?php echo $reservation['reserve_date']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $reservation['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="11" align="center"><?php echo $text_empty; ?></td>
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
