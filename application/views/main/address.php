<div class="content">
	<div class="img_inner">
  		<h3><?php echo $text_heading; ?></h3>
  	</div>  
	<?php if ($addresses) { ?>
  	<div class="address-lists">
		<?php foreach ($addresses as $address) { ?>
		<div class="address">
			<div class="img_inner">
				<table width="50%" class="form">
				<tr>
					<td><?php echo $address['address']; ?></td>
					<td rowspan="5"><input type="checkbox" name="delete"</a> <a href="<?php echo $address['edit']; ?>"><?php echo $text_edit; ?></a></td>
				</tr>    	
				</table>
			</div> 
		</div> 
		<?php } ?>
  	</div>  
	<?php } else { ?>
  		<p><?php echo $text_no_address; ?></p>
	<?php } ?>

	<div class="separator"></div>
	<div class="buttons">
		<div class="left"><a class="button" href="<?php echo $back; ?>"><?php echo $button_back; ?></a></div>
		<div class="right"><a class="button" href="<?php echo $continue; ?>"><?php echo $button_add; ?></a></div>
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