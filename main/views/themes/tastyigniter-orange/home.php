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
	<div class="container">
	    <div id="order-steps" class="top-spacing">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-pencil"></i>
                        </div>
                        <h4><?php echo lang('text_step_one'); ?></h4>
                        <p><?php echo lang('text_step_search'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-bullhorn"></i>
                        </div>
                        <h4><?php echo lang('text_step_two'); ?></h4>
                        <p><?php echo lang('text_step_choose'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-bell"></i>
                        </div>
                        <h4><?php echo lang('text_step_three'); ?></h4>
                        <p><?php echo lang('text_step_pay'); ?></p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="step-item">
                        <div class="icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h4><?php echo lang('text_step_four'); ?></h4>
                        <p><?php echo lang('text_step_enjoy'); ?></p>
                    </div>
                </div>
            </div>
	    </div>

        <div id="menu-specials">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading-section bottom-spacing-20">
                        <h2><?php echo lang('heading_special'); ?></h2>
                        <span class="under-heading"></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="menu-special">
                        <div class="menu-thumb">
                            <img src="<?php echo image_url('data/no_photo.png'); ?>" alt="" />
                        </div>
                        <div class="menu-content">
                            <div class="content-show">
                                <h4><a href="#">Summer Sandwich</a></h4>
                                <span>29 Sep 2084</span>
                            </div>
                            <div class="content-hide">
                                <p>Sed egestas tincidunt mollis. Suspendisse rhoncus vitae enim et faucibus. Ut dignissim nec arcu nec hendrerit. Sed arcu odio, sagittis vel diam in, malesuada malesuada risus. Aenean a sem leo. Nam ultricies dolor et mi tempor, non pulvinar felis sollicitudin.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="menu-special">
                        <div class="menu-thumb">
                            <img src="<?php echo image_url('data/no_photo.png'); ?>" alt="" />
                        </div>
                        <div class="menu-content">
                            <div class="content-show">
                                <h4><a href="#">New Great Taste</a></h4>
                                <span>23 Sep 2084</span>
                            </div>
                            <div class="content-hide">
                                <p>Sed egestas tincidunt mollis. Suspendisse rhoncus vitae enim et faucibus. Ut dignissim nec arcu nec hendrerit. Sed arcu odio, sagittis vel diam in, malesuada malesuada risus. Aenean a sem leo. Nam ultricies dolor et mi tempor, non pulvinar felis sollicitudin.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="menu-special">
                        <div class="menu-thumb">
                            <img src="<?php echo image_url('data/no_photo.png'); ?>" alt="" />
                        </div>
                        <div class="menu-content">
                            <div class="content-show">
                                <h4><a href="#">Spicy Pizza</a></h4>
                                <span>14 Sep 2084</span>
                            </div>
                            <div class="content-hide">
                                <p>Sed egestas tincidunt mollis. Suspendisse rhoncus vitae enim et faucibus. Ut dignissim nec arcu nec hendrerit. Sed arcu odio, sagittis vel diam in, malesuada malesuada risus. Aenean a sem leo. Nam ultricies dolor et mi tempor, non pulvinar felis sollicitudin.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<?php echo get_footer(); ?>