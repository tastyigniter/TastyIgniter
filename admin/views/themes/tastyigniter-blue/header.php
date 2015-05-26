<?php
    $this->template->setDocType('html5');
    $this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
    $this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=edge', 'type' => 'equiv'));
    $this->template->setMeta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1', 'type' => 'name'));
    $this->template->setFavIcon('images/favicon.ico');
    $this->template->setStyleTag('css/bootstrap.min.css', 'bootstrap-css', '10');
    $this->template->setStyleTag('css/font-awesome.min.css', 'font-awesome-css', '11');
    $this->template->setStyleTag('css/metisMenu.min.css', 'metis-menu-css', '12');
    $this->template->setStyleTag('css/select2.css', 'select2-css', '13');
    $this->template->setStyleTag('css/select2-bootstrap.css', 'select2-bootstrap-css', '14');
    $this->template->setStyleTag('css/jquery.raty.css', 'jquery-raty-css', '15');
    $this->template->setStyleTag('css/stylesheet.css', 'stylesheet-css', '1000000');

    $this->template->setScriptTag('js/jquery-1.11.2.min.js', 'jquery-js', '1');
    $this->template->setScriptTag('js/bootstrap.min.js', 'bootstrap-js', '10');
    $this->template->setScriptTag('js/metisMenu.min.js', 'metis-menu-js', '11');
    $this->template->setScriptTag('js/select2.js', 'select-2-js', '12');
    $this->template->setScriptTag('js/jquery.raty.js', 'jquery-raty-js', '13');
    $this->template->setScriptTag('js/common.js', 'common-js');

    $site_name 			= $this->config->item('site_name');
    $site_url 			= rtrim(site_url(), '/').'/';
    $base_url 			= base_url();
    $active_menu 		= ($this->uri->rsegment(1)) ? $this->uri->rsegment(1) : ADMINDIR;
    $message_unread 	= $this->user->unreadMessageTotal();
    $islogged 			= $this->user->islogged();
    $username 			= $this->user->getUsername();
    $staff_name 		= $this->user->getStaffName();
    $staff_group 		= $this->user->staffGroup();
    $staff_location		= $this->user->getLocationName();
    $staff_edit 		= site_url('staffs/edit?id='. $this->user->getStaffId());
    $logout 			= site_url('logout');

    $heading 			= get_heading();
    $button_list 		= get_button_list();
    $icon_list 			= get_icon_list();
    $back_button 		= get_back_button();
