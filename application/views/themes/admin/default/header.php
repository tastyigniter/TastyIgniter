<?php 
	//$this->load->library('user');

	$this->template->setTemplate(ADMIN_URI.'/default');
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
	$this->template->setScriptTag('js/jquery-1.10.2.js');
	$this->template->setScriptTag('js/jquery-ui-1.10.4.custom.js');
	$this->template->setScriptTag('js/bootstrap.js');
	$this->template->setScriptTag('js/bootstrap-select.js');
	$this->template->setScriptTag('js/common.js');
	
	$doctype			= $this->template->getDocType();
	$metas				= $this->template->getMetas();
	$link_tags 			= $this->template->getLinkTags();
	$script_tags 		= $this->template->getScriptTags();
	$site_name 			= $this->config->item('site_name');
	$title 				= $this->template->getTitle() .' ‹ Administrator Panel ‹ '. $site_name;
	$site_url 			= rtrim(site_url(), '/').'/';
	$base_url 			= base_url();
	$active_menu 		= ($this->uri->segment(2)) ? $this->uri->segment(2) : ADMIN_URI;
	$message_unread 	= $this->user->unreadMessageTotal();
	$islogged 			= $this->user->islogged();
	$username 			= $this->user->getUsername();
	$staff_name 		= $this->user->getStaffName();
	$staff_group 		= $this->user->staffGroup();
	$staff_edit 		= site_url(ADMIN_URI.'/staffs/edit?id='. $this->user->getStaffId());
	$logout 			= site_url(ADMIN_URI.'/logout');

	$menu_shortcuts = array(
		array('class' => 'front-end', 'title' => 'Store Front', 'target' => '_blank', 'href' => site_url(), 'icon' => 'fa-share-square-o'),
		array('class' => 'messages', 'title' => '<span class="badge">'. $message_unread .'</span>', 'target' => '', 'href' => site_url(ADMIN_URI.'/messages'), 'icon' => 'fa-envelope')
		//array('class' => 'alerts', 'title' => '<span class="badge">7</span>', 'target' => '', 'href' => site_url(ADMIN_URI.'/alerts'), 'icon' => 'fa-bell')
	);

	$heading 			= $this->template->getHeading();
	$button_list 		= $this->template->getButtonList();
	$icon_list 			= $this->template->getIconList();
	$back_button 		= $this->template->getBackButton();
