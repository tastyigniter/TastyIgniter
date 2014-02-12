<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrator Panel - <?php echo $heading ?></title>
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery-ui-1.10.3.custom.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/common.js"); ?>"></script>
<script type="text/javascript">
$(document).ready(function() {
	//Delete Confirmation Box
	$('#list-box form').submit(function(){
        //if ($('input[name=\'delete\']').attr("checked") == "checked") {
			if (!confirm('Delete cannot be undone! Are you sure you want to do this?')) {
				return false;
			}
		//}
	});

    //Uninstall Confirmation Box
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
            if (!confirm('Uninstall cannot be undone! Are you sure you want to do this?')) {
                return false;
            }
        }
    });

});	
</script>
<?php echo link_tag('assets/js/themes/ui-lightness/jquery-ui-1.10.3.custom.min.css'); ?>
<?php echo link_tag('assets/css/admin_styles.css'); ?>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>ADMINISTRATOR PANEL</h1>
	</div>
  	<nav id="menu">
		<ul>
			<li><a href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a></li>
			<li><a href="<?php echo site_url('admin/menus'); ?>">Menus</a>
				<span class="arrow_down"></span>
				<ul id="sub_nav">
					<li><a href="<?php echo site_url('admin/menu_options'); ?>">Options</a></li>
					<li><a href="<?php echo site_url('admin/categories'); ?>">Categories</a></li>
					<li><a href="<?php echo site_url('admin/reviews'); ?>">Reviews</a></li>
					<li><a href="<?php echo site_url('admin/ratings'); ?>">Ratings</a></li>
				</ul>
			</li>
			<li><a href="<?php echo site_url('admin/customers'); ?>">Customers</a>
				<span class="arrow_down"></span>
				<ul id="sub_nav">
					<li><a href="<?php echo site_url('admin/security_questions'); ?>">Security Questions</a></li>
				</ul>
			</li>
			<li><a href="<?php echo site_url('admin/orders'); ?>">Orders</a></li>
			<li><a href="<?php echo site_url('admin/reservations'); ?>">Reservations</a></li>
			<li><a href="<?php echo site_url('admin/staffs'); ?>">Staffs</a>
				<span class="arrow_down"></span>
				<ul id="sub_nav">
					<li><a href="<?php echo site_url('admin/departments'); ?>">Departments</a></li>
				</ul>
			</li>
			<li><a href="<?php echo site_url('admin/locations'); ?>">Locations</a></li>
			<li><a href="<?php echo site_url('admin/messages'); ?>">Messages</a>
				<span class="arrow_down"></span>
				<ul id="sub_nav">
					<li><a href="<?php echo site_url('admin/alerts'); ?>">Alerts</a></li>
				</ul>
			</li>
			<li><a>Manage</a>
				<span class="arrow_down"></span>
				<ul id="sub_nav">
					<li><a href="<?php echo site_url('admin/tables'); ?>">Tables</a></li>
					<li><a href="<?php echo site_url('admin/payments'); ?>">Payments</a></li>
					<li><a href="<?php echo site_url('admin/coupons'); ?>">Coupons</a></li>
					<li><a>Statuses</a>
					<span class="arrow_right"></span>
						<ul id="sub_nav">
							<li><a href="<?php echo site_url('admin/order_statuses'); ?>">Order Statuses</a></li>
							<li><a href="<?php echo site_url('admin/reserve_statuses'); ?>">Reserve Statuses</a></li>
						</ul>
					</li>
					<li><a href="<?php echo site_url('admin/currencies'); ?>">Currencies</a></li>
					<li><a href="<?php echo site_url('admin/countries'); ?>">Countries</a></li>
					<li><a href="<?php echo site_url('admin/uri_routes'); ?>">URI Routes</a></li>
					<li><a href="<?php echo site_url('admin/layouts'); ?>">Layouts</a></li>
				</ul>
			</li>
			<li><a>Tools</a>
				<span class="arrow_down"></span>
				<ul id="sub_nav">
					<li><a href="<?php echo site_url('admin/extensions'); ?>">Extensions</a></li>
					<li><a href="<?php echo site_url('admin/error_logs'); ?>">Error Logs</a></li>
					<li><a href="<?php echo site_url('admin/backup'); ?>">Backup/Restore</a></li>
				</ul>
			</li>
			<li><a href="<?php echo site_url('admin/settings'); ?>">Settings</a></li>
			<li><a target="_blank" href="<?php echo site_url(); ?>">Front-End</a></li>
			<?php if ($this->user->islogged()) { ?>
			<li><a><?php echo $this->user->getStaffName(); ?></a>
				<span class="arrow_down"></span>
				<ul id="sub_nav">
					<li><a><b>Logged In As:</b><br /><?php echo $this->user->getUserName(); ?></a></li>
					<li><a><b>Department:</b><br /><?php echo $this->user->department(); ?></a></li>
					<li><a><b>Location:</b><br /><?php echo $this->user->getLocationName(); ?></a></li>
					<li><a href="<?php echo site_url('admin/logout'); ?>">Logout</a></li>			
				</ul>			
			</li>
			<?php } ?>
		</ul>
    </nav>
	<nav id="menu2">
		<ul class="left">
			<?php if (isset($sub_menu_back)) { ?>
				<li><a class="back_button" href="<?php echo $sub_menu_back; ?>"><img src="<?php echo base_url('assets/img/arrow-back.png'); ?>" /></a></li>
			<?php } ?>
		</ul>
	
		<ul class="right">
			<?php if (isset($sub_menu_list)) { ?>
				<?php echo $sub_menu_list; ?>
			<?php } ?>
		
			<?php if (isset($sub_menu_add)) { ?>
				<li><a class="add_button" href="<?php echo current_url() .'/edit'; ?>"><?php echo $sub_menu_add; ?></a></li>
			<?php } ?>

			<?php if (isset($sub_menu_delete)) { ?>
				<li><a class="delete_button" onclick="$('form').submit();"><?php echo $sub_menu_delete; ?></a></li>
			<?php } ?>

			<?php if (isset($sub_menu_save)) { ?>
				<li><a class="save_button" onclick="$('form').submit();"><?php echo $sub_menu_save; ?></a></li>
			<?php } ?>

		</ul>

		<h2><?php echo $heading ?></h2>
	</nav>

	<div id="content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>