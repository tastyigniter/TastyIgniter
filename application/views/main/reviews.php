<div class="content">
<div class="img_inner">
	<h3><?php echo $text_heading; ?></h3>
</div>  
<div class="img_inner">
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
  	<table width="100%" class="list">
  		<tr>
  			<th class="left"><b><?php echo $column_order_id; ?></b></th>
  			<th class="left"><b><?php echo $column_restaurant; ?></b></th>
  			<th class="left"><b><?php echo $column_rating; ?></b></th>
  			<th class="right"><b><?php echo $column_date; ?></b></th>
  			<th class="right"><b><?php echo $column_action; ?></b></th>
  		</tr>
		<?php if ($reviews) { ?>
		<?php foreach ($reviews as $review) { ?>
  		<tr align="center">
  			<td class="left"><?php echo $review['order_id']; ?></td>
  			<td class="left"><?php echo $review['location_name']; ?></td>
  			<td class="left">
  				<b>Quality:</b> <?php echo ($review['quality'] != '0') ? $ratings[$review['quality']] : 'None'; ?><br />
  				<b>Delivery:</b> <?php echo ($review['delivery'] != '0') ? $ratings[$review['delivery']] : 'None'; ?><br />
  				<b>Service:</b> <?php echo ($review['service'] != '0') ? $ratings[$review['service']] : 'None'; ?>
  			</td>
  			<td class="right"><?php echo $review['date']; ?></td>
  			<td class="right"><a href="<?php echo $review['view']; ?>"><?php echo $text_view; ?></a></td>
  		</tr>
  		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="7" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
  	</table>
	</form>
</div>

	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
	</div>
</div>