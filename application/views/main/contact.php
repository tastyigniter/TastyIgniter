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
		
		<div id="selectedLocation" class="left" style="width:38%;">
		<div class="img_inner">
		<div class="container_24">
			<h2><?php echo $text_local; ?></h2>	
			<dl id="restaurant-info">
				<dt><h3>
					<address><?php echo $location_name; ?> - <?php echo $location_address_1; ?>, <?php echo $location_city; ?>, <?php echo $location_postcode; ?><br />
					<?php echo $location_telephone; ?></address>
				</h3></dt>
		
				<dd><?php echo $text_open_or_close; ?></span></dd>
				<dd class="review"><?php echo $text_reviews; ?></dd>
			</dl>

			<?php if ($opening_hours) { ?>
			<dl class="opening-hour">
			<dt><?php echo $text_opening_hours; ?></dt>
			<?php foreach ($opening_hours as $opening_hour) { ?>
				<dd>
					<span><?php echo $opening_hour['day']; ?>:</span>
					<?php if ($opening_hour['open'] === '00:00' OR $opening_hour['close'] === '00:00') { ?>
						<?php echo $text_open; ?>
					<?php } else { ?>
						<?php echo $opening_hour['open']; ?> - <?php echo $opening_hour['close']; ?>
					<?php } ?>
				</dd>
			<?php } ?>
			</dl>
			<?php } ?>
		</div>
		</div>
		</div>
		
		<div id="contactForm" class="right" style="width:60%;height:100%;">
		<div class="img_inner">
		<div class="container_24">
			<table class="form">
			<tr>
    			<td class="right"><label for="subject"><b><?php echo $entry_subject; ?></b></label></td>
				<td class="left"><select name="subject">
					<option value="">select a subject</option>
					<?php foreach($subjects as $subject_id => $subject) { ?>
						<option value="<?php echo $subject_id; ?>"><?php echo $subject; ?></option>
					<?php } ?>
				</select><br />
    			<?php echo form_error('subject', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td class="right"><label for="full_name"><b><?php echo $entry_full_name; ?></b></label></td>
				<td class="left"><input type="text" name="full_name" value="<?php echo set_value('full_name'); ?>" class="textfield" /><br />
    			<?php echo form_error('full_name', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td class="right"><label for="email"><b><?php echo $entry_email; ?></b></label></td>
				<td class="left"><input type="text" name="email" value="<?php echo set_value('email'); ?>" class="textfield" /><br />
    			<?php echo form_error('email', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td class="right"><label for="telephone"><b><?php echo $entry_telephone; ?></b></label></td>
				<td class="left"><input type="text" name="telephone" value="<?php echo set_value('telephone'); ?>" class="textfield" /><br />
    			<?php echo form_error('telephone', '<span class="error">', '</span>'); ?></td>
			</tr>
			<tr>
    			<td class="right"><label for="comment"><b><?php echo $entry_comment; ?></b></label></td>
				<td class="left"><textarea name="comment" style="height:180px;width:360px;"><?php echo set_value('comment'); ?></textarea><br />
    			<?php echo form_error('comment', '<span class="error">', '</span>'); ?></td>
			</tr>
			</table>
		</div>   	
		</div>   	
		</div>   	
	</div>
	<div class="buttons">
		<div class="right"><input type="submit" name="submit" value="<?php echo $button_send; ?>" /></div>
	</div>
	</form>		
	<?php } ?>
</div>