?>
<?php echo $doctype ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php echo $metas ?>
	<title><?php echo $title ?></title>
	<?php echo $link_tags ?>
	<?php echo $script_tags ?>
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
		var active_menu = '<?php echo $active_menu; ?>';

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

			if (document.location.toString().toLowerCase().indexOf(active_menu, 1) != -1) {
				if ($('.' + active_menu).parent().parent().hasClass('parent') || $('.' + active_menu).hasClass('parent')) {
					$('.' + active_menu).addClass('active_parent active');
					$('.' + active_menu).parent().parent().addClass('active_parent active');
				}
		
				$('.' + active_menu).addClass('active');
			}
		});	

		function saveClose() {
			$('#edit-form').append('<input type="hidden" name="save_close" value="1" />');
			$('#edit-form').submit();
		}

		$('.alert').alert();
		$('.dropdown-toggle').dropdown();
		/*$('ul.side-nav li.dropdown').hover(function() {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function() {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		});*/
	</script>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    <div id="wrapper" class="<?php echo ($this->user->islogged()) ? '' : 'wrap-none'; ?>">
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand"><span class="icon icon-logo"></span>Administrator Panel</a>
			</div>
		
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<?php if ($islogged) { ?>
				<ul class="nav navbar-nav side-nav">
					<li class="dashboard admin"><a href="<?php echo site_url(ADMIN_URI.'/dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
					<li class="dropdown menus parent">
						<a id="" class="" data-target="#" href="<?php echo site_url(ADMIN_URI.'/menus'); ?>"><i class="fa fa-cutlery"></i>Menus <i class="fa fa-caret-right"></i></a>
						<ul class="sidenav-menu" role="menu">
							<li class="menu_options"><a href="<?php echo site_url(ADMIN_URI.'/menu_options'); ?>">Options</a></li>
							<li class="categories"><a href="<?php echo site_url(ADMIN_URI.'/categories'); ?>">Categories</a></li>
						</ul>
					</li>
					<li class="tables"><a href="<?php echo site_url(ADMIN_URI.'/tables'); ?>"><i class="fa fa-table"></i>Tables</a></li>
					<li class="dropdown parent">
						<a class=""><i class="fa fa-bar-chart-o"></i>Sales <i class="fa fa-caret-right"></i></a>
						<ul class="sidenav-menu">
							<li class="orders"><a href="<?php echo site_url(ADMIN_URI.'/orders'); ?>">Orders</a></li>
							<li class="reservations"><a href="<?php echo site_url(ADMIN_URI.'/reservations'); ?>">Reservations</a></li>
							<li class="coupons"><a href="<?php echo site_url(ADMIN_URI.'/coupons'); ?>">Coupons</a></li>
							<li class="reviews"><a href="<?php echo site_url(ADMIN_URI.'/reviews'); ?>">Reviews</a></li>
						</ul>
					</li>
					<li class="dropdown parent">
						<a class=""><i class="fa fa-user"></i>Users <i class="fa fa-caret-right"></i></a>
						<ul class="sidenav-menu">
							<li class="customers"><a href="<?php echo site_url(ADMIN_URI.'/customers'); ?>">Customers</a></li>
							<li class="staffs"><a href="<?php echo site_url(ADMIN_URI.'/staffs'); ?>">Staffs</a>
							<li class="customer_groups"><a href="<?php echo site_url(ADMIN_URI.'/customer_groups'); ?>">Customer Groups</a></li>
							<li class="staff_groups"><a href="<?php echo site_url(ADMIN_URI.'/staff_groups'); ?>">Staff Groups</a></li>
							<li class="customers_activity"><a href="<?php echo site_url(ADMIN_URI.'/customers_activity'); ?>">Activities</a></li>
						</ul>
					</li>
					<li class="locations"><a href="<?php echo site_url(ADMIN_URI.'/locations'); ?>"><i class="fa fa-map-marker"></i>Locations</a></li>
					<li class="dropdown parent">
						<a class=""><i class="fa fa-globe"></i>Localisation <i class="fa fa-caret-right"></i></a>
						<ul class="sidenav-menu">
							<li class="languages"><a href="<?php echo site_url(ADMIN_URI.'/languages'); ?>">Languages</a></li>
							<li class="currencies"><a href="<?php echo site_url(ADMIN_URI.'/currencies'); ?>">Currencies</a></li>
							<li class="countries"><a href="<?php echo site_url(ADMIN_URI.'/countries'); ?>">Countries</a></li>
							<li class="security_questions"><a href="<?php echo site_url(ADMIN_URI.'/security_questions'); ?>">Security Questions</a></li>
							<li class="ratings"><a href="<?php echo site_url(ADMIN_URI.'/ratings'); ?>">Ratings</a></li>
							<li class="statuses"><a href="<?php echo site_url(ADMIN_URI.'/statuses'); ?>">Statuses</a></li>
						</ul>
					</li>
					<li class="dropdown parent">
						<a class=""><i class="fa fa-puzzle-piece"></i>Extensions <i class="fa fa-caret-right"></i></a>
						<ul class="sidenav-menu">
							<li class="modules extensions parent"><a href="<?php echo site_url(ADMIN_URI.'/extensions'); ?>">Modules</a></li>
							<li class="payments"><a href="<?php echo site_url(ADMIN_URI.'/payments'); ?>">Payments</a></li>
							<li class="themes"><a href="<?php echo site_url(ADMIN_URI.'/themes'); ?>">Themes</a></li>
							<li class="mail_templates"><a href="<?php echo site_url(ADMIN_URI.'/mail_templates'); ?>">Mail Templates</a></li>
							<li class="image_manager"><a href="<?php echo site_url(ADMIN_URI.'/image_manager'); ?>">Image Manager</a></li>
						</ul>
					</li>
					<li class="dropdown parent">
						<a class=""><i class="fa fa-wrench"></i>Tools <i class="fa fa-caret-right"></i></a>
						<ul class="sidenav-menu">
							<li class="image_tool"><a href="<?php echo site_url(ADMIN_URI.'/image_tool'); ?>">Image</a></li>
							<li class="backup"><a href="<?php echo site_url(ADMIN_URI.'/backup'); ?>">Backup</a></li>
							<li class="restore"><a href="<?php echo site_url(ADMIN_URI.'/restore'); ?>">Restore</a></li>
						</ul>
					</li>
					<li class="dropdown parent">
						<a class=""><i class="fa fa-cog"></i>System <i class="fa fa-caret-right"></i></a>
						<ul class="sidenav-menu">
							<li class="pages"><a href="<?php echo site_url(ADMIN_URI.'/pages'); ?>">Pages</a></li>
							<li class="banners"><a href="<?php echo site_url(ADMIN_URI.'/banners'); ?>">Banners</a></li>
							<li class="layouts"><a href="<?php echo site_url(ADMIN_URI.'/layouts'); ?>">Layouts</a></li>
							<li class="uri_routes"><a href="<?php echo site_url(ADMIN_URI.'/uri_routes'); ?>">URI Routes</a></li>
							<li class="error_logs"><a href="<?php echo site_url(ADMIN_URI.'/error_logs'); ?>">Error Logs</a></li>
							<li class="settings"><a href="<?php echo site_url(ADMIN_URI.'/settings'); ?>">Settings</a></li>
						</ul>
					</li>
				</ul>

				<ul class="nav navbar-nav navbar-right navbar-user">
					<?php foreach ($menu_shortcuts as $shortcut) { ?>
						<li><a class="<?php echo $shortcut['class']; ?>" href="<?php echo $shortcut['href']; ?>" target="<?php echo $shortcut['target']; ?>">
							<i class="fa <?php echo $shortcut['icon']; ?>"></i><?php echo $shortcut['title']; ?>
						</a></li>
					<?php } ?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown"><?php echo $username; ?>&nbsp;&nbsp;<span class="fa fa-user"></span></a>
						<ul class="dropdown-menu">
							<li><span><b>User:</b> <?php echo $staff_name; ?></span></li>
							<li><span><b>Staff Group:</b> <?php echo $staff_group; ?></span></li>
							<li class="divider"></li>
							<li><a href="<?php echo $staff_edit; ?>"><i class="fa fa-user"></i>Edit Details</a></li>
							<li><a href="<?php echo $logout; ?>"><i class="fa fa-power-off"></i>Logout</a></li>
						</ul>
					</li>
				</ul>
				<?php } ?>
			</div>
		</nav>

			<?php if ($islogged) { ?>
			<div class="page-header well">
				<?php if (isset($back_button)) { ?>
					<?php echo $back_button; ?>
				<?php } ?>

				<h1>
					<?php echo $heading ?>
					<?php if (isset($button_list)) { ?>
						<?php echo $button_list; ?>
					<?php } ?>

					<?php if (isset($icon_list)) { ?>
						<?php echo $icon_list; ?>
					<?php } ?>
				</h1>
			</div>
			<?php } ?>
		<div id="page-wrapper">
			<div class="container-fluid">

