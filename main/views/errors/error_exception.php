<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div style="border: 1px solid #b3b3b3;padding: 0 20px;margin:0 0 10px 0;overflow: auto;background-color: #FFF;font-weight: normal;font-size: 12px;text-align: left;">

	<h4>An uncaught Exception was encountered</h4>

	<p style="margin-left:0">Type: <?php echo get_class($exception); ?></p>
	<p style="margin-left:0">Message: <?php echo $message; ?></p>
	<p style="margin-left:0">Filename: <?php echo $exception->getFile(); ?></p>
	<p style="margin-left:0">Line Number: <?php echo $exception->getLine(); ?></p>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

		<p style="margin-left:0">Backtrace:</p>
		<?php foreach ($exception->getTrace() as $error): ?>

			<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

				<p style="margin-left:10px">
					File: <?php echo $error['file']; ?><br />
					Line: <?php echo $error['line']; ?><br />
					Function: <?php echo $error['function']; ?>
				</p>
			<?php endif ?>

		<?php endforeach ?>

	<?php endif ?>

</div>