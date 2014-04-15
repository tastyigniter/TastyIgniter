<div class="content">
<div class="img_inner">
	<h3><?php echo $text_heading; ?></h3>
</div>  
<div class="img_inner">
	<?php if ($error) { ?>
		<?php echo $error; ?>
	<?php } else { ?>
	<form method="post" accept-charset="utf-8" action="<?php echo current_url(); ?>">
	<table>
		<tr>
			<td width="60%"><b><?php echo $column_id; ?>:</b></td>
			<td><?php echo $order_id; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_date; ?>:</b></td>
			<td><?php echo $order_time; ?> - <?php echo $date_added; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_order; ?>:</b></td>
			<td><?php echo $order_type; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_delivery; ?>:</b></td>
			<td><?php echo $delivery_address; ?></td>
		</tr>
		<tr>
			<td><b><?php echo $column_location; ?>:</b></td>
			<td><?php echo $location_name; ?><br /><?php echo $location_address; ?></td>
		</tr>
	</table>
	<br /><br />
	
	<h3>Order Menus</h3>
	<table height="" class="list">
		<tr>
			<th width="1"></th>
			<th class="" width="25%">Name/Options</th>
			<th class="center">Price</th>
			<th class="right">Total</th>
		</tr>
		<?php foreach ($menus as $menu) { ?>
		<tr id="<?php echo $menu['id']; ?>">
			<td width="1"><?php echo $menu['qty']; ?>x</td>
			<td class="food_name"><?php echo $menu['name']; ?><br />
			<?php if (!empty($menu['options'])) { ?>
				<div><font size="1">+ <?php echo $menu['options']['name']; ?>: <?php echo $menu['options']['price']; ?> </font></div>
			<?php } ?>
			</td>
			<td class="center"><?php echo $menu['price']; ?></td>
			<td class="right"><?php echo $menu['subtotal']; ?></td>
		</tr>
		<?php } ?>
		<?php foreach ($totals as $total) { ?>
		<tr>
			<td width="1"></td>
			<td></td>
			<td class="center"><b><?php echo $total['title']; ?></b></td>
			<td class="right"><b><?php echo $total['value']; ?></b></td>
		</tr>    	
		<?php } ?>
		<tr>
			<td width="1"></td>
			<td></td>
			<td class="center"><b>TOTAL</b></td>
			<td class="right"><b><?php echo $order_total; ?></b></td>
		</tr>    	
	</table>
	<?php } ?>
	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
		<div class="right"><a class="button" href="<?php echo site_url('payments'); ?>"><?php echo $button_reorder; ?></a></div>
	</div>
</div>
</div>