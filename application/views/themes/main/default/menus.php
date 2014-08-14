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

<div class="row margin-top">
	<ul class="nav nav-tabs menus-tabs text-sm" role="tablist">
		<li class="active"><a href="<?php echo site_url('main/menus'); ?>">Menu</a></li>
		<li><a href="<?php echo site_url('main/local'); ?>">Info</a></li>
		<li><a href="<?php echo site_url('main/local/reviews'); ?>">Reviews</a></li>
	</ul>
</div>

<div class="row content">
	<?php echo $content_right; ?><?php echo $content_left; ?>

	<div class="col-md-6 page-content">
		<div class="wrap-horizontal">

			<?php if ($menus) {?>
			<div class="table-responsive">
				<table class="table table-none table-hover menus-table">
					<tbody>
						<?php foreach ($menus as $menu) { ?>
						<?php if (isset($menu_options[$menu['menu_id']])) { ?>	
							<tr id="menu<?php echo $menu['menu_id']; ?>" class="menu-item" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>');">
						<?php } else { ?>
							<tr id="menu<?php echo $menu['menu_id']; ?>" class="menu-item" onClick="addToCart('<?php echo $menu['menu_id']; ?>');">
						<?php } ?>
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

								<span class="text-md text-muted"><b><?php echo $menu['menu_name']; ?></b></span><br />
								<small><small>
									<?php echo $menu['menu_description']; ?>
									<!--<?php echo $text_category; ?>: <?php echo $menu['category_name']; ?>-->
								</small></small>
							</td>
							<td class="text-center"><div class="price"><?php echo $menu['menu_price']; ?></div></td>
							<td class="text-right">
								<?php if (isset($menu_options[$menu['menu_id']])) { ?>	
									<a class="btn btn-cart add_cart" title="Add to order" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>');">&plus;</a>
								<?php } else { ?>
									<a class="btn btn-cart add_cart" title="Add to order" onClick="addToCart('<?php echo $menu['menu_id']; ?>');">&plus;</a>
								<?php } ?>
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