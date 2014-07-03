<?php
	$this->load->library('customer');
	$this->load->model('Pages_model');

	$this->template->setTemplate('main/default');
	$this->template->setDocType('html5');
	$this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
	$this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'));
	$this->template->setMeta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1', 'type' => 'name'));
	$this->template->setLinkTag('images/favicon.ico', 'shortcut icon', 'image/ico');
	$this->template->setLinkTag('js/themes/custom-theme/jquery-ui-1.10.4.custom.css');
	$this->template->setLinkTag('css/bootstrap.css');
	$this->template->setLinkTag('css/bootstrap-select.css');
	$this->template->setLinkTag('css/font-awesome.css');
	$this->template->setLinkTag('css/stylesheet.css');
	$this->template->setLinkTag('css/jquery.fancybox.css');
	$this->template->setScriptTag('js/jquery-1.10.2.js');
	$this->template->setScriptTag('js/jquery-ui-1.10.4.custom.js');
	$this->template->setScriptTag('js/bootstrap.js');
	$this->template->setScriptTag('js/bootstrap-select.js');
	$this->template->setScriptTag('js/common.js');
	
	$doctype			= $this->template->getDocType();
	$metas				= $this->template->getMetas();
	$link_tags 			= $this->template->getLinkTags();
	$script_tags 		= $this->template->getScriptTags();
	$title 				= $this->template->getTitle();
	$heading 			= $this->template->getHeading();
	$site_logo 			= base_url('assets/img/' .$this->config->item('site_logo'));
	$site_name 			= $this->config->item('site_name');
	$site_url 			= site_url();
	$base_url 			= base_url();
	$islogged 			= $this->customer->islogged();

	/*$text_account 			= $this->lang->line('text_account');
	$text_edit_details 		= $this->lang->line('text_edit_details');
	$text_address 			= $this->lang->line('text_address');
	$text_orders 			= $this->lang->line('text_orders');
	$text_reservations 		= $this->lang->line('text_reservations');
	$text_logout 			= $this->lang->line('text_logout');*/

	$pages = $this->Pages_model->getPages();
?>
<?php echo $doctype ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<?php echo $metas ?>
		<title><?php echo $title ?></title>
		<?php echo $link_tags ?>
		<?php echo $script_tags ?>
		<script type="text/javascript">
			var alert_close = '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';

			var js_site_url = function(str) {
				var strTmp = "<?php echo $site_url; ?>" + str;
			 	return strTmp;
			}

			var js_base_url = function(str) {
				var strTmp = "<?php echo $base_url; ?>" + str;
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
			});
		</script>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
	<div id="opaclayer" onclick="closeReviewBox();"></div>
	<div class="header">
		<nav class="navbar navbar-default" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="" href="<?php echo $site_url; ?>"><img alt="<?php echo $site_name; ?>" src="<?php echo $site_logo; ?>" height="40"></a>
				</div>
		
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<li><a href="<?php echo site_url(); ?>">Home</a></li>
						<li><a href="<?php echo site_url('main/menus'); ?>">View Menu</a></li>
						
						<?php if ($this->config->item('reservation_mode') === '1') { ?>
							<li><a href="<?php echo site_url('main/reserve_table'); ?>">Reservation</a></li>
						<?php } ?>
						
						<?php if ($islogged) { ?>
							<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" id="dropdownLabel1">My Account <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownLabel1">
									<li class="dropdown-header">Links</li>
									<li><a role="presentation" href="<?php echo site_url('main/account'); ?>">Main</a></li>
									<li><a role="presentation" href="<?php echo site_url('main/details'); ?>">Details</a></li>
									<li><a role="presentation" href="<?php echo site_url('main/address'); ?>">Address</a></li>
									<li><a role="presentation" href="<?php echo site_url('main/orders'); ?>">Orders</a></li>
									
									<?php if ($this->config->item('reservation_mode') === '1') { ?>
										<li><a role="presentation" href="<?php echo site_url('main/reservations'); ?>">Reservation</a></li>
									<?php } ?>
									
									<li><a role="presentation" href="<?php echo site_url('main/logout'); ?>" >Logout</a></li>
								</ul>
							</li>
						<?php } else { ?>
							<li><a href="<?php echo site_url('main/login'); ?>">Login/Register</a></li>
						<?php } ?>

						<?php foreach ($pages as $page) { ?>
							<?php if ($page['menu_location'] === '2' OR $page['menu_location'] === '1') { ?>
								<li><a href="<?php echo site_url('main/pages?page_id='.$page['page_id']); ?>"><?php echo $page['name']; ?></a></li>
							<?php } ?>
						<?php } ?>

					</ul>
				</div>
			</div>
		</nav>
	</div>

	<div class="container">