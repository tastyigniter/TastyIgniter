<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title><?php echo $text_heading ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" />
		<link href="<?php echo base_url('assets/js/themes/custom-theme/jquery-ui-1.10.4.custom.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(APPPATH. 'views/themes/main/default/css/stylesheet.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(APPPATH. 'views/themes/main/default/css/nivo-slider.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url(APPPATH. 'views/themes/main/default/css/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery-ui-1.10.4.custom.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/common.js'); ?>"></script>
		<script type="text/javascript">
			var js_site_url = function(str) {
			 	var strTmp = "<?php echo site_url('" + str + "'); ?>";
			 	return strTmp;
			}

			var js_base_url = function(str) {
				var strTmp = "<?php echo base_url('" + str + "'); ?>";
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
			});
		</script>
	</head>
	<body>
	<div id="opaclayer" onclick="closeReviewBox();"></div>
	<div class="main">
		<header> 
			<div class="container_24">
				<h1><a href="<?php echo site_url(); ?>">
				<?php if ($this->config->item('site_logo')) { ?>
					<img src="<?php echo base_url('assets/img/' .$this->config->item('site_logo')); ?>">
				<?php } else { ?>
					<?php echo $this->config->item('site_name'); ?>
				<?php } ?>
				</a></h1>
				<div id="menu">
				<nav>
					<ul>
						<li><a href="<?php echo site_url(); ?>">Home</a></li>
						<li><a href="<?php echo site_url('main/menus'); ?>">View Menu</a></li>
						<li><a href="<?php echo site_url('main/reserve_table'); ?>">Reservation</a></li>
						<li><a href="<?php echo site_url('main/account'); ?>">My Account</a></li>
						<?php $this->load->library('customer'); ?>
						<?php if ($this->customer->islogged()) { ?>
							<li><a href="<?php echo site_url('main/logout'); ?>">Logout</a></li>
						<?php } else { ?>
							<li><a href="<?php echo site_url('main/login'); ?>">Login</a></li>
						<?php } ?>
					</ul>
				</nav>
				</div>
			</div>
		</header>

		<div id="content">
		<div id="notification"><?php echo $alert; ?></div>
		<div class="container">
