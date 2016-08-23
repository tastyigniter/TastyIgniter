<div id="featured-menu-box" class="module-box">
	<div class="row">
		<div class="col-md-12">
			<div class="heading-section bottom-spacing-20">
				<h2><?php echo $featured_menu_title; ?></h2>
				<span class="under-heading"></span>
			</div>
		</div>
	</div>
	<div class="row">
		<?php foreach($featured_menus as $menu_id => $menu) { ?>
			<div class="col-xs-6 col-sm-6 col-md-<?php echo round(12/$items_per_row); ?>">
				<div class="featured-menu">
					<div class="menu-thumb">
						<img src="<?php echo $menu['menu_photo']; ?>" alt="" />
					</div>
					<div class="menu-content">
						<div class="content-show">
							<h4><?php echo $menu['menu_name']; ?></h4>
							<span><?php echo currency_format($menu['menu_price']); ?></span>
						</div>
						<div class="content-hide">
							<p><?php echo $menu['menu_description']; ?></p>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
