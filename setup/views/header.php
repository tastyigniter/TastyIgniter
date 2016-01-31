<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo sprintf(lang('text_title'), $text_heading); ?></title>
	<link type="image/ico" rel="shortcut icon" href="<?php echo base_url('views/assets/favicon.ico'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/bootstrap.min.css'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/font-awesome.min.css'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/fonts.css'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/stylesheet.css'); ?>">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7 center-block">
				<div class="row page-header">
					<div class="col-xs-12 col-md-4 navbar-right">
						<img src="<?php echo base_url('views/assets/tastyigniter-logo.png'); ?>" alt="TastyIgniter Logo">
					</div>
					<div class="col-xs-12 col-md-8">
						<h1><?php echo $text_heading; ?></h1>
						<p><?php echo $text_sub_heading; ?></p>
					</div>
				</div>

				<div class="row bs-wizard" style="border-bottom:0;">
					<div class="col-xs-2 bs-wizard-step <?php if (in_array($setup_step, array('requirements', 'database', 'settings', 'success'))) echo "complete"; ?>">
						<div class="progress"><div class="progress-bar"></div></div>
						<span class="bs-wizard-dot"></span>
					</div>
					<div class="col-xs-3 bs-wizard-step <?php if (in_array($setup_step, array('database', 'settings', 'success'))) echo "complete"; ?>">
						<div class="progress"><div class="progress-bar"></div></div>
						<span class="bs-wizard-dot"></span>
					</div>
					<div class="col-xs-3 bs-wizard-step <?php if (in_array($setup_step, array('settings', 'success'))) echo "complete"; ?>">
						<div class="progress"><div class="progress-bar"></div></div>
						<span class="bs-wizard-dot"></span>
					</div>
					<div class="col-xs-2 bs-wizard-step <?php if (in_array($setup_step, array('success'))) echo "complete"; ?>">
						<div class="progress"><div class="progress-bar"></div></div>
						<span class="bs-wizard-dot"></span>
					</div>
					<div class="col-xs-2 bs-wizard-step <?php if (in_array($setup_step, array('success'))) echo "complete"; ?>">
						<div class="progress"><div class="progress-bar"></div></div>
						<span class="bs-wizard-dot"></span>
					</div>
				</div>

				<div class="row setup_box">
					<div class="content">
						<div id="notification">
							<?php echo $this->alert->display(); ?>
						</div>
