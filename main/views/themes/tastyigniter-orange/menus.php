<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h2>Hungry ?</h2>
                    <span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<?php echo $content_left; ?>
			<?php
				if (!empty($content_left) AND !empty($content_right)) {
					$class = "col-sm-6 col-md-6";
				} else if (!empty($content_left) OR !empty($content_right)) {
					$class = "col-sm-9 col-md-9";
				} else {
					$class = "col-md-12";
				}
			?>

			<div class="<?php echo $class; ?>">
				<?php if ($menus) {?>
					<div class="col-md-12">
						<div class="view-controls-list" id="viewcontrols">
							<div class="btn-group" role="group">
								<a class="btn btn-default gridview"><i class="fa fa-th"></i></a>
								<a class="btn btn-default listview active"><i class="fa fa-list"></i></a>
							</div>
						</div>
					</div>

					<div id="Container" class="col-md-12 menu-items wrap-none">
						<?php foreach ($menus as $menu) { ?>
							<div id="menu<?php echo $menu['menu_id']; ?>" class="col-sm-3 mix menu-item <?php echo strtolower(str_replace(' ', '-', $menu['category_name'])); ?>">

								<div class="menu-item-wrapper">
									<?php if ($show_menu_images) { ?>
										<div class="menu-thumb">
											<img class="img-responsive img-thumbnail" alt="<?php echo $menu['menu_name']; ?>" src="<?php echo $menu['menu_photo']; ?>">
										</div>
									<?php } ?>

									<div class="menu-caption">
										<span class="menu-name"><b><?php echo $menu['menu_name']; ?></b></span>
										<span class="menu-desc small">
											<?php echo $menu['menu_description']; ?><br />
											<span class="menu-category"><b><?php echo $menu['category_name']; ?></b></span>
										</span>

									</div>
									<div class="menu-more">
										<span class="menu-price"><?php echo $menu['menu_price']; ?></span>
										<div class="menu-group-btn">
											<?php if (isset($menu_options[$menu['menu_id']])) { ?>
												<a class="btn btn-cart add_cart" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>');">
													<span class="fa fa-plus"></span>
													<span class="btn-cart-text"><?php echo $button_add; ?></span>
												</a>
											<?php } else { ?>
												<a class="btn btn-cart add_cart" onClick="addToCart('<?php echo $menu['menu_id']; ?>');">
													<span class="fa fa-plus"></span>
													<span class="btn-cart-text"><?php echo $button_add; ?></span>
												</a>
											<?php } ?>

											<!--<a class="btn btn-review review_menu">
												<span class="fa fa-heart"></span>
												<span class="btn-review-text"><?php echo $button_review; ?></span>
											</a>-->
										</div>
										<?php if ($menu['is_special'] === '1') { ?>
											<div class="menu-special"><?php echo $menu['end_days']; ?></div>
										<?php }?>
									</div>
								</div>
							</div>
						<?php } ?>

						<div class="gap"></div>
						<div class="gap"></div>
					</div>
				<?php } else { ?>
					<p><?php echo $text_empty; ?></p>
				<?php } ?>

				<div class="col-md-12">
					<?php if (!empty($menu_total) AND $menu_total < 150) { ?>
						<div class="pager-list"></div>
					<?php } else { ?>
						<div class="pagination-bar text-right">
							<div class="links"><?php echo $pagination['links']; ?></div>
							<div class="info"><?php echo $pagination['info']; ?></div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php echo $content_right; ?>
			<?php echo $content_bottom; ?>
		</div>
	</div>
</div>
<script src="<?php echo base_url("main/views/themes/tastyigniter-orange/js/jquery.mixitup.js"); ?>"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$(function(){

		var layout = 'list', // Store the current layout as a variable
		  $container = $('#Container'), // Cache the MixItUp container
		  $changeLayout = $('#viewcontrols .btn'); // Cache the changeLayout button
		  $listButton = $('#viewcontrols .listview'); // Cache the list button
		  $gridButton = $('#viewcontrols .gridview'); // Cache the grid button

		// Instantiate MixItUp with some custom options:

		$container.mixItUp({
			animation: {
				animateChangeLayout: true, // Animate the positions of targets as the layout changes
				animateResizeTargets: true, // Animate the width/height of targets as the layout changes
				effects: 'fade rotateX(-40deg) translateZ(-100px)'
			},
			layout: {
				containerClass: 'list' // Add the class 'list' to the container on load
			},
		    controls: { enable: true },
		    callbacks: {
		      	onMixFail: function(){
		        	alert('No items were found matching the selected filters.');
		        	$container.mixItUp('filter', 'all');
		      	}
		    }
		});

	  // MixItUp does not provide a default "change layout" button, so we need to make our own and bind it with a click handler:

	  $changeLayout.on('click', function() {

	    // If the current layout is a list, change to grid:

	    if(layout == 'list'){
	      layout = 'grid';

	      $listButton.removeClass('active'); // Update the list button as active
	      $gridButton.addClass('active'); // Update the grid button as active

	      $container.mixItUp('changeLayout', {
	        containerClass: layout // change the container class to "grid"
	      });

	    // Else if the current layout is a grid, change to list:

	    } else {
	      layout = 'list';

	      $listButton.addClass('active'); // Update the list button as active
	      $gridButton.removeClass('active'); // Update the grid button as active
	      //$changeLayout.text('Grid'); // Update the button  as active

	      $container.mixItUp('changeLayout', {
	        containerClass: layout // Change the container class to 'list'
	      });
	    }
	  });

	});

});
//--></script>
<?php echo $footer; ?>