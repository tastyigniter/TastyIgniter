<div class="content">
<div class="img_inner">
 	<!--<h3><?php echo $text_filter; ?></h3>-->
	<div class="menu_list">
	<?php if ($menus) {?>
    <table width="100%" align="center" class="list">
		<tbody>
			<?php foreach ($menus as $menu) { ?>
			<tr id="<?php echo $menu['menu_id']; ?>">
				<td align="center"><?php echo $menu['menu_id']; ?>.</td>
				<?php if ($show_menu_images) { ?>
					<td align="center"><div class="img_inner"><img alt="<?php echo $menu['menu_name']; ?>" src="<?php echo $menu['menu_photo']; ?>"></div></td>
				<?php } ?>
				<td class="left" width="58%">
					<?php if ($menu['is_special'] === '1') { ?>	
						<font size="1"><?php echo $menu['end_days']; ?> <?php echo $menu['end_date']; ?></font><br />					
					<?php }?>
	
					<?php echo $menu['menu_name']; ?><br />
					<font size="1">
						<?php echo $menu['menu_description']; ?>
						<!--<?php echo $text_category; ?>: <?php echo $menu['category_name']; ?>-->
					</font>
				</td>
				<td class="left" width="32%">
					<font size="1">
					<?php if (array_key_exists($menu['menu_id'], $has_options)) { ?>
					<?php foreach ($menu_options as $menu_option) { ?>
						<?php if (in_array($menu_option['option_id'], $has_options[$menu['menu_id']])) {?>
							<div class="menu_option"><input type="radio" name="menu_options[<?php echo $menu['menu_id']; ?>]" value="<?php echo $menu_option['option_id']; ?>" />
							<?php echo $menu_option['option_name']; ?>: <?php echo $menu_option['option_price']; ?></div>
						<?php }?>
					<?php }?>
					<?php }?>
					</font>
				</td>
				<td align="center"><div class="price"><?php echo $menu['menu_price']; ?></div></td>
				<td align="center">
				<div class="cart">
					<img class="add_cart" alt="Add" title="Add to order" src="<?php echo base_url(APPPATH. 'views/themes/main/default/images/add-menu.png'); ?>" onClick="addToCart('<?php echo $menu['menu_id']; ?>');" />
				</div>
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