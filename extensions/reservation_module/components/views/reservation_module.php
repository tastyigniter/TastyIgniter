<div id="reservation-box" class="module-box">
    <div class="container top-spacing">
        <div id="reservation-alert">
            <div class="reservation-alert"></div>
            <?php if (!empty($reservation_alert)) { ?>
                <?php echo $reservation_alert; ?>
            <?php } ?>
        </div>

        <form method="GET" accept-charset="utf-8" action="<?php echo $current_url; ?>" id="find-table-form" role="form">
            <input type="hidden" name="action" value="<?php echo $find_table_action; ?>"/>
            <div class="panel panel-default panel-find-table" style="margin-bottom:0;display:<?php echo ($find_table_action === 'find_table') ? 'block' : 'none'; ?>">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo lang('text_heading'); ?></h3>
                </div>

                <div class="panel-body">
                    <div class="col-xs-12">
                        <?php echo lang('text_find_msg'); ?>
                    </div>

                    <div class="col-xs-12 col-sm-8">
                        <div class="form-group">
                            <div class="col-xs-12 col-sm-3 wrap-none <?php echo (form_error('location')) ? 'has-error' : ''; ?>">
                                <label class="sr-only" for="location"><?php echo lang('label_location'); ?></label>
                                <select name="location" id="location" class="form-control">
                                    <?php foreach ($locations as $location) { ?>
                                        <?php if ($location['id'] === $location_id) { ?>
                                            <option value="<?php echo $location['id']; ?>" <?php echo set_select('location', $location['id'], TRUE); ?>><?php echo $location['name']; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $location['id']; ?>" <?php echo set_select('location', $location['id']); ?>><?php echo $location['name']; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-xs-12 col-sm-3 wrap-none <?php echo (form_error('guest_num')) ? 'has-error' : ''; ?>">
                                <label class="sr-only" for="guest-num"><?php echo lang('label_guest_num'); ?></label>
                                <?php if ($guest_numbers) { ?>
                                    <select name="guest_num" id="guest-num" class="form-control">
                                        <?php foreach ($guest_numbers as $key => $value) { ?>
                                            <?php if ($value === $guest_num) { ?>
                                                <option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value, TRUE); ?>><?php echo $value; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $value; ?>" <?php echo set_select('guest_num', $value); ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                <?php } else { ?>
                                    <span><?php echo lang('text_no_table'); ?></span>
                                <?php } ?>
                            </div>
                            <div class="col-xs-12 col-sm-3 wrap-none <?php echo (form_error('reserve_date')) ? 'has-error' : ''; ?>">
                                <label class="sr-only" for="date"><?php echo lang('label_date'); ?></label>
                                <div class="input-group">
                                    <input type="text" name="reserve_date" id="date" class="form-control" value="<?php echo set_value('reserve_date', $date); ?>" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 wrap-none <?php echo (form_error('reserve_time')) ? 'has-error' : ''; ?>">
                                <label class="sr-only" for="time"><?php echo lang('label_time'); ?></label>
	                            <?php if ($reservation_times) { ?>
		                            <select name="reserve_time" id="time" class="form-control">
			                            <?php foreach ($reservation_times as $key => $value) { ?>
				                            <?php if ($value == $time) { ?>
					                            <option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
				                            <?php } else { ?>
					                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
				                            <?php } ?>
			                            <?php } ?>
		                            </select>
	                            <?php } else { ?>
		                            <br /><?php echo lang('text_location_closed'); ?>
	                            <?php } ?>
                            </div>
                        </div>
                        <?php echo form_error('location', '<span class="text-danger">', '</span>'); ?>
                        <?php echo form_error('guest_num', '<span class="text-danger">', '</span>'); ?>
                        <?php echo form_error('reserve_date', '<span class="text-danger">', '</span>'); ?>
                        <?php echo form_error('reserve_time', '<span class="text-danger">', '</span>'); ?>
                    </div>

                    <div class="col-xs-10 col-sm-2 wrap-none">
                        <button type="submit" class="btn btn-primary btn-block"><?php echo lang('button_find_table'); ?></button>
                    </div>

                    <div class="col-xs-2 col-sm-2 text-right">
                        <a class="btn btn-default" href="<?php echo $reset_url; ?>"><?php echo lang('button_reset'); ?></a>
                    </div>
                </div>
            </div>

            <div class="panel panel-default panel-time-slots" style="margin-bottom:0;display:<?php echo ($find_table_action === 'select_time') ? 'block' : 'none'; ?>">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo lang('text_time_heading'); ?></h3>
                </div>

                <div class="panel-body">
                    <p class="text-uppercase"><?php echo sprintf(lang('text_time_msg'), mdate('%l, %F %j, %Y', strtotime($date)), $guest_num); ?></p>

                    <?php if ($time_slots) { ?>
                        <div id="time-slots" class="col-xs-12 col-sm-8 wrap-none">
                            <div class="btn-group" data-toggle="buttons">
                                <?php foreach ($time_slots as $key => $slot) { ?>
                                    <?php if ($slot['time'] === $time) { ?>
                                        <label class="btn btn-default col-xs-4 col-sm-2 active <?php echo $slot['state']; ?>" data-btn="btn-primary">
                                            <input type="radio" name="selected_time" id="reserve_time<?php echo $key; ?>" value="<?php echo $slot['time']; ?>" <?php echo set_radio('selected_time', $slot['time'], TRUE); ?>/><?php echo $slot['time']; ?>
                                        </label>
                                    <?php } else { ?>
                                        <label class="btn btn-default col-xs-4 col-sm-2 <?php echo $slot['state']; ?>" data-btn="btn-primary">
                                            <input type="radio" name="selected_time" id="reserve_time<?php echo $key; ?>" value="<?php echo $slot['time']; ?>" <?php echo set_radio('selected_time', $slot['time']); ?>/><?php echo $slot['time']; ?>
                                        </label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-xs-8 col-sm-2 wrap-none">
                            <button type="submit" class="btn btn-primary btn-block"><?php echo lang('button_select_time'); ?></button>
                        </div>

                        <div class="col-xs-4 col-sm-2">
                            <a class="btn btn-default" onclick="backToFind();"><?php echo lang('button_back'); ?></a>
                        </div>
                    <?php } else { ?>
                        <div class="col-xs-6 wrap-none"><?php echo lang('text_no_time_slot'); ?></div>

                        <div class="col-xs-6">
                            <a class="btn btn-default" onclick="backToFind();"><?php echo lang('button_back'); ?></a>
                        </div>
                    <?php } ?>

                    <?php echo form_error('selected_time', '<span class="text-danger">', '</span>'); ?>
                </div>
            </div>
        </form>

        <div class="panel panel-default panel-summary" style="margin-bottom:0;display:<?php echo ($find_table_action === 'view_summary') ? 'block' : 'none'; ?>">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo lang('text_reservation'); ?></h3>
            </div>

            <div class="panel-body">
                <div class="col-xs-12 col-sm-1 wrap-none">
                    <img class="img-responsive" src="<?php echo $location_image; ?>">
                </div>
                <div class="col-xs-12 col-sm-2 wrap-none">
                    <label class="text-muted text-uppercase small"><?php echo lang('label_guest_num'); ?></label><br />
                    <span class="form-control-static"><?php echo $guest_num; ?></span>
                </div>
                <div class="col-xs-12 col-sm-2 wrap-none">
                    <label class="text-muted text-uppercase small"><?php echo lang('label_date'); ?></label><br />
                    <span class="form-control-static"><?php echo mdate('%D, %M %j, %Y', strtotime($date)); ?></span>
                </div>
                <div class="col-xs-12 col-sm-1 wrap-none">
                    <label class="text-muted text-uppercase small"><?php echo lang('label_time'); ?></label><br />
                    <span class="form-control-static"><?php echo $time; ?></span>
                </div>
                <div class="col-xs-12 col-sm-4 wrap-none">
                    <label class="text-muted text-uppercase small"><?php echo lang('label_location'); ?></label><br />
                    <span class="form-control-static text-">
                        <?php foreach ($locations as $location) { ?>
                            <?php if ($location['id'] === $location_id) { ?>
                                <?php echo $location['name']; ?>
                            <?php } ?>
                        <?php } ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $(document).ready(function() {
        $('#check-postcode').on('click', function() {
            $('.check-local').fadeIn();
            $('.display-local').fadeOut();
        });

//        $('#time').timepicker({
//            <?php //echo ($time_format === '24hr') ? 'showMeridian: false' : 'showMeridian: true'; ?>
//        });

        $('#date').datepicker({
            <?php if ($date_format === 'year_first') { ?>
                <?php echo "format: 'yyyy-mm-dd'" ?>
            <?php } else if ($date_format === 'month_first') { ?>
                <?php echo "format: 'mm-dd-yyyy'" ?>
            <?php } else { ?>
                <?php echo "format: 'dd-mm-yyyy'" ?>
            <?php } ?>

        });

        if ($('input[name="action"]').val() == 'view_summary') {
            $('html,body').animate({scrollTop: $("#reservation-box > .container").offset().top}, 'slow');
        }

    });

    function backToFind() {
        $('input[name="action"]').val('find_table');
        $('#find, .panel-find-table').fadeIn();
        $('.panel-time-slots').fadeOut().empty();
        $('#reservation-alert .alert p').fadeOut();
    }

    function backToTime() {
        $('input[name="action"]').val('select_time');
        $('#find, .panel-time-slots').fadeIn();
        $('.panel-find-table').fadeOut();
        $('.panel-summary').fadeOut();
        $('#reservation-alert .alert p').fadeOut();
    }
//--></script>