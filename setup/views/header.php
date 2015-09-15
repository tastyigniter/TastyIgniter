<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo sprintf(lang('text_title'), $text_heading); ?></title>
	<link type="image/ico" rel="shortcut icon" href="<?php echo base_url('views/assets/favicon.ico'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/bootstrap.min.css'); ?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/bootstrap-theme.min.css'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/font-awesome.css'); ?>">
	<link type="text/css" rel="stylesheet" href="<?php echo base_url('views/assets/stylesheet.css'); ?>">
</head>
<body>
	<div class="container-fluid">
		<div class="page-header"><h1><?php echo $text_heading; ?></h1></div>
			<div class="row">
				<div class="col-md-7 setup_box">
					<div class="content">
						<div id="notification">
							<?php echo $this->alert->display(); ?>
						</div>
