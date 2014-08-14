<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-8 page-content">
		<div class="row wrap-all">
			<div class="table-responsive">
				<table class="table table-none">
					<tr>
						<td width="20%"><b><?php echo $column_date; ?>:</b></td>
						<td><?php echo $date_added; ?></td>
					</tr>
					<tr>
						<td><b><?php echo $column_subject; ?>:</b></td>
						<td><?php echo $subject; ?></td>
					</tr>
					<tr>
						<td colspan="2"><div class="msg_body"><?php echo $body; ?></div></td>
					</tr>
				</table>
			</div>
		</div>

		<div class="row wrap-all">
			<div class="buttons">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>