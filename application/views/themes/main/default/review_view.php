<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-xs-9">
		<div class="row wrap-all">
			<div class="table-responsive">
				<table class="table table-none">
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
						<td><?php echo $quality; ?></td>
					</tr>
					<tr>
						<td><b>Delivery Rating:</b></td>
						<td><?php echo $delivery; ?></td>
					</tr>
					<tr>
						<td><b>Service Rating:</b></td>
						<td><?php echo $service; ?></td>
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
		</div>

		<div class="row wrap-all">
			<div class="buttons">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
			</div>
		</div>
	</form>
</div>
<?php echo $footer; ?>