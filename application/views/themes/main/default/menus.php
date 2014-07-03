<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="notification" class="row">
<?php if (!empty($alert)) { ?>
	<div class="alert alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $alert; ?>
	</div>
<?php } ?>
</div>
<div class="row content"><?php echo $content_right; ?>
	<?php echo $content_left; ?>

	<div class="col-md-7">
		<div class="wrap-horizontal">
			<?php if ($menus) {?>
			<div class="table-responsive">
				<table class="table table-none table-hover menus-table">
					<tbody>
						<?php foreach ($menus as $menu) { ?>
						<tr id="<?php echo $menu['menu_id']; ?>">
							<td><?php echo $menu['menu_id']; ?>.</td>
							<?php if ($show_menu_images) { ?>
								<td align="center">
									<img class="img-responsive img-thumbnail" alt="<?php echo $menu['menu_name']; ?>" src="<?php echo $menu['menu_photo']; ?>">
								</td>
							<?php } ?>
							<td width="58%">
								<?php if ($menu['is_special'] === '1') { ?>	
									<font size="1"><?php echo $menu['end_days']; ?></font><br />					
								<?php }?>

								<?php echo $menu['menu_name']; ?><br />
								<small><small>
									<?php echo $menu['menu_description']; ?>
									<!--<?php echo $text_category; ?>: <?php echo $menu['category_name']; ?>-->
								</small></small>
							</td>
							<td width="32%">
							<?php if (array_key_exists($menu['menu_id'], $has_options)) { ?>
								<?php foreach ($menu_options as $menu_option) { ?>
									<?php if (in_array($menu_option['option_id'], $has_options[$menu['menu_id']])) {?>
										<div class="radio text-xs">
											<label>	
												<input type="radio" name="menu_options[<?php echo $menu['menu_id']; ?>]" value="<?php echo $menu_option['option_id']; ?>" />
												<?php echo $menu_option['option_name']; ?>: <?php echo $menu_option['option_price']; ?>
											</label>	
										</div>
									<?php }?>
								<?php }?>
							<?php }?>
							</td>
							<td><div class="price"><?php echo $menu['menu_price']; ?></div></td>
							<td>
								<a class="add_cart" title="Add to order" onClick="addToCart('<?php echo $menu['menu_id']; ?>');"><span class="icon-add-cart"></span></a>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php } else { ?>
				<p><?php echo $text_empty; ?></p>
			<?php } ?>
		</div>
	</div>
</div>
<?php echo $footer; ?>