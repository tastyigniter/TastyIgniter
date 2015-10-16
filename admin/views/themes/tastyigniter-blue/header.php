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
    $this->template->setStyleTag('css/fonts.css', 'fonts-css', '16');
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
    $context_help       = get_context_help();
?>
<?php echo get_doctype(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php echo get_metas(); ?>
	<?php echo get_favicon(); ?>
	<title><?php echo sprintf(lang('site_title'), get_title(), $site_name); ?></title>
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
                <a class="navbar-brand hidden-xs sidebar-toggle">
                    <i class="fa fa-bars"></i>
                </a>
            </div>

			<?php if ($islogged) { ?>
 				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						<a class="front-end" href="<?php echo root_url(); ?>" target="_blank">
							<i class="fa fa-home"></i>
						</a>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle messages" data-toggle="dropdown">
							<i class="fa fa-envelope"></i>
                            <span class="label label-danger"><?php echo $message_unread; ?></span>
						</a>
						<ul class="dropdown-menu dropdown-messages">
                            <li class="menu-header"><?php echo sprintf(lang('text_message_count'), $message_unread); ?></li>
                            <li class="menu-body"></li>
                            <li class="menu-footer">
                                <a class="text-center" href="<?php echo site_url('messages'); ?>"><?php echo lang('text_see_all_message'); ?></a>
                            </li>
                        </ul>
                    </li>
					<li class="dropdown">
						<a class="dropdown-toggle alerts" data-toggle="dropdown">
							<i class="fa fa-bell"></i>
						</a>
                        <ul class="dropdown-menu dropdown-activities">
                            <li class="menu-header"><?php echo sprintf(lang('text_activity_count'), '4'); ?></li>
                            <li class="menu-body"></li>
                            <li class="menu-footer">
                                <a class="text-center" href="<?php echo site_url('activities'); ?>"><?php echo lang('text_see_all_activity'); ?></a>
                            </li>
                        </ul>
                    </li>
					<li class="dropdown">
						<a class="dropdown-toggle settings" data-toggle="dropdown">
							<i class="fa fa-cog"></i>
						</a>
						<ul class="dropdown-menu dropdown-settings">
							<li><a href="<?php echo site_url('pages'); ?>"><?php echo lang('menu_page'); ?></a></li>
							<li><a href="<?php echo site_url('banners'); ?>"><?php echo lang('menu_banner'); ?></a></li>
							<li><a href="<?php echo site_url('layouts'); ?>"><?php echo lang('menu_layout'); ?></a></li>
							<li><a href="<?php echo site_url('uri_routes'); ?>"><?php echo lang('menu_uri_route'); ?></a></li>
							<li><a href="<?php echo site_url('error_logs'); ?>"><?php echo lang('menu_error_log'); ?></a></li>
							<li><a href="<?php echo site_url('settings'); ?>"><?php echo lang('menu_setting'); ?></a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user"></i>
						</a>
						<ul class="dropdown-menu  dropdown-user">
							<li><span><b><?php echo lang('text_user'); ?>:</b> <?php echo $staff_name; ?></span></li>
							<li><span><b><?php echo lang('text_staff_group'); ?>:</b> <?php echo $staff_group; ?></span></li>
							<li><span><b><?php echo lang('text_location'); ?>:</b> <?php echo $staff_location; ?></span></li>
							<li class="divider"></li>
							<li><a href="<?php echo $staff_edit; ?>"><i class="fa fa-user fa-fw"></i><?php echo lang('text_edit_details'); ?></a></li>
							<li><a href="<?php echo $logout; ?>"><i class="fa fa-power-off fa-fw"></i><?php echo lang('text_logout'); ?></a></li>
						</ul>
					</li>
				</ul>

				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
							<li>
								<a class="dashboard admin" href="<?php echo site_url('dashboard'); ?>"><i class="fa fa-dashboard fa-fw"></i><span class="content"><?php echo lang('menu_dashboard'); ?></span></a>
							</li>
							<li>
								<a class="kitchen"><i class="fa fa-cutlery fa-fw"></i><span class="content"><?php echo lang('menu_kitchen'); ?></span><span class="fa arrow"></span></a>
	                            <ul class="nav nav-second-level">
									<li><a class="menus" href="<?php echo site_url('menus'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_menu'); ?></a></li>
									<li><a class="menu_options" href="<?php echo site_url('menu_options'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_option'); ?></a></li>
									<li><a class="categories" href="<?php echo site_url('categories'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_category'); ?></a></li>
								</ul>
							</li>
							<li>
								<a class="tables" href="<?php echo site_url('tables'); ?>"><i class="fa fa-table fa-fw"></i><span class="content"><?php echo lang('menu_table'); ?></span></a>
							</li>
							<li>
								<a class="sales"><i class="fa fa-bar-chart-o fa-fw"></i><span class="content"><?php echo lang('menu_sale'); ?> </span><span class="fa arrow"></span></a>
	                            <ul class="nav nav-second-level">
									<li><a class="orders" href="<?php echo site_url('orders'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_order'); ?></a></li>
									<li><a class="reservations" href="<?php echo site_url('reservations'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_reservation'); ?></a></li>
									<li><a class="coupons" href="<?php echo site_url('coupons'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_coupon'); ?></a></li>
									<li><a class="reviews" href="<?php echo site_url('reviews'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_review'); ?></a></li>
								</ul>
							</li>
							<li>
								<a class="users"><i class="fa fa-user fa-fw"></i><span class="content"><?php echo lang('menu_user'); ?> </span><span class="fa arrow"></span></a>
	                            <ul class="nav nav-second-level">
									<li><a class="customers" href="<?php echo site_url('customers'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_customer'); ?></a></li>
									<li><a class="staffs" href="<?php echo site_url('staffs'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_staff'); ?></a>
									<li><a class="customer_groups" href="<?php echo site_url('customer_groups'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_customer_group'); ?></a></li>
									<li><a class="staff_groups" href="<?php echo site_url('staff_groups'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_staff_group'); ?></a></li>
									<li><a class="customers_online" href="<?php echo site_url('customers_online'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_customer_online'); ?></a></li>
								</ul>
							</li>
							<li>
								<a class="locations" href="<?php echo site_url('locations'); ?>"><i class="fa fa-map-marker fa-fw"></i><span class="content"><?php echo lang('menu_location'); ?></span></a>
							</li>
							<li>
								<a class="localisation"><i class="fa fa-globe fa-fw"></i><span class="content"><?php echo lang('menu_localisation'); ?> </span><span class="fa arrow"></span></a>
	                            <ul class="nav nav-second-level">
									<li><a class="languages" href="<?php echo site_url('languages'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_language'); ?></a></li>
									<li><a class="currencies" href="<?php echo site_url('currencies'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_currency'); ?></a></li>
									<li><a class="countries" href="<?php echo site_url('countries'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_country'); ?></a></li>
									<li><a class="security_questions" href="<?php echo site_url('security_questions'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_security_question'); ?></a></li>
									<li><a class="ratings" href="<?php echo site_url('ratings'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_rating'); ?></a></li>
									<li><a class="statuses" href="<?php echo site_url('statuses'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_status'); ?></a></li>
								</ul>
							</li>
							<li>
								<a class="extensions" href="<?php echo site_url('extensions'); ?>"><i class="fa fa-puzzle-piece fa-fw"></i><span class="content"><?php echo lang('menu_extension'); ?> </span></a>
							</li>
							<li>
								<a class="themes"><i class="fa fa-paint-brush fa-fw"></i><span class="content"><?php echo lang('menu_design'); ?> </span><span class="fa arrow"></span></a>
	                            <ul class="nav nav-second-level">
	                                <li><a class="layouts" href="<?php echo site_url('layouts'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_layout'); ?></a></li>
	                                <li><a class="themes" href="<?php echo site_url('themes'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_theme'); ?></a></li>
	                                <li><a class="banners" href="<?php echo site_url('banners'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_banner'); ?></a></li>
									<li><a class="mail_templates" href="<?php echo site_url('mail_templates'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_mail_template'); ?></a></li>
								</ul>
							</li>
							<li>
								<a class="tools"><i class="fa fa-wrench fa-fw"></i><span class="content"><?php echo lang('menu_tool'); ?> </span><span class="fa arrow"></span></a>
	                            <ul class="nav nav-second-level">
									<li><a class="image_manager image_options" href="<?php echo site_url('image_manager'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_media_manager'); ?></a></li>
									<li><a class="maintenance" href="<?php echo site_url('maintenance'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_maintenance'); ?></a></li>
								</ul>
							</li>
							<li>
								<a class="system"><i class="fa fa-cog fa-fw"></i><span class="content"><?php echo lang('menu_system'); ?></span> <span class="fa arrow"></span></a>
	                            <ul class="nav nav-second-level">
									<li><a class="pages" href="<?php echo site_url('pages'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_page'); ?></a></li>
	                                <li><a class="permissions" href="<?php echo site_url('permissions'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_permission'); ?></a></li>
	                                <li><a class="uri_routes" href="<?php echo site_url('uri_routes'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_uri_route'); ?></a></li>
									<li><a class="error_logs" href="<?php echo site_url('error_logs'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_error_log'); ?></a></li>
									<li><a class="settings" href="<?php echo site_url('settings'); ?>"><i class="fa fa-square-o fa-fw"></i><?php echo lang('menu_setting'); ?></a></li>
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
                            <?php echo get_heading(); ?>

                            <?php if (!empty($context_help)) { ?>
                                <a class="btn btn-help" role="button" data-toggle="collapse" href="#context-help-wrap" title="<?php echo lang('text_help'); ?>">
                                    <i class="fa fa-question-circle"></i>
                                </a>
                            <?php } ?>
                        </h1>
					</div>

                    <?php
                        $button_list = get_button_list();
                        $icon_list = get_icon_list();
                    ?>

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

				<?php if (!empty($context_help)) { ?>
					<div class="collapse" id="context-help-wrap">
						<div class="well"><?php echo $context_help; ?></div>
					</div>
				<?php } ?>

				<div id="notification">
					<?php echo $this->alert->display(); ?>
				</div>
			<?php } ?>

