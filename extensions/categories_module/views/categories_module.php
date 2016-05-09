<div id="category-box-affix" <?php echo $fixed_cart; ?>>
	<div id="category-box" class="module-box hidden-xs">
		<div class="panel panel-default">
			<ul class="list-group list-group-responsive">
				<?php $data_filter = (!empty($menu_total) AND $menu_total > 500) ? 'class=""' : 'class="filter" data-filter="all"'; ?>
				<li class="list-group-item">
					<a <?php echo $data_filter; ?> <?php echo (!empty($menu_total) AND $menu_total > 500) ? 'href="'.site_url('menus').'"' : ''; ?>>
						<i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo lang('text_show_all'); ?>
					</a>
				</li>

				<?php foreach ($categories as $category) { ?>
					<?php $category_selector = '.'.strtolower(str_replace(' ', '-', str_replace('&', '_', $category['category_name'])));
					if (( ! empty($menu_total) AND $menu_total > 500)) {
						$loop_filter = ($category['category_id'] === $category_id) ? 'class=""' : 'class="active"';
					} else {
						$loop_filter = 'class="filter" data-filter="'.$category_selector.'"';
					} ?>

					<li class="list-group-item">
						<a <?php echo $loop_filter; ?> <?php echo (!empty($menu_total) AND $menu_total > 500) ? 'href="'.$category['href'].'"' : ''; ?>><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $category['category_name']; ?></a>

						<?php if (!empty($category['children'])) { ?>
							<ul class="list-group list-group-responsive">
								<?php foreach ($category['children'] as $child) { ?>
									<?php

									$child_category_selector = '.'.strtolower(str_replace(' ', '-', str_replace('&', '_', $child['category_name'])));
									if (( ! empty($menu_total) AND $menu_total > 500)) {
										$child_loop_filter = ($child['category_id'] === $category_id) ? 'class=""' : 'class="active"';
									} else {
										$child_loop_filter = 'class="filter" data-filter="'.$child_category_selector.'"';
									} ?>

									<li class="list-group-item">
										<a <?php echo $child_loop_filter; ?> <?php echo (!empty($menu_total) AND $menu_total > 500) ? 'href="'.$child['href'].'"' : ''; ?>><i class="fa fa-angle-right"></i>&nbsp;&nbsp;<?php echo $child['category_name']; ?></a>
									</li>
								<?php } ?>
							</ul>
						<?php } ?>

					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('#category-box-collapse .list-group-item').on('click', function() {
			if ($('#category-box-collapse.in').length > 0) $('#category-box-collapse').collapse('toggle');
		});
	});
//--></script>
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
						alert('<?php echo lang('text_no_match'); ?>');
						$container.mixItUp('filter', 'all');
					},
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