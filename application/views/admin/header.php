<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrator Panel - <?php echo $heading ?></title>
<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" />
<link href="<?php echo base_url('assets/js/themes/ui-lightness/jquery-ui-1.10.3.custom.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/css/admin_styles.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url("assets/js/jquery-1.9.1.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/jquery-ui-1.10.3.custom.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/common.js"); ?>"></script>
<script type="text/javascript">
	var js_site_url = "<?php echo site_url(); ?>/";
	var js_base_url = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript">
var active_menu = '<?php echo ($this->uri->segment(2)) ? $this->uri->segment(2) : ''; ?>'

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

	$('.user-menu').on('click', function() {
		if ($('.user-menu-box').is(':visible')) {
			$('.user-menu-box').hide();
			$('.user-menu').removeClass('open');
		} else {
			$('.user-menu-box').show();
			$('.user-menu').addClass('open');
		}
	});	
	
	if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
        if ($('.' + active_menu).parent().parent().hasClass('parent')) {
			$('.' + active_menu).parent().parent().addClass('active');
		}
		$('.' + active_menu).addClass('active');
	}
});	
</script>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>Administrator Panel</h1>
		<?php if ($this->user->islogged()) { ?>
			<a class="user-menu"><?php echo $this->user->getUserName(); ?> <img src="<?php echo base_url('assets/img/user24x24.png'); ?>" width="16" /></a>
			<ul class="user-menu-box">
				<li><b>User:</b> <?php echo $this->user->getStaffName(); ?></li>
				<li><b>Staff Group:</b> <?php echo $this->user->staffGroup(); ?></li>
				<li><b>Location:</b> <?php echo $this->user->getLocationName(); ?></li>
				<li><a href="<?php echo site_url('admin/logout'); ?>">Logout</a></li>
			</ul>
		<?php } ?>
	</div>
	<div id="menuwrap"></div>
	<?php if ($this->user->islogged()) { ?>
  	<nav id="menu">
		<ul>
			<li class="dashboard"><a href="<?php echo site_url('admin/dashboard'); ?>">Dashboard</a></li>
			<li class="alerts"><a href="<?php echo site_url('admin/alerts'); ?>">Alerts<i class="icon-alert-bell"></i></a></li>
			<li class="parent"><a href="<?php echo site_url('admin/menus'); ?>">Menus</a>
				<ul id="sub_nav">
					<li class="menu_options"><a href="<?php echo site_url('admin/menu_options'); ?>">Options</a></li>
					<li class="categories"><a href="<?php echo site_url('admin/categories'); ?>">Categories</a></li>
				</ul>
			</li>
			<li class="tables"><a href="<?php echo site_url('admin/tables'); ?>">Tables</a></li>
			<li class="customers"><a href="<?php echo site_url('admin/customers'); ?>">Customers</a></li>
			<li class="parent"><a>Sales</a>
				<ul id="sub_nav">
					<li class="orders"><a href="<?php echo site_url('admin/orders'); ?>">Orders</a></li>
					<li class="reservations"><a href="<?php echo site_url('admin/reservations'); ?>">Reservations</a></li>
					<li class="coupons"><a href="<?php echo site_url('admin/coupons'); ?>">Coupons</a></li>
				</ul>
			</li>
			<li class="staffs parent"><a href="<?php echo site_url('admin/staffs'); ?>">Staffs</a>
				<ul id="sub_nav">
					<li class="staff_groups"><a href="<?php echo site_url('admin/staff_groups'); ?>">Staff Groups</a></li>
				</ul>
			</li>
			<li class="locations"><a href="<?php echo site_url('admin/locations'); ?>">Locations</a></li>
			<li class="messages"><a href="<?php echo site_url('admin/messages'); ?>">Messages</a></li>
			<li class="payments"><a href="<?php echo site_url('admin/payments'); ?>">Payments</a></li>
			<li class="parent"><a>Localisation</a>
				<ul id="sub_nav">
					<li class="currencies"><a href="<?php echo site_url('admin/currencies'); ?>">Currencies</a></li>
					<li class="countries"><a href="<?php echo site_url('admin/countries'); ?>">Countries</a></li>
					<li class="security_questions"><a href="<?php echo site_url('admin/security_questions'); ?>">Security Questions</a></li>
					<li class="ratings"><a href="<?php echo site_url('admin/ratings'); ?>">Ratings</a></li>
					<li class="order_statuses"><a>Statuses</a>
						<ul id="sub_nav">
							<li class="reserve_statuses"><a href="<?php echo site_url('admin/order_statuses'); ?>">Order Statuses</a></li>
							<li class="reserve_statuses"><a href="<?php echo site_url('admin/reserve_statuses'); ?>">Reserve Statuses</a></li>
						</ul>
					</li>
				</ul>
			</li>
			<li class="parent"><a>More...</a>
				<ul id="sub_nav">
					<li class="reviews"><a href="<?php echo site_url('admin/reviews'); ?>">Reviews</a></li>
					<li class="uri_routes"><a href="<?php echo site_url('admin/uri_routes'); ?>">URI Routes</a></li>
					<li class="layouts"><a href="<?php echo site_url('admin/layouts'); ?>">Layouts</a></li>
					<li class="error_logs"><a href="<?php echo site_url('admin/error_logs'); ?>">Error Logs</a></li>
				</ul>
			</li>
			<li class="extensions"><a href="<?php echo site_url('admin/extensions'); ?>">Extensions</a></li>
			<li class="parent"><a>Tools...</a>
				<ul id="sub_nav">
					<li class="backup"><a href="<?php echo site_url('admin/image_tool'); ?>">Image Tool</a></li>
					<li class="backup"><a href="<?php echo site_url('admin/backup'); ?>">Backup</a></li>
					<li class="restore"><a href="<?php echo site_url('admin/restore'); ?>">Restore</a></li>
				</ul>
			</li>
			<li class="settings"><a href="<?php echo site_url('admin/settings'); ?>">Settings</a></li>
			<li class=""><a target="_blank" href="<?php echo site_url(); ?>">Front-End</a></li>
		</ul>
    </nav>
	<?php } ?>
	<div id="content">
		<nav id="menu2">
			<div class="left">
				<?php if (isset($sub_menu_back)) { ?>
					<a class="back_button" href="<?php echo $sub_menu_back; ?>"><img src="<?php echo base_url('assets/img/arrow-back.png'); ?>" /></a>
				<?php } ?>
			</div>
	
			<div class="right">
				<?php if (isset($sub_menu_list)) { ?>
					<?php echo $sub_menu_list; ?>
				<?php } ?>
		
				<?php if (isset($sub_menu_add)) { ?>
					<a class="add_button" href="<?php echo current_url() .'/edit'; ?>"><?php echo $sub_menu_add; ?></a>
				<?php } ?>

				<?php if (isset($sub_menu_delete)) { ?>
					<a class="delete_button" onclick="$('form').submit();"><?php echo $sub_menu_delete; ?></a>
				<?php } ?>

				<?php if (isset($sub_menu_save)) { ?>
					<a class="save_button" onclick="$('form').submit();"><?php echo $sub_menu_save; ?></a>
				<?php } ?>

			</div>
			<h2><?php echo $heading ?></h2>
		</nav>

		<div id="notification">
			<?php if (validation_errors()) { ?>
				<?php echo validation_errors('<span class="error">', '</span>'); ?>
			<?php } ?>
			<?php if (!empty($alert)) { ?>
				<?php echo $alert; ?>
			<?php } ?>
		</div>