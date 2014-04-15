<div class="content">
	<div class="wrap">
	<form method="GET" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="find-form">
		<div class="find_table" style="display:<?php echo ($show_times) ? 'none' : 'block'; ?>">
			<h4><?php echo $text_find_msg; ?></h4>
			<table border="0" cellpadding="2" width="60%" class="form">
			<tr>
				<td><label for="location">Select Location:</label></td>
				<td><select name="location">
					<?php foreach ($locations as $location) { ?>
					<?php if ($location['id'] === $location_id) { ?>
						<option value="<?php echo $location['id']; ?>" <?php echo set_select('location', $location['id'], TRUE); ?>><?php echo $location['name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $location['id']; ?>" <?php echo set_select('location', $location['id']); ?>><?php echo $location['name']; ?></option>
					<?php } ?>
					<?php } ?>
				<?php echo form_error('location', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="guest_num"><?php echo $entry_no_guest; ?></label></td>
				<td>
				<?php if ($guest_nums) { ?>
					<select name="guest_num">
					<?php foreach ($guest_nums as $key => $value) { ?>
					<?php if ($value === $guest_num) { ?>
						<option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value, TRUE); ?>><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value); ?>><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
					</select>
				<?php } else { ?>
					<span><?php echo $text_no_table; ?></span>
				<?php } ?><br />
					<?php echo form_error('guest_num', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="reserve_date"><?php echo $entry_date; ?></label></td>
				<td><input type="text" name="reserve_date" id="date" value="<?php echo set_value('reserve_date', $date); ?>" class="textfield" size="10" /><br />
					<?php echo form_error('reserve_date', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			<tr>
				<td><label for="occasion"><?php echo $entry_occassion; ?></label></td>
				<td><select name="occasion">
					<?php foreach ($occasions as $key => $value) { ?>
					<?php if ($key == $occasion) { ?>
						<option value="<?php echo $key; ?>" <?php echo set_select('occasion', $key, TRUE); ?>><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>" <?php echo set_select('occasion', $key); ?>><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
				</select><br />
					<?php echo form_error('occasion', '<span class="error">', '</span>'); ?>
				</td>
			</tr>
			</table>
			<div class="buttons" style="width:50%;margin:0;">
				<div class="right"><a class="button" onclick="$('#find-form').submit();"><?php echo $button_find; ?></a></div>
			</div>
		</div>
		<?php if ($show_times) { ?>
		<div class="time_table">
			<h4><?php echo $text_time_msg; ?></h4>
			<ul class="times">
				<?php foreach ($reserve_times as $reserve_time) { ?>
				<?php if ($reserve_time['24hr'] == $time) { ?>
					<li><input type="radio" name="reserve_time" value="<?php echo $reserve_time['24hr']; ?>" checked="checked"/><?php echo $reserve_time['24hr']; ?></li>
				<?php } else { ?>
					<li><input type="radio" name="reserve_time" value="<?php echo $reserve_time['24hr']; ?>"/><?php echo $reserve_time['24hr']; ?></li>
				<?php } ?>
				<?php } ?>
			</ul>
			<div class="buttons" style="width:50%;margin:0;">
				<div class="left"><a class="button" onclick="$('.find_table').show();$('.time_table').empty();"><?php echo $button_back; ?></a></div>
				<div class="right"><a class="button" onclick="$('#find-form').submit();"><?php echo $button_time; ?></a></div>
			</div>
		</div>
		<?php } ?>
	</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#check-postcode').on('click', function() {
		$('.check-local').fadeIn();
		$('.display-local').fadeOut();
	});	

	$('#date').datepicker({
		dateFormat: 'dd-mm-yy',
	});
});
//--></script>