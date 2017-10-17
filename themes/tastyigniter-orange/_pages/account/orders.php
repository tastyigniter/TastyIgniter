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
                <div class="row">
                    <div class="order-lists col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th><?php echo lang('column_id'); ?></th>
                                    <th><?php echo lang('column_status'); ?></th>
                                    <th><?php echo lang('column_location'); ?></th>
                                    <th><?php echo lang('column_date'); ?></th>
                                    <th><?php echo lang('column_order'); ?></th>
                                    <th><?php echo lang('column_items'); ?></th>
                                    <th><?php echo lang('column_total'); ?></th>
                                    <th></th>
                                    <?php if (config_item('allow_reviews') !== '1') { ?>
                                        <th></th>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($orders) { ?>
                                    <?php foreach ($orders as $order) { ?>
                                        <tr>
                                            <td><a href="<?php echo $order['view']; ?>"><?php echo $order['order_id']; ?></a></td>
                                            <td><?php echo $order['status_name']; ?></td>
                                            <td><?php echo $order['location_name']; ?></td>
                                            <td><?php echo $order['order_time']; ?> - <?php echo $order['order_date']; ?></td>
                                            <td><?php echo $order['order_type']; ?></td>
                                            <td><?php echo $order['total_items']; ?></td>
                                            <td><?php echo $order['order_total']; ?></td>
                                            <td><a class="btn btn-primary re-order" title="<?php echo lang('text_reorder'); ?>" href="<?php echo $order['reorder']; ?>"><i class="fa fa-mail-reply"></i></a></td>
                                            <?php if (config_item('allow_reviews') !== '1') { ?>
                                                <td><a class="btn btn-warning leave-review" title="<?php echo lang('text_leave_review'); ?>" href="<?php echo $order['leave_review']; ?>"><i class="fa fa-heart"></i></a></td>
                                            <?php } ?>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="9"><?php echo lang('text_empty'); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="buttons col-xs-6 wrap-none">
                            <a class="btn btn-default" href="<?php echo $back_url; ?>"><?php echo lang('button_back'); ?></a>
                            <a class="btn btn-primary" href="<?php echo $new_order_url; ?>"><?php echo lang('button_order'); ?></a>
                        </div>

                        <div class="col-xs-6">
                            <div class="pagination-bar text-right">
                                <div class="links"><?php echo $pagination['links']; ?></div>
                                <div class="info"><?php echo $pagination['info']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo get_partial('content_right'); ?>
            <?php echo get_partial('content_bottom'); ?>
        </div>
    </div>
</div>
<?php echo get_footer(); ?>