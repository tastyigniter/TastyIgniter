<?php echo get_header(); ?>
<div id="page-content">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="heading-section">
					<h2><?php echo $text_greetings; ?></h2>
                    <span class="under-heading"></span>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="wrap-all">
				<div class="table-responsive">
					<table class="table table-none confirmation text-center">
						<!--<tr>
							<td><?php echo $text_greetings; ?><br /><br /></td>
						</tr>-->
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
	</div>
</div>
<?php echo get_footer(); ?>