<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $text_heading ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" />
		<link href="<?php echo base_url('assets/js/themes/ui-lightness/jquery-ui-1.10.3.custom.min.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/user_styles.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/nivo-slider.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo base_url('assets/css/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
		<script src="<?php echo base_url("assets/js/jquery-ui-1.10.3.custom.js"); ?>"></script>
		<script src="<?php echo base_url("assets/js/common.js"); ?>"></script>
		<script type="text/javascript">
			var js_site_url = "<?php echo site_url(); ?>/";
			var js_base_url = "<?php echo base_url(); ?>";
		</script>
	</head>
	<body>
	<div id="opaclayer" onclick="closeReviewBox();"></div>
	<div class="main">
		<header> 
			<div class="container_24">
				<h1><a href="<?php echo site_url(); ?>">
				<?php if ($this->config->item('site_logo')) { ?>
					<img src="<?php echo base_url("assets/img/".$this->config->item('site_logo')); ?>">
				<?php } else { ?>
					<?php echo $this->config->item('site_name'); ?>
				<?php } ?>
				</a></h1>
				<div id="menu">
				<nav>
					<ul>
						<li><a href="<?php echo site_url(); ?>">Home</a></li>
						<li><a href="<?php echo site_url('menus'); ?>">View Menu</a></li>
						<li><a href="<?php echo site_url('reserve/table'); ?>">Reservation</a></li>
						<li><a href="<?php echo site_url('account'); ?>">My Account</a></li>
						<?php $this->load->library('customer'); ?>
						<?php if ($this->customer->islogged()) { ?>
							<li><a href="<?php echo site_url('account/logout'); ?>">Logout</a></li>
						<?php } else { ?>
							<li><a href="<?php echo site_url('account/login'); ?>">Login</a></li>
						<?php } ?>
					</ul>
				</nav>
				</div>
			</div>
		</header>

		<div id="content">
		<div id="notification"><?php echo $alert; ?></div>
		<div class="container">
