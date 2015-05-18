<?php echo get_header(); ?>
<?php
	if (!empty($extension)) {
//		echo Modules::run($extension_path, $extension_options);
		echo $extension;
	}
?>
<?php echo get_footer(); ?>