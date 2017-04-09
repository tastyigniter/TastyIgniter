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
	<div class="container top-spacing-10">
	    <div class="content-wrap">
            <div id="order-steps" class="row">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-search"></i>
                        </div>
                        <h4><?php echo lang('text_step_one'); ?></h4>
                        <p><?php echo lang('text_step_search'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-mouse-pointer"></i>
                        </div>
                        <h4><?php echo lang('text_step_two'); ?></h4>
                        <p><?php echo lang('text_step_choose'); ?></p>
                    </div>
                </div>
                <div class="clearfix visible-xs"></div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-credit-card"></i>
                        </div>
                        <h4><?php echo lang('text_step_three'); ?></h4>
                        <p><?php echo lang('text_step_pay'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h4><?php echo lang('text_step_four'); ?></h4>
                        <p><?php echo lang('text_step_enjoy'); ?></p>
                    </div>
                </div>
            </div>

            <?php echo get_partial('content_bottom'); ?>
        </div>
	</div>
</div>
<?php echo get_footer(); ?>