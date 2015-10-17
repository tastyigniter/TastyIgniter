<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
    <div class="container">
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

            <div class="<?php echo $class; ?> top-spacing">
                <div class="row location-list">
                    <?php if ($locations) {?>
                        <?php foreach ($locations as $location) { ?>
                            <div class="panel panel-local">
                                <div class="panel-body">
                                    <div class="box-one col-md-4">
                                        <img class="img-responsive pull-left" src="<?php echo $location['location_image']; ?>">
                                        <dl>
                                            <dd><h4><?php echo $location['location_name']; ?></h4></dd>
                                            <dd>
                                                <div class="rating rating-sm text-muted">
                                                    <span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star-half-o"></span><span class="fa fa-star-o"></span>
                                                    <span><?php echo $location['total_reviews']; ?></span>
                                                </div>
                                            </dd>
                                            <dd><span class="text-muted"><?php echo $location['address']; ?></span></dd>
                                        </dl>
                                    </div>
                                    <div class="col-md-3">
                                        <dl>
                                            <dd class="text-info">
                                                <?php if ($location['opening_status'] === '1') { ?>
                                                    <?php if ($location['open_24_hour'] === TRUE) { ?>
                                                        <span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo lang('text_24h'); ?></span>
                                                    <?php } else if (empty($opening_status)) { ?>
                                                        <span class="fa fa-clock-o"></span>&nbsp;&nbsp;<span><?php echo $location['opening_time']; ?> - <?php echo $location['closing_time']; ?></span>
                                                    <?php } ?>
                                                <?php } ?>
                                            </dd>
                                            <h4><?php echo $location['open_or_closed']; ?></h4>
                                        </dl>
                                    </div>
                                    <div class="col-md-3">
                                        <dl>
                                            <dd><?php echo $location['offers']; ?></dd>
                                            <dd><span class="small"><b><?php echo lang('text_delivery_time'); ?>:</b> <?php echo $location['delivery_time']; ?></span></dd>
                                            <dd><span class="small"><b><?php echo lang('text_collection_time'); ?>:</b> <?php echo $location['collection_time']; ?></span></dd>
<!--                                            <dd><span class="small"><b>--><?php //echo lang('text_last_order_time'); ?><!--:</b> --><?php //echo $location['last_order_time']; ?><!--</span></dd>-->
                                        </dl>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <dl>
                                            <dd><a class="btn btn-primary" href="<?php echo $location['href']; ?>"><?php echo lang('button_view_menu'); ?></a></dd>
                                        </dl>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p><?php echo lang('text_empty'); ?></p>
                    <?php } ?>
                </div>

            </div>
            <?php echo get_partial('content_right', 'col-sm-3'); ?>
            <?php echo get_partial('content_bottom'); ?>
        </div>
    </div>
</div>
<?php echo get_footer(); ?>