<?php if ($categories) {?>
	<div id="searchText" class="form-group has-feedback has-search has-clear">
                <input type="text" name="catsearch" id="catsearch" class="form-control text-center search" placeholder="Search" >
                <span class="fa fa-search fa-2x form-control-feedback"></span>
                <span class="form-control-feedback form-control-clear fa fa-times fa-2x hidden"  onClick="clearSearch();"></span>
    </div>
	<div id="Container" class="menu-list">
		<?php $category_count = 1; ?>
		<?php foreach ($categories as $category_id => $category) { ?>
			<div class="menu-container mix <?php echo $category['slug']; ?>">
				<a class="menu-toggle visible-xs visible-sm collapsed" href="#<?php echo $category['slug']; ?>" role="button" data-toggle="collapse" data-parent=".menu-list" aria-expanded="<?php echo ($category_count === 1) ? 'true' : 'false'; ?>" aria-controls="<?php echo $category['slug']; ?>">
					<?php echo $category['name']; ?>
					<i class="fa fa-angle-down fa-2x fa-pull-right text-muted"></i>
					<i class="fa fa-angle-up fa-2x fa-pull-right text-muted"></i>
				</a>
				<div id="<?php echo $category['slug']; ?>" class="navbar-collapse collapse <?php echo ($category_count === 1) ? 'in' : ''; ?> wrap-none">
					<div class="menu-category">
						<h3 class="hidden-xs hidden-sm"><?php echo $category['name']; ?></h3>
						<p><?php echo $category['description']; ?></p>
						<?php if (!empty($category['image'])) { ?>
							<img class="img-responsive" src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>"/>
						<?php }?>
					</div>

					 <div class="menu-items">
						<?php if (isset($menus[$category_id]) AND !empty($menus[$category_id])) { ?>
							<?php foreach ($menus[$category_id] as $menu) { ?>

								<div id="menu<?php echo $menu['menu_id']; ?>" class="menu-item">
									<div class="menu-item-wrapper row">
										<?php if ($show_menu_images === '1' AND !empty($menu['menu_photo'])) { ?>
											<div class="menu-thumb col-xs-2 col-sm-2 wrap-none wrap-right">
												<img class="img-responsive img-thumbnail" alt="<?php echo $menu['menu_name']; ?>" src="<?php echo $menu['menu_photo']; ?>">
											</div>
										<?php } ?>

										<div class="menu-content <?php echo ($show_menu_images === '1' AND !empty($menu['menu_photo'])) ? 'col-xs-6 col-sm-6' : 'col-xs-8'; ?> wrap-none wrap-right">
											<span class="menu-name"><b><?php echo character_limiter($menu['menu_name'], 80); ?></b></span>
											<span class="menu-desc small">
												<?php echo character_limiter($menu['menu_description'], 120); ?>
											</span>
										</div>
										<div class="menu-right col-xs-4 wrap-none">
											<span class="menu-price"><?php echo $menu['menu_price']; ?></span>
											<span class="menu-button">
												<?php if ($menu['mealtime_status'] === '1' AND empty($menu['is_mealtime'])) { ?>
													<a class="btn btn-primary btn-cart add_cart disabled"><span class="fa fa-plus"></span></a>
												<?php } else if (isset($menu_options[$menu['menu_id']])) { ?>
													<a class="btn btn-primary btn-cart add_cart" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
														<span class="fa fa-plus"></span>
													</a>
												<?php } else { ?>
													<a class="btn btn-primary btn-cart add_cart" onClick="addToCart('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
														<span class="fa fa-plus"></span>
													</a>
												<?php } ?>
											</span>
											<?php if ($menu['mealtime_status'] === '1' AND empty($menu['is_mealtime'])) { ?>
												<div class="menu-mealtime text-danger"><?php echo sprintf(lang('text_mealtime'), $menu['mealtime_name'], $menu['start_time'], $menu['end_time']); ?></div>
											<?php }?>

											<?php if ($menu['special_status'] === '1' AND $menu['is_special'] === '1') { ?>
												<div class="menu-special"><?php echo $menu['end_days']; ?></div>
											<?php }?>
										</div>
									</div>
								</div>
							<?php } ?>
						<?php } else { ?>
							<p><?php echo lang('text_empty'); ?></p>
						<?php } ?>

						<div class="gap"></div>
						<div class="gap"></div>
					 </div>
				</div>
			</div>
			<?php $category_count++; ?>
		<?php } ?>
	</div>
<?php } else { ?>
	<p><?php echo lang('text_no_category'); ?></p>
<?php } ?>

<?php if (!empty($menu_total) AND $menu_total < 150) { ?>
	<div class="pager-list"></div>
<?php } else { ?>
	<div class="pagination-bar text-right">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div>
	</div>
<?php } ?>

<script type="text/javascript"><!--
	function clearSearch() {
		$('#catsearch').val('').trigger('propertychange').focus();
		resetFilter();
	}

    function resetFilter() {
         var find =$("#catsearch").val();
         var allSpan = $(".menu-name");

         var menuCount = 0;
         var oldCount;
         var count;
         var parent;
         var prevParent;

         allSpan.each(function( index ) {
            $( "p:contains('There are no menus in this category.')" ).parent().parent().parent().hide();
            $(this).closest('.menu-items').parent().parent().hide();
         });

         if (!find) {
            $( "p:contains('There are no menus in this category.')" ).parent().parent().parent().show();
         }

         allSpan.each(function( index ) {
             var spantext = $(this).text().toLowerCase();
             var findtext = find.toLowerCase();

             if(spantext.indexOf(findtext) != -1) {
                $(this).closest('.menu-items').parent().parent().show();
                $(this).closest('.menu-item').show();
             } else {
                $(this).closest('.menu-item').hide();
             }
         });
    }

	$( document ).ready(function() {
		var $myGroup = $('.menu-list');

	    $myGroup.on('show.bs.collapse','.collapse', function() {
	        $myGroup.find('.collapse.in').collapse('hide');

	    });
        
        $myGroup.on('shown.bs.collapse', function () {
            
            $('html, body').animate({
                scrollTop: $myGroup.find('.collapse.in').offset().top - 75
            }, 1);
	    });
            
        $("#catsearch").keyup(function() {
			resetFilter();
	});
    
        $('.has-clear input[type="text"]').on('input propertychange', function() {
	    	  var $this = $(this);
	    	  var visible = Boolean($this.val());
	    	  $this.siblings('.form-control-clear').toggleClass('hidden', !visible);
	    	  $this.siblings('.fa-search').toggleClass('hidden', visible);
		 }).trigger('propertychange');
	});
--></script>
