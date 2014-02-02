<div class="content">
	<div id="search-location">
	<form id="location-form" method="POST" action="<?php echo site_url('main/local_module/distance'); ?>">
		<label for="postcode"><b><?php echo $text_postcode; ?></b></label><br />
  		<input type="text" id="postcodeInput" name="postcode" size="20" value="<?php echo $postcode; ?>">
    	<input type="button" id="search" onclick="$('#location-form').submit();"value="<?php echo $text_find; ?>"/>
	</form>
	</div>

	<?php if ($local_location) { ?>
	<form accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
	<div class="search-content" style="display: block;">
		
		<div id="selectedLocation" class="left" style="width:30%;">
			<h2><?php echo $text_local; ?></h2>	
			<div id="restaurant-info">
				<h4><?php echo $location_name; ?></h4>  	
				<address><?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?></address> 	
				<?php echo $location_telephone; ?><br /><br />
		
				<span class="is-open"><?php echo $text_open_or_close; ?></span><br /><br />
				<div class="review"><?php echo $text_reviews; ?></div><br />
			</div>

			<?php if ($opening_hours) { ?>
			<div class="opening-hour">
			<b><?php echo $text_opening_hours; ?></b>
			<table width="50%">
			<?php foreach ($opening_hours as $opening_hour) { ?>
				<tr>
					<td><?php echo $opening_hour['day']; ?>:</td>
					<?php if ($opening_hour['open'] !== '00:00' || $opening_hour['close'] !== '00:00') { ?>
						<td><?php echo $opening_hour['open']; ?> - <?php echo $opening_hour['close']; ?></td>
					<?php } else { ?>
						<td><?php echo $text_close; ?></td>
					<?php } ?>
				</tr>
			<?php } ?>
			</table>
			</div>
			<?php } ?>
		</div>
		
		<div id="contactForm" class="right" style="width:64%;">
			<table class="form">
			<tr>
    			<td align="right"><label for="subject"><b><?php echo $entry_subject; ?></b></label></td>
				<td><select name="subject">
					<option value="">select a subject</option>
					<?php foreach($subjects as $subject_id => $subject) { ?>
						<option value="<?php echo $subject_id; ?>"><?php echo $subject; ?></option>
					<?php } ?>
				</select><br />
    			<?php echo form_error('subject', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td align="right"><label for="full_name"><b><?php echo $entry_full_name; ?></b></label></td>
				<td><input type="text" name="full_name" value="<?php echo set_value('full_name'); ?>" class="textfield" /><br />
    			<?php echo form_error('full_name', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td align="right"><label for="email"><b><?php echo $entry_email; ?></b></label></td>
				<td><input type="text" name="email" value="<?php echo set_value('email'); ?>" class="textfield" /><br />
    			<?php echo form_error('email', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td align="right"><label for="telephone"><b><?php echo $entry_telephone; ?></b></label></td>
				<td><input type="text" name="telephone" value="<?php echo set_value('telephone'); ?>" class="textfield" /><br />
    			<?php echo form_error('telephone', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td align="right"><label for="comment"><b><?php echo $entry_comment; ?></b></label></td>
				<td><textarea name="comment" style="height:180px;width:360px;"><?php echo set_value('comment'); ?></textarea><br />
    			<?php echo form_error('comment', '<span class="error">', '</span>'); ?></td>
			</tr>
			</table>
		</div>   	
	</div>
	<div class="buttons">
		<div class="right"><input type="submit" name="submit" value="<?php echo $button_send; ?>" /></div>
	</div>
	</form>		
	<?php } ?>
</div>