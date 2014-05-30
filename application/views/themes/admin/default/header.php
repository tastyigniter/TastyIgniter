<?php 
	$this->template->setDocType('html5');
	$this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
	$this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'chrome=1', 'type' => 'equiv'));
	$this->template->setLinkTag('assets/img/favicon.ico', 'shortcut icon', 'image/ico');
	$this->template->setLinkTag('assets/js/themes/custom-theme/jquery-ui-1.10.4.custom.css');
	$this->template->setLinkTag(APPPATH .'views/themes/admin/default/css/jquery.fancybox.css');
	$this->template->setLinkTag(APPPATH .'views/themes/admin/default/css/stylesheet.css');
	
	$doctype			= $this->template->getDocType();
	$metas				= $this->template->getMetas();
	$link_tags 			= $this->template->getLinkTags();
	$title 				= $this->template->getTitle() .' ‹ Administrator Panel ‹ TastyIgniter';
	$site_url 			= site_url();
	$base_url 			= base_url();
	$active_menu 		= ($this->uri->segment(2)) ? $this->uri->segment(2) : 'admin';
	$islogged 			= $this->user->islogged();
	$username 			= $this->user->getUsername();
	$staff_name 		= $this->user->getStaffName();
	$staff_group 		= $this->user->staffGroup();
	$staff_edit 		= site_url('admin/staffs/edit?id='. $this->user->getStaffId());
	$logout 			= site_url('admin/logout');
	
	$menu_shortcuts = array(
		array('class' => 'front-end', 'title' => 'Store Front', 'target' => '_blank', 'href' => site_url(), 'icon' => 'icon-popout'),
		array('class' => 'settings', 'title' => 'Settings', 'target' => '', 'href' => site_url('admin/settings'), 'icon' => 'icon-setting'),
		array('class' => 'messages', 'title' => 'Messages', 'target' => '', 'href' => site_url('admin/messages'), 'icon' => 'icon-mail'),
		array('class' => 'alerts', 'title' => 'Alerts', 'target' => '', 'href' => site_url('admin/alerts'), 'icon' => 'icon-bell')
	);

	$heading 			= $this->template->getHeading();
	$button_list 		= $this->template->getButtonList();
	$icon_list 			= $this->template->getIconList();
	$back_button 		= $this->template->getBackButton();
?>
<?php echo $doctype ?>
<html>
<head>
<?php echo $metas ?>
<title><?php echo $title ?></title>
<?php echo $link_tags ?>
<script src="<?php echo base_url('assets/js/jquery-1.10.2.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery-ui-1.10.4.custom.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>
<script type="text/javascript">
	var js_site_url = function(str) {
		var strTmp = "<?php echo $site_url; ?>" + str;
		return strTmp;
	}

	var js_base_url = function(str) {
		var strTmp = "<?php echo $base_url; ?>" + str;
		return strTmp;
	}
</script>
<script type="text/javascript">
var active_menu = '<?php echo $active_menu; ?>'

$(document).ready(function() {
	//Delete Confirmation Box
	$('#list-form').submit(function(){
        //if ($('input[name=\'delete\']').attr("checked") == "checked") {
			if (!confirm('This cannot be undone! Are you sure you want to do this?')) {
				return false;
			}
		//}
	});

    //Uninstall Confirmation Box
    $('a').click(function(){
        if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
            if (!confirm('This cannot be undone! Are you sure you want to do this?')) {
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
	
	$(document).mouseup(function (e) {
		var container = $('.dropdown-toggle');
		if (!container.is(e.target) && container.has(e.target).length === 0) { // if the target of the click isn't the container... ... nor a descendant of the container
			$('.dropdown-menu').hide();
			$('.dropdown-toggle').removeClass('open');
		}
	});

	$('.dropdown-toggle').on('click', function() {
		if ($('.dropdown-menu').is(':visible')) {
			$('.dropdown-menu').hide();
			$('.dropdown-toggle').removeClass('open');
		} else {
			$('.dropdown-menu').show();
			$('.dropdown-toggle').addClass('open');
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
		<h1><a class="admin-logo"><i class="icon icon-logo"></i></a>Administrator Panel</h1>
		<?php if ($islogged) { ?>
			<a class="user-menu"><?php echo $username; ?> <i class="icon icon-user"></i></a>
			<ul class="user-menu-box">
				<li><span><b>User:</b> <?php echo $staff_name; ?></span></li>
				<li><span><b>Staff Group:</b> <?php echo $staff_group; ?></span></li>
				<li><a href="<?php echo $staff_edit; ?>">Edit Details</a></li>
				<li><a href="<?php echo $logout; ?>">Logout</a></li>
			</ul>
		<?php } ?>
	</div>

	<?php if ($islogged) { ?>
		<div id="menu-wrapper"></div>
		<div id="content">
		<nav id="menu">
			<div class="menu-shortcuts">
				<?php foreach ($menu_shortcuts as $shortcut) { ?>
					<a class="<?php echo $shortcut['class']; ?>" title="<?php echo $shortcut['title']; ?>" target="<?php echo $shortcut['target']; ?>" href="<?php echo $shortcut['href']; ?>"><i class="icon <?php echo $shortcut['icon']; ?>"></i></a>
				<?php } ?>
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
						<li class="customer_groups"><a href="<?php echo site_url('admin/customer_groups'); ?>">Customer Groups</a></li>
						<li class="customers_activity"><a href="<?php echo site_url('admin/customers_activity'); ?>">Activities</a></li>
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
		<nav id="menu2">
			<div class="back left">
				<?php if (isset($back_button)) { ?>
					<?php echo $back_button; ?>
				<?php } ?>
			</div>

			<h2><?php echo $heading ?></h2>
			<div class="right">
				<?php if (isset($button_list)) { ?>
					<?php echo $button_list; ?>
				<?php } ?>
			</div>
	
			<div class="icons">
				<?php if (isset($icon_list)) { ?>
					<?php echo $icon_list; ?>
				<?php } ?>
			</div>
		</nav>
	<?php } else { ?>
		<div id="content">
	<?php } ?>

