<?php echo get_header(); ?>
<div class="row page-heading"><h3><?php echo $text_heading; ?></h3></div>
<div class="row">
	<div class="wrap-all">
		<div class="table-responsive">
			<table class="table table-none confirmation">
				<tr>
					<td><?php echo $text_greetings; ?><br /><br /></td>
				</tr>
				<tr>
					<td><?php echo $text_success; ?></td>
				</tr>
				<tr>
					<td><br /><?php echo $text_signature; ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>