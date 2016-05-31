<div id="category-box-affix" <?php echo $fixed_categories; ?>>
	<div id="category-box" class="module-box">
		<div class="panel panel-default">
			<?php echo $category_tree; ?>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('#category-box-collapse .list-group-item').on('click', function() {
			if ($('#category-box-collapse.in').length > 0) $('#category-box-collapse').collapse('toggle');
		});

		$(window).bind("load resize", function() {
			var sideBarWidth = $('#content-left .side-bar').width();
			$('#category-box-affix').css('width', sideBarWidth);
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