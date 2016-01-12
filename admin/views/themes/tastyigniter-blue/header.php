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
	$this->template->setScriptTag(root_url('assets/js/js.cookie.js'), 'js-cookie-js', '14');
	$this->template->setScriptTag('js/metisMenu.min.js', 'metis-menu-js', '11');
	$this->template->setScriptTag('js/select2.js', 'select-2-js', '12');
	$this->template->setScriptTag('js/jquery.raty.js', 'jquery-raty-js', '13');
	$this->template->setScriptTag('js/common.js', 'common-js');

	$site_logo          = base_url('views/themes/tastyigniter-blue/images/tastyigniter-logo.png');
    $system_name 		= lang('tastyigniter_system_name');
    $site_name 		    = config_item('site_name');
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

	$wrapper_class = '';
	if (!$this->user->islogged()) {
		$wrapper_class .= 'wrap-none';
	}

	if ($this->input->cookie('sidebarToggleState') == 'hide') {
		$wrapper_class .= ' hide-sidebar';
	}
?>
<?php echo get_doctype(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php echo get_metas(); ?>
	<?php echo get_favicon(); ?>
	<title><?php echo sprintf(lang('site_title'), get_title(), $site_name, $system_name); ?></title>
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
    <div id="wrapper" class="<?php echo $wrapper_class; ?>">
		<nav class="navbar navbar-static-top navbar-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
				<div class="navbar-brand">
					<div class="navbar-logo">
						<img class="navbar-logo" alt="<?php echo $system_name; ?>" title="<?php echo $system_name; ?>" src="<?php echo $site_logo; ?>"/>
					</div>
					<div class="navbar-sitename">
						<a href="<?php echo site_url('dashboard'); ?>"><?php echo $site_name; ?></a>
					</div>
				</div>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
            </div>

			<?php if ($islogged) { ?>
 				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown">
						<a class="updates" title="<?php echo lang('menu_updates'); ?>" href="<?php echo site_url('updates'); ?>">
							<i class="fa fa-refresh"></i>
							<span class="label label-danger"></span>
						</a>
					</li>
					<li class="dropdown">
						<a class="front-end" title="<?php echo lang('menu_storefront'); ?>" href="<?php echo root_url(); ?>" target="_blank">
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
<!--							<li><a href="--><?php //echo site_url('uri_routes'); ?><!--">--><?php //echo lang('menu_uri_route'); ?><!--</a></li>-->
							<li><a href="<?php echo site_url('error_logs'); ?>"><?php echo lang('menu_error_log'); ?></a></li>
							<li><a href="<?php echo site_url('settings'); ?>"><?php echo lang('menu_setting'); ?></a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-user"></i>
						</a>
						<ul class="dropdown-menu  dropdown-user">
							<li>
								<div class="row wrap-vertical">
									<div class="col-xs-4 wrap-top">
										<img class="img-rounded img-responsive" src="<?php echo base_url('views/themes/tastyigniter-blue/images/avatar_2x.png'); ?>" width="53px">
									</div>
									<div class="col-xs-8 wrap-none wrap-right">
										<h4><?php echo $staff_name; ?></h4><span class="small"><i>(<?php echo $username; ?>)</i></span>
										<span class="small text-uppercase"><?php echo $staff_group; ?></span>
										<span><?php echo $staff_location; ?></span>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<li><a href="<?php echo $staff_edit; ?>"><i class="fa fa-user fa-fw"></i><?php echo lang('text_edit_details'); ?></a></li>
							<li><a href="<?php echo $logout; ?>"><i class="fa fa-power-off fa-fw"></i><?php echo lang('text_logout'); ?></a></li>
						</ul>
					</li>
				</ul>

				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<?php echo get_nav_menu(array(
	                        'container_open'    => '<ul class="nav" id="side-menu">',
	                        'container_close'   => '</ul>',
                        )); ?>
					</div>
				</div>
			<?php } ?>
		</nav>

		<div id="page-wrapper">
			<?php if ($islogged) { ?>
				<div class="page-header clearfix">
                    <?php
                        $button_list = get_button_list();
                        $icon_list = get_icon_list();
                    ?>

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

