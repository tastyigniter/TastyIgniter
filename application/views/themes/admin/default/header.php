<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<title><?php echo $heading ?> - Administrator Panel</title>
<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>" />
<link href="<?php echo base_url('assets/js/themes/custom-theme/jquery-ui-1.10.4.custom.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(APPPATH .'views/themes/admin/default/css/jquery.fancybox.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(APPPATH .'views/themes/admin/default/css/stylesheet.css'); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui-1.10.4.custom.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript">
	var js_site_url = function(str) {
		var strTmp = "<?php echo site_url('" + str + "'); ?>";
		return strTmp;
	}

	var js_base_url = function(str) {
		var strTmp = "<?php echo base_url('" + str + "'); ?>";
		return strTmp;
	}
</script>
<script type="text/javascript">
var active_menu = '<?php echo ($this->uri->segment(2)) ? $this->uri->segment(2) : 'admin'; ?>'

$(document).ready(function() {
	//Delete Confirmation Box
	$('#list-box form:not(#filter-form)').submit(function(){
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
        if ($('.' + active_menu).parent().parent().hasClass('parent') || $('.' + active_menu).hasClass('parent')) {
			$('.' + active_menu).addClass('active_parent');
			$('.' + active_menu).parent().parent().addClass('active_parent');
		}
		
		$('.' + active_menu).addClass('active');
	}

	if ($('#notification > p').length > 0) {
		$('#notification > p').prepend('<i class="icon icon-cancel"></i>');
		$('#notification > p i').on('click', function() { 
			$('#notification > p').slideUp(function() {
				$('#notification').empty();
			});
		});
	}
});	

function saveClose() {
	$('form').append('<input type="hidden" name="save_close" value="1" />');
	$('form').submit();
}
</script>
</head>
<body>
<div id="container">
	<div id="header">
		<h1>Administrator Panel</h1>
		<?php if ($this->user->islogged()) { ?>
			<a class="user-menu"><?php echo $this->user->getUserName(); ?> <i class="icon icon-user"></i></a>
			<ul class="user-menu-box">
				<li><span><b>User:</b> <?php echo $this->user->getStaffName(); ?></span></li>
				<li><span><b>Staff Group:</b> <?php echo $this->user->staffGroup(); ?></span></li>
				<li><a href="<?php echo site_url('admin/staffs'); ?>/edit?id=<?php echo $this->user->getStaffId(); ?>">Edit Details</a></li>
				<li><a href="<?php echo site_url('admin/logout'); ?>">Logout</a></li>
			</ul>
		<?php } ?>
	</div>

	<?php if ($this->user->islogged()) { ?>
		<div id="menu-wrapper"></div>
		<div id="content">
		<nav id="menu">
			<div class="menu-shortcuts">
				<a class="front-end" title="Store Front" target="_blank" href="<?php echo site_url(); ?>"><i class="icon icon-popout"></i></a>
				<a class="settings" title="Settings" href="<?php echo site_url('admin/settings'); ?>"><i class="icon icon-setting"></i></a>
				<a class="alerts" title="Alerts" href="<?php echo site_url('admin/alerts'); ?>"><i class="icon icon-bell"></i></a>
				<a class="messages" title="Messages" href="<?php echo site_url('admin/messages'); ?>"><i class="icon icon-mail"></i></a>
			</div>
			<ul>
				<li class="dashboard admin"><a href="<?php echo site_url('admin/dashboard'); ?>"><i class="icon icon-dashboard"></i>Dashboard</a></li>
				<li class="menus parent"><a href="<?php echo site_url('admin/menus'); ?>"><i class="icon icon-menu"></i>Menus</a>
					<ul id="sub_nav">
						<li class="menu_options"><a href="<?php echo site_url('admin/menu_options'); ?>">Options</a></li>
						<li class="categories"><a href="<?php echo site_url('admin/categories'); ?>">Categories</a></li>
					</ul>
				</li>
				<li class="tables"><a href="<?php echo site_url('admin/tables'); ?>"><i class="icon icon-table"></i>Tables</a></li>
				<li class="parent"><a><i class="icon icon-sale"></i>Sales</a>
					<ul id="sub_nav">
						<li class="orders"><a href="<?php echo site_url('admin/orders'); ?>">Orders</a></li>
						<li class="reservations"><a href="<?php echo site_url('admin/reservations'); ?>">Reservations</a></li>
						<li class="coupons"><a href="<?php echo site_url('admin/coupons'); ?>">Coupons</a></li>
						<li class="reviews"><a href="<?php echo site_url('admin/reviews'); ?>">Reviews</a></li>
					</ul>
				</li>
				<li class="customers parent"><a href="<?php echo site_url('admin/customers'); ?>"><i class="icon icon-customer"></i>Customers</a>
					<ul id="sub_nav">
						<li class="customers_activity"><a href="<?php echo site_url('admin/customers_activity'); ?>">Activities</a></li>
						<li class="customer_groups"><a href="<?php echo site_url('admin/staff_groups'); ?>">Customer Groups</a></li>
					</ul>
				</li>
				<li class="staffs parent"><a href="<?php echo site_url('admin/staffs'); ?>"><i class="icon icon-staff"></i>Staffs</a>
					<ul id="sub_nav">
						<li class="staff_groups"><a href="<?php echo site_url('admin/staff_groups'); ?>">Staff Groups</a></li>
					</ul>
				</li>
				<li class="locations"><a href="<?php echo site_url('admin/locations'); ?>"><i class="icon icon-location"></i>Locations</a></li>
				<li class="payments cod paypal_express"><a href="<?php echo site_url('admin/payments'); ?>"><i class="icon icon-payment"></i>Payments</a></li>
				<li class="parent"><a><i class="icon icon-localisation"></i>Localisation</a>
					<ul id="sub_nav">
						<li class="languages"><a href="<?php echo site_url('admin/languages'); ?>">Languages</a></li>
						<li class="currencies"><a href="<?php echo site_url('admin/currencies'); ?>">Currencies</a></li>
						<li class="countries"><a href="<?php echo site_url('admin/countries'); ?>">Countries</a></li>
						<li class="security_questions"><a href="<?php echo site_url('admin/security_questions'); ?>">Security Questions</a></li>
						<li class="ratings"><a href="<?php echo site_url('admin/ratings'); ?>">Ratings</a></li>
						<li class="statuses"><a href="<?php echo site_url('admin/statuses'); ?>">Statuses</a></li>
					</ul>
				</li>
				<li class="extensions"><a href="<?php echo site_url('admin/extensions'); ?>"><i class="icon icon-extension"></i>Extensions</a></li>
				<li class="parent"><a><i class="icon icon-tool"></i>Tools</a>
					<ul id="sub_nav">
						<li class="image_tool"><a href="<?php echo site_url('admin/image_tool'); ?>">Image</a></li>
						<li class="backup"><a href="<?php echo site_url('admin/backup'); ?>">Backup</a></li>
						<li class="restore"><a href="<?php echo site_url('admin/restore'); ?>">Restore</a></li>
					</ul>
				</li>
				<li class="parent"><a><i class="icon icon-more"></i>More...</a>
					<ul id="sub_nav">
						<li class="themes"><a href="<?php echo site_url('admin/themes'); ?>">Themes</a></li>
						<li class="pages"><a href="<?php echo site_url('admin/pages'); ?>">Pages</a></li>
						<li class="layouts"><a href="<?php echo site_url('admin/layouts'); ?>">Layouts</a></li>
						<li class="mail_templates"><a href="<?php echo site_url('admin/mail_templates'); ?>">Mail Templates</a></li>
						<li class="uri_routes"><a href="<?php echo site_url('admin/uri_routes'); ?>">URI Routes</a></li>
						<li class="error_logs"><a href="<?php echo site_url('admin/error_logs'); ?>">Error Logs</a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<div id="box-content">
	<?php } else { ?>
		<div id="content">
	<?php } ?>

		<nav id="menu2">
			<div class="back left">
				<?php if (isset($sub_menu_back)) { ?>
					<a class="back_button" href="<?php echo $sub_menu_back; ?>"></a>
				<?php } ?>
			</div>
	
			<h2><?php echo $heading ?></h2>
			<div class="right">
				<?php if (isset($button_add)) { ?>
					<a class="add_button" href="<?php echo page_url() .'/edit'; ?>">+ <?php echo $button_add; ?></a>
				<?php } ?>

				<?php if (isset($button_delete)) { ?>
					<a class="delete_button" onclick="$('form:not(#filter-form)').submit();"><?php echo $button_delete; ?></a>
				<?php } ?>

				<?php if (isset($button_save)) { ?>
					<a class="save_button" onclick="$('form').submit();"><?php echo $button_save; ?></a>
				<?php } ?>

				<?php if (isset($button_save_close)) { ?>
					<a class="save_close_button" onclick="saveClose();"><?php echo $button_save_close; ?></a>
				<?php } ?>
			</div>
		
			<div class="icons">
				<?php if (isset($button_list)) { ?>
					<?php echo $button_list; ?>
				<?php } ?>
			</div>
		</nav>

		<div id="notification">
			<?php if (validation_errors()) { ?>
				<?php echo validation_errors('<span class="error">', '</span>'); ?>
			<?php } ?>
			<?php if (!empty($alert)) { ?>
				<?php echo $alert; ?>
			<?php } ?>
		</div>