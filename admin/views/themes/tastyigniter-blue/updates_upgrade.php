<?php echo $this->template->getDocType() ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<?php echo $this->template->getMetas() ?>
	<title><?php echo lang('text_title'); ?></title>
	<?php echo $this->template->getStyleTags() ?>
	<?php echo $this->template->getScriptTags() ?>
	<style>
		html, body {
			height: auto;
		}
		body {
			background-color: #ECF0F5;
		}
		.fa {
			color: #999;
		}
	</style>
	<script type="text/javascript">
		var js_site_url = function(str) {
			var strTmp = "<?php echo site_url('" + str + "'); ?>";
			return strTmp;
		};

		var js_base_url = function(str) {
			var strTmp = "<?php echo base_url('" + str + "'); ?>";
			return strTmp;
		}
	</script>
</head>
<body>
<p><?php echo lang('text_update_start'); ?></p>
