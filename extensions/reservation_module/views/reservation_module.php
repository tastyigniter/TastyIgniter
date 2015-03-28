<div id="reservation-box" class="module-box">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title find-table-box" style="display:<?php echo (!$show_reserve AND !$show_times) ? 'block' : 'none'; ?>"><?php echo $text_heading; ?></h3>
			<h3 class="panel-title time-table-box" style="display:<?php echo ($show_times) ? 'block' : 'none'; ?>"><?php echo $text_heading_time; ?></h3>
			<h3 class="panel-title reserve-table-box" style="display:<?php echo ($show_reserve) ? 'block' : 'none'; ?>"><?php echo $text_reservation; ?></h3>
		</div>

		<div class="panel-body find-table-box" style="display:<?php echo (!$show_reserve AND !$show_times) ? 'block' : 'none'; ?>">
			<?php echo $text_find_msg; ?>
		</div>

		<div class="panel-body time-table-box" style="display:<?php echo ($show_times) ? 'block' : 'none'; ?>">
			 <?php echo $text_time_msg; ?>
		</div>

		<div class="wrap-vertical reservation-alert" style="display:<?php echo ($reservation_alert) ? 'block' : 'none'; ?>">
			<div id="reservation-alert">
				<div class="alert alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $reservation_alert; ?>
				</div>
			</div>
		</div>

		<div id="find" style="display:<?php echo (!$show_reserve) ? 'block' : 'none'; ?>">
		<form method="GET" accept-charset="utf-8" action="<?php echo current_url(); ?>" id="find-table-form" role="form">
			<div class="find-table-box wrap-vertical" style="display:<?php echo (!$show_times) ? 'block' : 'none'; ?>">
				<div class="form-group">
					<label for="location"><?php echo $entry_location; ?></label>
					<select name="location" id="location" class="form-control">
						<?php foreach ($locations as $location) { ?>
						<?php if ($location['id'] === $location_id) { ?>
							<option value="<?php echo $location['id']; ?>" <?php echo set_select('location', $location['id'], TRUE); ?>><?php echo $location['name']; ?></option>
						<?php } else { ?>
							<option value="<?php echo $location['id']; ?>" <?php echo set_select('location', $location['id']); ?>><?php echo $location['name']; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<?php echo form_error('location', '<span class="text-danger">', '</span>'); ?>
				</div>
				<div class="form-group">
					<label for="guest-num"><?php echo $entry_guest_num; ?></label>
					<?php if ($guest_nums) { ?>
						<select name="guest_num" id="guest-num" class="form-control">
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
					<?php } ?>
					<?php echo form_error('guest_num', '<span class="text-danger">', '</span>'); ?>
				</div>
				<div class="form-group">
					<label for="date"><?php echo $entry_date; ?></label>
					<div class="input-group">
						<input type="text" name="reserve_date" id="date" class="form-control" value="<?php echo set_value('reserve_date', $date); ?>" />
						<span id="discount-addon" class="input-group-addon"><i class="fa fa-calendar"></i></span>
					</div>
					<?php echo form_error('reserve_date', '<span class="text-danger">', '</span>'); ?>
				</div>
				<div class="form-group">
					<label for="occasion"><?php echo $entry_occassion; ?></label>
					<select name="occasion" id="occasion" class="form-control">
						<?php foreach ($occasions as $key => $value) { ?>
						<?php if ($key === $occasion) { ?>
							<option value="<?php echo $key; ?>" <?php echo set_select('occasion', $key, TRUE); ?>><?php echo $value; ?></option>
						<?php } else { ?>
							<option value="<?php echo $key; ?>" <?php echo set_select('occasion', $key); ?>><?php echo $value; ?></option>
						<?php } ?>
						<?php } ?>
					</select>
					<?php echo form_error('occasion', '<span class="text-danger">', '</span>'); ?>
				</div>

				<div class="buttons wrap-horizontal">
					<a class="btn btn-default" href="<?php echo $back; ?>"><?php echo $button_reset; ?></a>
					<button type="submit" class="btn btn-primary"><?php echo $button_find; ?></button>
				</div>
			</div>

			<div class="time-table-box wrap-vertical" style="display:<?php echo ($show_times) ? 'block' : 'none'; ?>">
				<?php if ($reserve_times) { ?>
					<div id="times" class="btn-group" data-toggle="buttons">
					<?php for ($i = 0; $i < count($reserve_times); $i++) { ?>
						<?php if ($reserve_times[$i]['24hr'] == $time) { ?>
							<label class="btn btn-default col-xs-6 col-sm-3 active">
								<input type="radio" name="reserve_time" id="reserve_time<?php echo $i; ?>" value="<?php echo $reserve_times[$i]['24hr']; ?>" checked="checked"/><?php echo $reserve_times[$i]['24hr']; ?>
							</label>
						<?php } else { ?>
							<label class="btn btn-default col-xs-6 col-sm-3">
								<input type="radio" name="reserve_time" id="reserve_time<?php echo $i; ?>" value="<?php echo $reserve_times[$i]['24hr']; ?>"/><?php echo $reserve_times[$i]['24hr']; ?>
							</label>
						<?php } ?>
					<?php } ?>
					</div>
					<br /><br />
				<?php } ?>

				<div class="buttons wrap-horizontal">
					<a class="btn btn-default" onclick="backToFind();"><?php echo $button_back; ?></a>
					<button type="submit" class="btn btn-primary" style="display:<?php echo ($reserve_times) ? 'inline-block' : 'none'; ?>"><?php echo $button_time; ?></button>
				</div>
			</div>
		</form>
		</div>

		<?php if ($show_reserve) { ?>
			<div class="reserve-table-box wrap-all">
				<table class="table table-none">
					<tbody>
						<tr>
							<td><b><?php echo $entry_location; ?></b></td>
							<td><?php echo $location_name; ?></td>
						</tr>
						<tr>
							<td><b><?php echo $entry_guest_num; ?></b></td>
							<td><?php echo $guest_num; ?></td>
						</tr>
						<tr>
							<td><b><?php echo $entry_date; ?></b></td>
							<td><?php echo $reserve_date; ?></td>
						</tr>
						<tr>
							<td><b><?php echo $entry_time; ?></b></td>
							<td><?php echo $reserve_time; ?></td>
						</tr>
						<tr>
							<td><b><?php echo $entry_occassion; ?></b></td>
							<td><?php echo $occasion; ?></td>
						</tr>
					</tbody>
				</table>

				<div class="buttons">
					<a class="btn btn-default" onclick="backToTime();"><?php echo $button_back; ?></a>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<link type="text/css" rel="stylesheet" href="<?php echo base_url("assets/js/datepicker/datepicker.css"); ?>">
<script type="text/javascript" src="<?php echo base_url("assets/js/datepicker/bootstrap-datepicker.js"); ?>"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('#check-postcode').on('click', function() {
		$('.check-local').fadeIn();
		$('.display-local').fadeOut();
	});

	$('#date').datepicker({
		format: 'dd-mm-yyyy',
	});
});

function backToTime() {
	$('#find, .time-table-box').fadeIn();
	$('.find-table-box').fadeOut();
	$('.reserve-table-box').fadeOut();
	$('.reservation-alert').fadeOut();
}

function backToFind() {
	$('#find, .find-table-box').fadeIn();
	$('.time-table-box').fadeOut();
	$('#times').empty();
	$('.reservation-alert').fadeOut();
}
//--></script>