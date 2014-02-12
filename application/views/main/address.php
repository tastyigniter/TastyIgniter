<div class="content">
	<div class="wrap">
	<?php if ($addresses) { ?>
  	<div class="address-lists">
	<?php foreach ($addresses as $address) { ?>
  	<div class="address">
	<div class="img_inner">
  		<table width="50%" class="form">
	    <tr>
            <td align="right"><b><?php echo $entry_address_1; ?></b></td>
            <td><?php echo $address['address_1']; ?></td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_address_2; ?></b></td>
            <td><?php echo $address['address_2']; ?></td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_city; ?></b></td>
            <td><?php echo $address['city']; ?></td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_postcode; ?></b></td>
            <td><?php echo $address['postcode']; ?></td>
    	</tr>
        <tr>
            <td align="right"><b><?php echo $entry_country; ?></b></td>
            <td><?php echo $address['country']; ?></td>
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
	</div>

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