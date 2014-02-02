<div class="content">
<div class="wrap">
 	<h3><?php echo $text_filter; ?></h3>
	<div class="menu_list">
	<?php if ($menus) {?>
    <table width="100%" align="center" class="list">
        <thead>
            <th><?php echo $column_id; ?></th>
            <th><?php echo $column_photo; ?></th>
            <th class="menu_name"><?php echo $column_menu; ?></th>
            <th><?php echo $column_price; ?></th>
            <th><?php echo $column_action; ?></th>
        </thead>
		<tbody>
			<?php foreach ($menus as $menu) { ?>
			<tr id="<?php echo $menu['menu_id']; ?>">
				<td align="center"><?php echo $menu['menu_id']; ?></td>
				<td align="center"><img src="<?php echo $menu['menu_photo']; ?>" width="80" height="70"></td>
				<td class="menu_name"><?php echo $menu['menu_name']; ?><br />
					<font size="1"><?php echo $text_category; ?>: <?php echo $menu['category_name']; ?><br />

						<?php if (array_key_exists($menu['menu_id'], $has_options)) { ?>
						<?php foreach ($menu_options as $menu_option) { ?>
							<?php if (in_array($menu_option['option_id'], $has_options[$menu['menu_id']])) {?>
								<div class="menu_option"><input type="radio" name="menu_options[<?php echo $menu['menu_id']; ?>]" value="<?php echo $menu_option['option_id']; ?>" />
								<?php echo $menu_option['option_name']; ?> = [<?php echo $menu_option['option_price']; ?>]</div>
							<?php }?>
						<?php }?>
						<?php }?>
					</font>
				</td>
				<td align="center"><?php echo $menu['menu_price']; ?></td>
				<td align="center">
					<select name="quantity" class="cart" onChange="addToCart('<?php echo $menu['menu_id']; ?>');">
						<?php foreach ($quantities as $key => $value) { ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php }?>
					</select><br />

					<font size="1">
					<?php if ($menu['is_special'] === '1') { ?>	
						<?php foreach ($specials as $special) { ?>
						<?php if ($special['menu_id'] === $menu['menu_id']) {?>
							<?php echo $special['end_days']; ?><br />
							<?php echo $special['end_date']; ?><br />					
						<?php }?>
						<?php }?>
					<?php }?>
	
					<a id="review" onclick="openReviewBox('<?php echo $menu['menu_id']; ?>');"><?php echo $button_review; ?></a>

 					<div id="total-review">
					<?php foreach ($menu_reviews as $menu_review) { ?>
					<?php if ($menu_review['menu_id'] === $menu['menu_id']) {?>
					(<?php echo $menu_review['total_reviews']; ?> <?php echo $text_reviews; ?>)<br />
					<?php }?>
					<?php }?>
					</div></font>
				</td>
			</tr>
			<?php } ?>
		</tbody>
    </table>
	<?php } else { ?>
		<p><?php echo $text_empty; ?></p>
	<?php } ?>
    </div>
</div>
</div>