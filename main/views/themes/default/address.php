<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="page-content">
	<div class="container">
<div class="row">
	<?php echo $content_left; ?><?php echo $content_right; ?>

	<div class="col-md-8">
		<div class="address-lists row wrap-all">
		<?php if ($addresses) { ?>
			<?php foreach ($addresses as $address) { ?>
			<div class="address">
				<div class="table-responsive border-bottom">
					<table width="50%" class="form">
					<tr>
						<td><?php echo $address['address']; ?></td>
						<td rowspan="5">
							<input type="checkbox" name="delete" />
							<a class="btn btn-default btn-xs" href="<?php echo $address['edit']; ?>"><?php echo $text_edit; ?></a>
						</td>
					</tr>
					</table>
				</div>
			</div>
			<?php } ?>
		<?php } else { ?>
			<p><?php echo $text_no_address; ?></p>
		<?php } ?>
		</div>

		<div class="row wrap-all">
			<div class="buttons col-xs-6 wrap-none">
				<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_back; ?></a>
				<a class="btn btn-success" href="<?php echo $continue; ?>"><?php echo $button_add; ?></a>
			</div>

			<div class="col-xs-6 wrap-none">
				<div class="pagination-bar text-right">
					<div class="links"><?php echo $pagination['links']; ?></div>
					<div class="info"><?php echo $pagination['info']; ?></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {

  	$('#add-address').on('click', function() {

  	if($('#new-address').is(':visible')){
     	$('#new-address').fadeOut();
	}else{
   		$('#new-address').fadeIn();
	}
	});



});
//--></script>
<?php echo $footer; ?>