<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>

<?php if ($this->alert->get()) { ?>
	<div id="notification">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php echo $this->alert->display(); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div id="page-content">
    <div class="container top-spacing">
        <div class="row">
            <?php echo get_partial('content_left'); ?>
            <?php
            if (partial_exists('content_left') AND partial_exists('content_right')) {
                $class = "col-sm-6 col-md-6";
            } else if (partial_exists('content_left') OR partial_exists('content_right')) {
                $class = "col-sm-9 col-md-9";
            } else {
                $class = "col-md-12";
            }
            ?>

            <div class="content-wrap <?php echo $class; ?>">
                <form method="POST" accept-charset="utf-8" action="<?php echo current_url(); ?>">
                    <div class="order-lists row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-none">
                                    <tr>
                                        <td style="width:20%;"><b><?php echo lang('column_id'); ?>:</b></td>
                                        <td><?php echo $order_id; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo lang('column_date'); ?>:</b></td>
                                        <td><?php echo $order_time; ?> - <?php echo $order_date; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo lang('column_date_added'); ?>:</b></td>
                                        <td><?php echo $date_added; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo lang('column_order'); ?>:</b></td>
                                        <td><?php echo ($order_type === '1') ? lang('text_delivery') : lang('text_collection'); ?></td>
                                    </tr>
                                    <?php if ($order_type === '1') { ?>
                                        <tr>
                                            <td><b><?php echo lang('column_delivery'); ?>:</b></td>
                                            <td><?php echo $delivery_address; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td><b><?php echo lang('column_payment'); ?>:</b></td>
                                        <td><?php echo $payment; ?></td>
                                    </tr>
                                    <tr>
                                        <td><b><?php echo lang('column_location'); ?>:</b></td>
                                        <td><?php echo $location_name; ?><br /><?php echo $location_address; ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="text-center">
                                <h4><?php echo lang('text_order_menus'); ?></h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th style="width:7%"></th>
                                        <th class="text-left" width="65%"><?php echo lang('column_menu_name'); ?></th>
                                        <th class="text-right"><?php echo lang('column_menu_price'); ?></th>
                                        <th class="text-right"><?php echo lang('column_menu_subtotal'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($menus as $menu) { ?>
                                        <tr id="<?php echo $menu['id']; ?>">
                                            <td><?php echo $menu['qty']; ?> x</td>
                                            <td class="text-left"><?php echo $menu['name']; ?><br />
                                                <?php if (!empty($menu['options'])) { ?>
                                                    <div><small><?php echo lang('text_plus'); ?><?php echo $menu['options']; ?></small></div>
                                                <?php } ?>
                                                <?php if (!empty($menu['comment'])) { ?>
                                                    <div><small><b><?php echo $menu['comment']; ?></b></small></div>
                                                <?php } ?>
                                            </td>
                                            <td class="text-right"><?php echo $menu['price']; ?></td>
                                            <td class="text-right"><?php echo $menu['subtotal']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr><td class="thick-line" colspan="4"></td></tr>
                                    <?php foreach ($totals as $total) { ?>
                                        <tr>
                                            <td class="no-line" colspan="2"></td>
                                            <?php if ($total['code'] === 'order_total') { ?>
                                                <td class="text-right thick-line"><b><?php echo $total['title']; ?></b></td>
                                                <td class="text-right thick-line"><b><?php echo $total['value']; ?></b></td>
                                            <?php } else { ?>
                                                <td class="text-right no-line"><?php echo $total['title']; ?></td>
                                                <td class="text-right no-line"><?php echo $total['value']; ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="buttons">
                                <a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
                                <a class="btn btn-primary" href="<?php echo $reorder_url; ?>"><?php echo lang('button_reorder'); ?></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php echo get_partial('content_right'); ?>
            <?php echo get_partial('content_bottom'); ?>
        </div>
    </div>
</div>
<?php echo get_footer(); ?>