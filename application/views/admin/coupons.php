<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th>Code</th>
			<th>Type</th>
			<th>Discount</th>
			<th class="right">Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($coupons) {?>
		<?php foreach ($coupons as $coupon) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $coupon['coupon_id']; ?>" name="delete[]" /></td>
			<td><?php echo $coupon['name']; ?></td>
			<td><?php echo $coupon['code']; ?></td>
			<td><?php echo $coupon['type']; ?></td>
			<td><?php echo $coupon['discount']; ?></td>
			<td class="right"><?php echo ($coupon['status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $coupon['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="7" align="center"><?php echo $text_empty; ?></td>
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