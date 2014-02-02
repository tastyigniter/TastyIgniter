<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $text_heading ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript">
	var js_site_url = "<?php echo site_url(); ?>";
	var js_base_url = "<?php echo base_url(); ?>";
</script>
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery-ui-1.10.3.custom.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/common.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/map.js"); ?>"></script>
<?php echo link_tag('assets/js/themes/ui-lightness/jquery-ui-1.10.3.custom.min.css'); ?>
<?php echo link_tag('assets/css/user_styles.css'); ?>
</head>
<body>
<div id="opaclayer" onclick="closeReviewBox();"></div>
<div id="container">
  <div id="header">
    <div id="company_name">
    	<a href="<?php echo site_url(); ?>"><?php echo $this->config->item('config_site_name'); ?></a>
    </div>
    <div id="menu">
  		<ul>
     	<li><a href="<?php echo site_url(); ?>">Home</a></li>
     	<li><a href="<?php echo site_url('menus'); ?>">View Menu</a></li>
     	<!--<li><a href="<?php echo site_url('specials'); ?>">Special Deals</a></li>-->
     	<!--<li><a href="<?php echo site_url('cart'); ?>">Shopping Cart</a></li>-->
     	<li><a href="<?php echo site_url('find/table'); ?>">Reserve A Table</a></li>
     	<li><a href="<?php echo site_url('account'); ?>">My Account</a></li>
     	<?php if ($this->customer->islogged()) {?>
			<li><a href="<?php echo site_url('account/logout'); ?>">Logout</a></li>
		<?php } else { ?>
			<li><a href="<?php echo site_url('account/login'); ?>">Login</a></li>
		<?php } ?>
     	</ul>
     </div>
	</div>
	<h1><?php echo $text_heading; ?></h1>
	<div id="notification"><?php echo $alert; ?></div>
	<div id="content">