?>
<?php echo get_doctype(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php echo get_metas(); ?>
	<?php echo get_favicon(); ?>
	<title><?php echo get_title() .' ‹ Administrator Panel ‹ '. $site_name; ?></title>
	<?php echo get_style_tags(); ?>
	<?php echo get_script_tags(); ?>
	<script type="text/javascript">
		var js_site_url = function(str) {
			var strTmp = "<?php echo $site_url; ?>" + str;
			return strTmp;
		}

		var js_base_url = function(str) {
			var strTmp = "<?php echo $base_url; ?>" + str;
			return strTmp;
		}

		var active_menu = '<?php echo $active_menu; ?>';
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('a, span, button').tooltip({placement: 'bottom'});
			$('select.form-control').select2();

			$('.alert').alert();
			$('.dropdown-toggle').dropdown();

			$('.rating-star').raty({
				score: function() {
					return $(this).attr('data-score');
				},
				scoreName: function() {
					return $(this).attr('data-score-name');
				},
				readOnly: function() {
					return $(this).attr('data-readonly') == 'true';
				},
				hints: ['Bad', 'Worse', 'Good', 'Average', 'Excellent'],
				starOff : 'fa fa-star-o',
				starOn : 'fa fa-star',
				cancel : false, half : false, starType : 'i'
			});

			$("#list-form td:contains('Disabled')").addClass('red');
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
    <div id="wrapper" class="<?php echo ($this->user->islogged()) ? '' : 'wrap-none'; ?>">
		<nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?php echo site_url('dashboard'); ?>"><span class="navbar-logo"></span><?php echo $site_name; ?></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<?php if ($islogged) { ?>
                <a role="button" class="sidebar-toggle" data-toggle="offcanvas">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						<a class="front-end" href="<?php echo root_url(); ?>" target="_blank">
							<i class="fa fa-share-square-o"></i>
						</a>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle messages" data-toggle="dropdown" href="<?php echo site_url('messages'); ?>">
							<i class="fa fa-envelope"></i>
                            <span class="label label-danger"><?php echo $message_unread; ?></span>
						</a>
						<ul class="dropdown-menu dropdown-messages">
                            <li class="menu-header"><b>You have <?php echo $message_unread; ?> messages</b></li>
                            <li class="menu-body"></li>
                            <li class="menu-footer">
                                <a class="text-center" href="<?php echo site_url('messages'); ?>">Read All Messages</a>
                            </li>
                        </ul>
                    </li>
					<li class="dropdown">
						<a class="dropdown-toggle alerts" data-toggle="dropdown" href="<?php echo site_url('alerts'); ?>">
							<i class="fa fa-bell"></i>
						</a>
                        <ul class="dropdown-menu  dropdown-alerts">
                            <li class="menu-header"><b>You have 4 alerts</b></li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa fa-tasks fa-fw"></i> New Task
                                                <span class="pull-right text-muted small">4 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#">
                                            <div>
                                                <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                                <span class="pull-right text-muted small">4 minutes ago</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li class="menu-footer">
                                        <a class="text-center" href="<?php echo site_url('notifications'); ?>">See All Notifications</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-footer"></li>
                        </ul>
                    </li>
					<li class="dropdown">
						<a class="dropdown-toggle settings" data-toggle="dropdown" href="<?php echo site_url('settings'); ?>">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu dropdown-settings">
							<li><a href="<?php echo site_url('pages'); ?>">Pages</a></li>
							<li><a href="<?php echo site_url('banners'); ?>">Banners</a></li>
							<li><a href="<?php echo site_url('layouts'); ?>">Layouts</a></li>
							<li><a href="<?php echo site_url('uri_routes'); ?>">URI Routes</a></li>
							<li><a href="<?php echo site_url('error_logs'); ?>">Error Logs</a></li>
							<li><a href="<?php echo site_url('settings'); ?>">Settings</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user"></i>
						</a>
						<ul class="dropdown-menu  dropdown-user">
							<li><span><b>User:</b> <?php echo $staff_name; ?></span></li>
							<li><span><b>Staff Group:</b> <?php echo $staff_group; ?></span></li>
							<li><span><b>Location:</b> <?php echo $staff_location; ?></span></li>
							<li class="divider"></li>
							<li><a href="<?php echo $staff_edit; ?>"><i class="fa fa-user fa-fw"></i>Edit Details</a></li>
							<li><a href="<?php echo $logout; ?>"><i class="fa fa-power-off fa-fw"></i>Logout</a></li>
						</ul>
					</li>
				</ul>

				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
			<!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav side-nav">-->
						<li>
							<a class="dashboard admin" href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
						</li>
						<li>
							<a class="kitchen"><i class="fa fa-cutlery fa-fw"></i>Kitchen <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a class="menus" href="<?php echo site_url('menus'); ?>"><i class="fa fa-square-o fa-fw"></i>Menus</a></li>
								<li><a class="menu_options" href="<?php echo site_url('menu_options'); ?>"><i class="fa fa-square-o fa-fw"></i>Options</a></li>
								<li><a class="categories" href="<?php echo site_url('categories'); ?>"><i class="fa fa-square-o fa-fw"></i>Categories</a></li>
							</ul>
						</li>
						<li>
							<a class="tables" href="<?php echo site_url('tables'); ?>"><i class="fa fa-table fa-fw"></i>Tables</a>
						</li>
						<li>
							<a class="sales"><i class="fa fa-bar-chart-o fa-fw"></i>Sales <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a class="orders" href="<?php echo site_url('orders'); ?>"><i class="fa fa-square-o fa-fw"></i>Orders</a></li>
								<li><a class="reservations" href="<?php echo site_url('reservations'); ?>"><i class="fa fa-square-o fa-fw"></i>Reservations</a></li>
								<li><a class="coupons" href="<?php echo site_url('coupons'); ?>"><i class="fa fa-square-o fa-fw"></i>Coupons</a></li>
								<li><a class="reviews" href="<?php echo site_url('reviews'); ?>"><i class="fa fa-square-o fa-fw"></i>Reviews</a></li>
							</ul>
						</li>
						<li>
							<a class="users"><i class="fa fa-user fa-fw"></i>Users <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a class="customers" href="<?php echo site_url('customers'); ?>"><i class="fa fa-square-o fa-fw"></i>Customers</a></li>
								<li><a class="staffs" href="<?php echo site_url('staffs'); ?>"><i class="fa fa-square-o fa-fw"></i>Staffs</a>
								<li><a class="customer_groups" href="<?php echo site_url('customer_groups'); ?>"><i class="fa fa-square-o fa-fw"></i>Customer Groups</a></li>
								<li><a class="staff_groups" href="<?php echo site_url('staff_groups'); ?>"><i class="fa fa-square-o fa-fw"></i>Staff Groups</a></li>
								<li><a class="customers_online" href="<?php echo site_url('customers_online'); ?>"><i class="fa fa-square-o fa-fw"></i>Customers Online</a></li>
							</ul>
						</li>
						<li>
							<a class="locations" href="<?php echo site_url('locations'); ?>"><i class="fa fa-map-marker fa-fw"></i>Locations</a>
						</li>
						<li>
							<a class="localisation"><i class="fa fa-globe fa-fw"></i>Localisation <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a class="languages" href="<?php echo site_url('languages'); ?>"><i class="fa fa-square-o fa-fw"></i>Languages</a></li>
								<li><a class="currencies" href="<?php echo site_url('currencies'); ?>"><i class="fa fa-square-o fa-fw"></i>Currencies</a></li>
								<li><a class="countries" href="<?php echo site_url('countries'); ?>"><i class="fa fa-square-o fa-fw"></i>Countries</a></li>
								<li><a class="security_questions" href="<?php echo site_url('security_questions'); ?>"><i class="fa fa-square-o fa-fw"></i>Security Questions</a></li>
								<li><a class="ratings" href="<?php echo site_url('ratings'); ?>"><i class="fa fa-square-o fa-fw"></i>Ratings</a></li>
								<li><a class="statuses" href="<?php echo site_url('statuses'); ?>"><i class="fa fa-square-o fa-fw"></i>Statuses</a></li>
							</ul>
						</li>
						<li>
							<a class="extensions"><i class="fa fa-puzzle-piece fa-fw"></i>Extensions <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a class="modules extensions" href="<?php echo site_url('extensions'); ?>"><i class="fa fa-square-o fa-fw"></i>Modules</a></li>
								<li><a class="payments" href="<?php echo site_url('payments'); ?>"><i class="fa fa-square-o fa-fw"></i>Payments</a></li>
							</ul>
						</li>
						<li>
							<a class="themes"><i class="fa fa-paint-brush fa-fw"></i>Design <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a class="layouts" href="<?php echo site_url('layouts'); ?>"><i class="fa fa-square-o fa-fw"></i>Layouts</a></li>
                                <li><a class="themes" href="<?php echo site_url('themes'); ?>"><i class="fa fa-square-o fa-fw"></i>Themes</a></li>
                                <li><a class="banners" href="<?php echo site_url('banners'); ?>"><i class="fa fa-square-o fa-fw"></i>Banners</a></li>
								<li><a class="mail_templates" href="<?php echo site_url('mail_templates'); ?>"><i class="fa fa-square-o fa-fw"></i>Mail Templates</a></li>
								<!--<li><a class="widgets" href="<?php echo site_url('widgets'); ?>"><i class="fa fa-square-o fa-fw"></i>Widgets</a></li>-->
							</ul>
						</li>
						<li>
							<a class="tools"><i class="fa fa-wrench fa-fw"></i>Tools <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a class="image_manager image_options" href="<?php echo site_url('image_manager'); ?>"><i class="fa fa-square-o fa-fw"></i>Image Manager</a></li>
								<li><a class="database" href="<?php echo site_url('database'); ?>"><i class="fa fa-square-o fa-fw"></i>Database</a></li>
							</ul>
						</li>
						<li>
							<a class="system"><i class="fa fa-cog fa-fw"></i>System <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
								<li><a class="pages" href="<?php echo site_url('pages'); ?>"><i class="fa fa-square-o fa-fw"></i>Pages</a></li>
								<li><a class="uri_routes" href="<?php echo site_url('uri_routes'); ?>"><i class="fa fa-square-o fa-fw"></i>URI Routes</a></li>
								<li><a class="error_logs" href="<?php echo site_url('error_logs'); ?>"><i class="fa fa-square-o fa-fw"></i>Error Logs</a></li>
								<li><a class="settings" href="<?php echo site_url('settings'); ?>"><i class="fa fa-square-o fa-fw"></i>Settings</a></li>
							</ul>
						</li>
					</ul>
					</div>
				</div>
			<?php } ?>
		</nav>

		<div id="page-wrapper">
			<?php if ($islogged) { ?>
				<div class="page-header clearfix">
					<div class="page-header-title pull-left">
                        <h1 class="">
                            <?php if (!empty($back_button)) { ?>
                                <?php echo $back_button; ?>
                            <?php } ?>

                            <?php if (count($heading_array = explode(':', $heading)) === 2) { ?>
                                <?php echo $heading_array[0]; ?>&nbsp;&nbsp;<small><?php echo $heading_array[1]; ?></small>
                            <?php } else { ?>
                                <?php echo $heading; ?>
                            <?php } ?>
                        </h1>
					</div>

                    <?php if (!empty($button_list) OR !empty($icon_list)) { ?>
						<div class="page-header-action pull-right">
                            <?php if (!empty($icon_list)) { ?>
                                <?php echo $icon_list; ?>
                            <?php } ?>

                            <?php if (!empty($button_list)) { ?>
                                <?php echo $button_list; ?>
                            <?php } ?>
						</div>
					<?php } ?>
				</div>
				<div id="notification">
					<?php echo $this->alert->display(); ?>
				</div>
			<?php } ?>

