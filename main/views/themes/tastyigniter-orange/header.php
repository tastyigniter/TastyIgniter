<?php
	$this->template->setDocType('html5');
	$this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
	$this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'));
	$this->template->setMeta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1', 'type' => 'name'));
	$this->template->setLinkTag('images/favicon.ico', 'shortcut icon', 'image/ico');
	//$this->template->setLinkTag('js/themes/custom-theme/jquery-ui-1.10.4.custom.css');
	$this->template->setLinkTag('css/bootstrap.min.css');
	$this->template->setLinkTag('css/font-awesome.min.css');
	$this->template->setLinkTag('css/select2.css');
	$this->template->setLinkTag('css/select2-bootstrap.css');
	$this->template->setLinkTag('css/jquery.raty.css');
	$this->template->setLinkTag('css/stylesheet.css');

	$this->template->setScriptTag('js/jquery-1.11.2.min.js');
	$this->template->setScriptTag('js/jquery-ui-1.10.4.custom.js');
	$this->template->setScriptTag('js/bootstrap.min.js');
	$this->template->setScriptTag('js/select2.js');
	$this->template->setScriptTag('js/jquery.raty.js');
	$this->template->setScriptTag('js/common.js');

	/*$text_account 			= $this->lang->line('text_account');
	$text_edit_details 		= $this->lang->line('text_edit_details');
	$text_address 			= $this->lang->line('text_address');
	$text_orders 			= $this->lang->line('text_orders');
	$text_reservations 		= $this->lang->line('text_reservations');
	$text_logout 			= $this->lang->line('text_logout');*/

	$pages = $this->Pages_model->getPages();

	$body_class = '';
	if ($this->uri->rsegment(1) === 'menus') {
		$body_class = 'menus-page';
	}
