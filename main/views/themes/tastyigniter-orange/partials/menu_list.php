<?php if ($categories) {?>
    <div id="Container" class="menu-list">
        <?php foreach ($categories as $category_id => $category) { ?>
            <?php $category_name = strtolower(str_replace(' ', '-', $category['name'])); ?>
            <div class="menu-container mix <?php echo $category_name; ?>">
                <a class="menu-toggle visible-xs" role="button" data-toggle="collapse" href="#<?php echo $category_name; ?>" aria-expanded="false" aria-controls="<?php echo $category_name; ?>">
                    <?php echo $category['name']; ?>
                    <i class="fa fa-angle-down fa-pull-right"></i>
                    <i class="fa fa-angle-up fa-pull-right"></i>
                </a>
                <div id="<?php echo $category_name; ?>" class="navbar-collapse collapse">
                    <div class="menu-category">
                        <h3 class="hidden-xs"><?php echo $category['name']; ?></h3>
                        <p><?php echo $category['description']; ?></p>
                        <?php if (!empty($category['image'])) { ?>
                            <img src="<?php echo $category['image']; ?>" alt=""/>
                        <?php }?>
                    </div>

                     <div class="menu-items">
                        <?php if (isset($menus[$category_id]) AND !empty($menus[$category_id])) { ?>
                            <?php foreach ($menus[$category_id] as $menu) { ?>

                                <div id="menu<?php echo $menu['menu_id']; ?>" class="menu-item">
                                    <div class="menu-item-wrapper row">
                                        <?php if ($show_menu_images === '1') { ?>
                                            <div class="menu-thumb col-xs-3 col-sm-2 wrap-none wrap-left">
                                                <img class="img-responsive img-thumbnail" alt="<?php echo $menu['menu_name']; ?>" src="<?php echo $menu['menu_photo']; ?>">
                                            </div>
                                        <?php } ?>

                                        <div class="menu-content <?php echo ($show_menu_images === '1') ? 'col-xs-6 col-sm-7' : 'col-xs-9'; ?>">
                                            <span class="menu-name"><b><?php echo $menu['menu_name']; ?></b></span>
                                            <span class="menu-desc small">
                                                <?php echo $menu['menu_description']; ?>
                                            </span>
                                        </div>
                                        <div class="menu-right col-xs-3 wrap-none wrap-right">
                                            <span class="menu-price visible-xs-inline-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block"><?php echo $menu['menu_price']; ?></span>
                                            <span class="menu-button visible-xs-inline-block visible-sm-inline-block visible-md-inline-block visible-lg-inline-block">
                                                <?php if (isset($menu_options[$menu['menu_id']])) { ?>
                                                    <a class="btn btn-primary btn-cart add_cart" onClick="openMenuOptions('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
                                                        <span class="fa fa-plus"></span>
                                                    </a>
                                                <?php } else { ?>
                                                    <a class="btn btn-primary btn-cart add_cart" title="<?php echo lang('button_add'); ?>" onClick="addToCart('<?php echo $menu['menu_id']; ?>', '<?php echo $menu['minimum_qty']; ?>');">
                                                        <span class="fa fa-plus"></span>
                                                    </a>
                                                <?php } ?>
                                            </span>
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