<?php echo get_header(); ?>
<?php echo get_partial('content_top'); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h2><?php echo $text_place_order; ?></h2>
					<span class="under-heading"></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">
                <div class="location-search">
					<span><?php echo $text_postcode; ?></span>
					<form id="location-form" method="POST" action="<?php echo $local_action; ?>" role="form">
						<div class="col-xs-12 col-sm-6 col-md-4 center-block">
							<div class="input-group postcode-group">
								<input type="text" id="postcode" class="form-control text-center postcode-control input-lg" name="postcode" value="<?php echo $postcode; ?>">
								<a id="search" class="input-group-addon btn btn-success" onclick="$('form').submit();"><?php echo $text_find; ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>

	    <div id="features">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading-section">
                            <h2>Why Choose TastyIgniter</h2>
                            <span class="under-heading"></span>
                        </div>
                    </div>
                </div>
		        <div class="row">
		            <div class="col-md-3 col-sm-6">
		                <div class="feature-item">
		                    <div class="icon">
		                        <i class="fa fa-pencil"></i>
		                    </div>
		                    <h4>Make an order</h4>
		                    <p>Sed egestas tincidunt mollis. Suspendisse rhoncus vitae enim et faucibus. Ut dignissim nec arcu nec hendrerit. Sed arcu  sagittis vel diam in, malesuada malesuada risus. Aenean a sem leoneski.</p>
		                </div>
		            </div>
		            <div class="col-md-3 col-sm-6">
		                <div class="feature-item">
		                    <div class="icon">
		                        <i class="fa fa-bullhorn"></i>
		                    </div>
		                    <h4>Promotions</h4>
		                    <p>Sed egestas tincidunt mollis. Suspendisse rhoncus vitae enim et faucibus. Ut dignissim nec arcu nec hendrerit. Sed arcu  sagittis vel diam in, malesuada malesuada risus. Aenean a sem leoneski.</p>
		                </div>
		            </div>
		            <div class="col-md-3 col-sm-6">
		                <div class="feature-item">
		                    <div class="icon">
		                        <i class="fa fa-bell"></i>
		                    </div>
		                    <h4>Ready to Serve</h4>
		                    <p>Sed egestas tincidunt mollis. Suspendisse rhoncus vitae enim et faucibus. Ut dignissim nec arcu nec hendrerit. Sed arcu  sagittis vel diam in, malesuada malesuada risus. Aenean a sem leoneski.</p>
		                </div>
		            </div>
		            <div class="col-md-3 col-sm-6">
		                <div class="feature-item">
		                    <div class="icon">
		                        <i class="fa fa-heart"></i>
		                    </div>
		                    <h4>Satisfaction</h4>
		                    <p>Sed egestas tincidunt mollis. Suspendisse rhoncus vitae enim et faucibus. Ut dignissim nec arcu nec hendrerit. Sed arcu  sagittis vel diam in, malesuada malesuada risus. Aenean a sem leoneski.</p>
		                </div>
		            </div>
		        </div>
		    </div>
	    </div>

        <div id="menu-specials">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="heading-section">
                            <h2>Menu Specials</h2>
                            <span class="under-heading"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="menu-special">
                            <div class="menu-thumb">
                                <img src="images/blogpost1.jpg" alt="" />
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
                                <img src="images/menupost2.jpg" alt="" />
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
                                <img src="images/menupost3.jpg" alt="" />
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
</div>
<?php echo get_footer(); ?>