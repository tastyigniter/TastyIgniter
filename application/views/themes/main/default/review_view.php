<div class="content">
	<div class="img_inner">
		<h3><?php echo $text_heading; ?></h3>
	</div>
	<div class="img_inner">
		<table class="form">
			<tr>
				<td><b>Restaurant:</b></td>
				<td><?php echo $location_name; ?></td>
			</tr>
			<tr>
				<td><b>Order ID:</b></td>
				<td><?php echo $order_id; ?></td>
			</tr>
			<tr>
				<td><b>Author:</b></td>
				<td><?php echo $author; ?></td>
			</tr>
			<tr>
				<td><b>Quality Rating:</b></td>
				<td><?php echo $quality_rating; ?></td>
			</tr>
			<tr>
				<td><b>Delivery Rating:</b></td>
				<td><?php echo $delivery_rating; ?></td>
			</tr>
			<tr>
				<td><b>Service Rating:</b></td>
				<td><?php echo $service_rating; ?></td>
			</tr>
			<tr>
				<td><b>Review Text:</b></td>
				<td><?php echo $review_text; ?></td>
			</tr>
			<tr>
				<td><b>Review Date:</b></td>
				<td><?php echo $date; ?></td>
			</tr>
		</table>
	</div>
	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
	</div>
	</form>
</div>