?>
<?php echo $this->template->getDocType(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<?php echo $this->template->getMetas(); ?>
		<title><?php echo $this->template->getTitle(); ?></title>
		<?php echo $this->template->getLinkTags(); ?>
		<?php echo $this->template->getCustomStyle('css/stylesheet.php'); ?>
		<?php echo $this->template->getScriptTags(); ?>
		<script type="text/javascript">
			var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

			var js_site_url = function(str) {
				var strTmp = "<?php echo rtrim(site_url(), '/').'/'; ?>" + str;
			 	return strTmp;
			}

			var js_base_url = function(str) {
				var strTmp = "<?php echo base_url(); ?>" + str;
				return strTmp;
			}

			$(document).ready(function() {
				if ($('#notification > p').length > 0) {
					setTimeout(function() {
						$('#notification > p').slideUp(function() {
							$('#notification').empty();
						});
					}, 3000);
				}

				$('.alert').alert();
				$('.dropdown-toggle').dropdown();

				$('.rating-star').raty({
					score: function() {
						return $(this).attr('data-score');
					},
					scoreName: function() {
						return $(this).attr('data-score-name');
					},
					readOnly: function() {
						return $(this).attr('data-readonly') == 'true';
					},
					hints: ['Bad', 'Worse', 'Good', 'Average', 'Excellent'],
					starOff : 'fa fa-star-o',
					starOn : 'fa fa-star',
					cancel : false, half : false, starType : 'i'
				});

				$('#cart-info-dropdown').load(js_site_url('cart_module/cart_module #cart-info > *'), function() {
					$('.cart-dropdown-total').html($('#cart-info-dropdown .order-total').html());
				});
			});

			$(document).ready(function(){
			    $(window).resize(function() {
			        ellipses1 = $("#breadcrumb :nth-child(2)")
			        if ($("#breadcrumb a:hidden").length >0) {ellipses1.show()} else {ellipses1.hide()}

			        ellipses2 = $("#breadcrumb :nth-child(2)")
			        if ($("#breadcrumb a:hidden").length >0) {ellipses2.show()} else {ellipses2.hide()}

			    })
			});
		</script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="<?php echo $body_class; ?>">
		<div id="opaclayer" onclick="closeReviewBox();"></div>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <header id="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-6">
						<div id="social-widget-2" class="">
							<ul class="social-icons">
								<li><a href="#" data-original-title="Facebook" data-placement="bottom" data-rel="tooltip" target="_blank"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#" data-original-title="Twitter" data-placement="bottom" data-rel="tooltip" target="_blank"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#" data-original-title="Google" data-placement="bottom" data-rel="tooltip" target="_blank"><i class="fa fa-google-plus"></i></a></li>
								<li><a href="#" data-original-title="Skype" data-placement="bottom" data-rel="tooltip" target="_blank"><i class="fa fa-skype"></i></a></li>
								<li><a href="#" data-original-title="Linkedin" data-placement="bottom" data-rel="tooltip" target="_blank"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#" data-original-title="Vimeo" data-placement="bottom" data-rel="tooltip" target="_blank"><i class="fa fa-youtube"></i></a></li>
							</ul>
							<div style="clear:both;"></div>
						</div>
                    </div>
                    <div class="col-sm-6 col-md-6">
                        <div class="cart-dropdown dropdown text-right">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-shopping-cart"></i> (5 items) in your cart (<span class="cart-dropdown-total"></span>)</a>
							<div class="dropdown-menu dropdown-menu-right text-left">
								<div id="cart-info-dropdown"></div>
								<br >
								<a class="btn btn-primary" href="#">Cart&nbsp;&nbsp;<i class="fa fa-forward"></i></a>
								<span class="cart-total">Total: <span><span class="cart-dropdown-total"></span></span></span>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
		<header id="main-header">
			<div class="container">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
						<button type="button" class="btn-navbar navbar-toggle" data-toggle="collapse" data-target="#main-header-menu-collapse">
							<i class="fa fa-align-justify"></i>
						</button>
                        <div class="logo">
							<a class="" href="<?php echo rtrim(site_url(), '/').'/'; ?>">
								<img alt="<?php echo $this->config->item('site_name'); ?>" src="<?php echo root_url('assets/images/' .$this->config->item('site_logo')) ?>" height="40">
							</a>
						</div>
					</div>
                    <div class="col-sm-8 col-md-9">
						<div class="collapse navbar-collapse" id="main-header-menu-collapse">
							<ul class="nav navbar-nav navbar-right">
								<li><a href="<?php echo site_url(); ?>">Home</a></li>
								<li><a href="<?php echo site_url('menus'); ?>">Menu</a></li>

								<?php if ($this->config->item('reservation_mode') === '1') { ?>
									<li><a href="<?php echo site_url('reserve_table'); ?>">Reservation</a></li>
								<?php } ?>

								<?php if ($this->customer->isLogged()) { ?>
									<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" id="dropdownLabel1">My Account <span class="caret"></span></a>
										<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownLabel1">
											<li class="dropdown-header">Links</li>
											<li><a role="presentation" href="<?php echo site_url('account'); ?>">Main</a></li>
											<li><a role="presentation" href="<?php echo site_url('details'); ?>">Details</a></li>
											<li><a role="presentation" href="<?php echo site_url('address'); ?>">Address</a></li>
											<li><a role="presentation" href="<?php echo site_url('orders'); ?>">Orders</a></li>

											<?php if ($this->config->item('reservation_mode') === '1') { ?>
												<li><a role="presentation" href="<?php echo site_url('reservations'); ?>">Reservation</a></li>
											<?php } ?>

											<li><a role="presentation" href="<?php echo site_url('logout'); ?>" >Logout</a></li>
										</ul>
									</li>
								<?php } else { ?>
									<li><a href="<?php echo site_url('login'); ?>">My Account</a></li>
								<?php } ?>

								<?php //$this->template->navigationList('header'); ?>
								<?php if ($pages) { ?>
									<?php foreach ($pages as $page) { ?>
										<?php if ($page['navigation'] === 'header') { ?>
											<li><a href="<?php echo site_url('pages?page_id='.$page['page_id']); ?>"><?php echo $page['name']; ?></a></li>
										<?php } ?>
									<?php } ?>
								<?php } ?>

							</ul>
						</div>
					</div>
				</div>
			</div>
		</header>

		<div id="page-wrapper" class="content-area">
			<?php if (($page_heading = $this->template->getHeading()) !== '') { ?>
	            <div id="heading">
	                <div class="container">
	                    <div class="row">
	                        <div class="col-md-12">
	                            <div class="heading-content">
	                                <h2><?php echo $page_heading; ?></h2>
									<div class="row">
										<?php echo $this->template->getBreadcrumb(); ?>
									</div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
			<?php } ?>

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