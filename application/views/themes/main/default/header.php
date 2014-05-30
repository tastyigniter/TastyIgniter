<?php 
	$this->load->library('customer');
	
	$this->template->setDocType('html5');
	$this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
	$this->template->setMeta(array('name' => 'viewport', 'content' => 'initial-scale=1.0, user-scalable=no', 'type' => 'name'));
	$this->template->setLinkTag('assets/img/favicon.ico', 'shortcut icon', 'image/ico');
	$this->template->setLinkTag('assets/js/themes/custom-theme/jquery-ui-1.10.4.custom.css');
	$this->template->setLinkTag(APPPATH. 'views/themes/main/default/css/stylesheet.css');
	$this->template->setLinkTag(APPPATH. 'views/themes/main/default/css/nivo-slider.css');
	$this->template->setLinkTag(APPPATH. 'views/themes/main/default/css/jquery.fancybox.css');
	
	$doctype			= $this->template->getDocType();
	$metas				= $this->template->getMetas();
	$link_tags 			= $this->template->getLinkTags();
	$title 				= $this->template->getTitle();
	$heading 			= $this->template->getHeading();
	$site_logo 			= base_url('assets/img/' .$this->config->item('site_logo'));
	$site_name 			= $this->config->item('site_name');
	$site_url 			= site_url();
	$base_url 			= base_url();
	$islogged 			= $this->customer->islogged();
?>
<?php echo $doctype ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title><?php echo $title ?></title>
		<?php echo $metas ?>
		<?php echo $link_tags ?>
		<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery-ui-1.10.4.custom.js'); ?>"></script>
		<script src="<?php echo base_url('assets/js/common.js'); ?>"></script>
		<script type="text/javascript">
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
			});
		</script>
	</head>
	<body>
	<div id="opaclayer" onclick="closeReviewBox();"></div>
	<div class="main">
		<header> 
			<div class="container_24">
				<h1><a href="<?php echo $site_url; ?>"><img alt="<?php echo $site_name; ?>" src="<?php echo $site_logo; ?>"></a></h1>
				<div id="menu">
				<nav>
					<ul>
						<li><a href="<?php echo site_url(); ?>">Home</a></li>
						<li><a href="<?php echo site_url('main/menus'); ?>">View Menu</a></li>
						<li><a href="<?php echo site_url('main/reserve_table'); ?>">Reservation</a></li>
						<li><a href="<?php echo site_url('main/account'); ?>">My Account</a></li>
						<?php if ($islogged) { ?>
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
		<div id="notification">
			<?php if (!empty($alert)) { ?>
				<?php echo $alert; ?>
			<?php } ?>
		</div>
		<div class="container">
