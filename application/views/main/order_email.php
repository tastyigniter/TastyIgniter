<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $text_heading ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="container">
<div id="content">
<table width="80%" class="order_confirmation">
	<tr>
    	<td><?php echo $text_greetings; ?></td>
    </tr>
	<tr>
    	<td><?php echo $message; ?></td>
    </tr>
    <tr>
        <td><h4><?php echo $text_order_details; ?></h4></td>
    </tr>
    <tr>
        <td><?php echo $order_details; ?></td>
    </tr>
   	<tr>
        <td><h4><?php echo $text_order_items; ?></h4></td>
   	</tr>
   	<tr>
   		<td>
			<table>
			<?php foreach ($menus as $menu) { ?>
			<tr>
			 	<td>x <?php echo $menu['quantity']; ?></td>
				<td><?php echo $menu['name']; ?><br />
					<?php if (!empty($menu['order_option_id'])) { ?>
						<div><font size="1">+ <?php echo $menu['option_name']; ?>: <?php echo $menu['option_price']; ?> </font></div>
					<?php } ?></td>
				<td><?php echo $menu['price']; ?></td>
			 </tr>		
			<?php } ?>
			</table
   		</td>
   	</tr>
   	<tr>
   		<td><?php echo $order_total; ?></td>
   	</tr>
	<?php if ($delivery_address) { ?>
   	<tr>
        <td><h4><?php echo $text_delivery_address; ?></h4></td>
   	</tr>
   	<tr>
   		<td><address><?php echo $delivery_address['address_1']; ?>, <?php echo $delivery_address['address_2']; ?>, <?php echo $delivery_address['city']; ?>, <?php echo $delivery_address['postcode']; ?>, <?php echo $delivery_address['country']; ?></address></td>
   	</tr>
	<?php } ?>
   	<tr>
        <td><h4><?php echo $text_local; ?></h4></td>
   	</tr>
   	<tr>
    	<td><?php echo $location_name; ?></td>
   	</tr>
	<tr>
		<td><br /><br /><?php echo $text_thank_you; ?></td>
	</tr>
</table>
</div>
</div>
</body>
</html>