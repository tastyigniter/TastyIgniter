<div id="local-box">
	<h3><?php echo $text_local; ?></h3>	
	<div id="local-info">
	<div class="display-local" style="display: <?php echo ($local_info ? 'block' : 'none'); ?>">
		<font size="3"><?php echo $local_info['location_name']; ?></font><br />  	
		<address><?php echo $local_info['location_address_1']; ?>, <?php echo $local_info['location_city']; ?>, <?php echo $local_info['location_postcode']; ?></address> 	
		<?php echo $local_info['location_telephone']; ?><br /><br />
		
		<span class="is-open"><?php echo $text_open_or_close; ?></span><br />
		<span class=""><?php echo $text_delivery; ?></span><br />
		<span class=""><?php echo $text_collection; ?></span><br />
		<span class=""><?php echo $text_delivery_charge; ?>: <?php echo $delivery_charge; ?></span><br />
		<span class=""><?php echo $text_min_total; ?>: <?php echo $min_total; ?></span>
	
		<a onclick="clearLocal();" id="check-postcode"><?php echo $button_check_postcode; ?></a>

	</div>

	<div class="check-local" style="display: <?php echo ($local_info ? 'none' : 'block'); ?>">
	<form id="location-form" method="POST" action="<?php echo site_url('main/local_module/distance'); ?>">
		<font size="1"><?php echo $text_postcode_warning; ?></font><br /><br />
		<label for="postcode"><b><?php echo $text_postcode; ?></b></label>
		<input type="text" id="postcodeInput" name="postcode" value="<?php echo $postcode; ?>" size="20" />
		<input type="button" onclick="searchLocal();" value="<?php echo $text_find; ?>" />
	</form>
	</div>
	</div>
</div>