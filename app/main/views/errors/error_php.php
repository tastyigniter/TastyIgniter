<?php defined('BASEPATH') OR exit('No direct script access allowed');
if (is_cli()) { ?>
	A PHP Error was encountered

	Severity: <?php echo $severity;?>
	Message:  <?php echo $message;?>
	Filename: <?php echo $filepath;?>
	Line Number: <?php echo $line;?>

	<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

		Backtrace:
		<?php foreach (debug_backtrace() as $error): ?>
			<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

				File: <?php echo $error['file'];?>
				Line: <?php echo $error['line'];?>
				Function: <?php echo $error['function'];?>

			<?php endif ?>

		<?php endforeach ?>
	<?php endif ?>
<?php } else { ?>

	<div class="error error-php" style="border: 1px solid #b3b3b3;padding: 0 20px;margin:0 20px 20px;overflow: auto;background-color: #FFF;font-weight: normal;font-size: 12px;text-align: left;">

		<h4>A PHP Error was encountered</h4>

		<p style="margin-left:0">Severity:</strong> <?php echo $severity; ?></p>
		<p style="margin-left:0"><strong>Message:</strong>  <?php echo $message; ?></p>
		<p style="margin-left:0"><strong>Filename:</strong> <?php echo $filepath; ?></p>
		<p style="margin-left:0"><strong>Line Number:</strong> <?php echo $line; ?></p>

		<?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE === TRUE): ?>

			<p style="margin-left:0"><strong>Backtrace:</strong></p>
			<?php foreach (debug_backtrace() as $error): ?>

				<?php if (isset($error['file']) && strpos($error['file'], realpath(BASEPATH)) !== 0): ?>

					<p style="margin-left:10px">
						File: <?php echo $error['file'] ?><br />
						Line: <?php echo $error['line'] ?><br />
						Function: <?php echo $error['function'] ?>
					</p>

				<?php endif ?>

			<?php endforeach ?>

		<?php endif ?>

	</div>
<?php } ?>