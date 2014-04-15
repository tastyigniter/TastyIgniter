<div class="content">
<div class="img_inner">
	<h3><?php echo $text_heading; ?></h3>
</div>  
<div class="img_inner">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
  	<table width="100%" class="list">
  		<tr>
  			<th><b><?php echo $column_id; ?></b></th>
  			<th><b><?php echo $column_status; ?></b></th>
  			<th><b><?php echo $column_location; ?></b></th>
  			<th><b><?php echo $column_date; ?></b></th>
  			<th><b><?php echo $column_order; ?></b></th>
  			<th><b><?php echo $column_items; ?></b></th>
  			<th><b><?php echo $column_total; ?></b></th>
  			<th></th>
  		</tr>
		<?php if ($orders) { ?>
		<?php foreach ($orders as $order) { ?>
  		<tr align="center">
  			<td><a href="<?php echo $order['view']; ?>"><?php echo $order['order_id']; ?></a></td>
  			<td><?php echo $order['status_name']; ?></td>
  			<td><?php echo $order['location_name']; ?></td>
  			<td><?php echo $order['order_time']; ?> - <?php echo $order['date_added']; ?></td>
  			<td><?php echo $order['order_type']; ?></td>
  			<td><?php echo $order['total_items']; ?></td>
  			<td><?php echo $order['order_total']; ?></td>
  			<td><a href="<?php echo $order['leave_review']; ?>"><?php echo $text_leave_review; ?></a></td>
  		</tr>
  		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
  	</table>
	</form>
</div>

	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
		<div class="right"><a class="button" href="<?php echo site_url('menus'); ?>"><?php echo $button_order; ?></a></div>
	</div>
</div>