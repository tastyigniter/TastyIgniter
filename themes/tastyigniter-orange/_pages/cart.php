<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div class="wrap-all">
    <div class="cart-buttons wrap-bottom">
        <div class="center-block">
            <a class="btn btn-default btn-block btn-md" href="<?php echo restaurant_url().'/#local-menus'; ?>"><?php echo lang('button_go_back') ?></a>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php echo $cart; ?>
</div>
<?php echo get_partial('content_bottom'); ?>
<?php echo get_footer(); ?>