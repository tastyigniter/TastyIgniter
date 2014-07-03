<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row content">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-xs-9">
		<div class="row wrap-all">
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th><?php echo $column_subject; ?></th>
							<th><?php echo $column_date; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($messages) {?>
							<?php foreach ($messages as $message) { ?>
							<tr class="<?php echo $message['state']; ?>">
								<td>
									<a class="edit" href="<?php echo $message['view']; ?>"><?php echo $message['subject']; ?></a><br />
									<font size="1"><?php echo $message['body']; ?></font>
								</td>
								<td><?php echo $message['date_added']; ?></td>
							</tr>
							<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="2"><?php echo $text_empty; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="row wrap-all">
			<div class="buttons col-xs-6 wrap-none">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
			</div>
	
			<div class="col-xs-6 wrap-none">
				<div class="pagination-box text-right">
					<?php echo $pagination['links']; ?>
					<div class="pagination-info"><?php echo $pagination['info']; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $footer; ?>