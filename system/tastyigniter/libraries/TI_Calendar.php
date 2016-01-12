<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Calendar Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\TI_Calendar.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Calendar extends CI_Calendar {

	public $start_day = 'monday';

	public $day_type = 'short';

	public $show_next_prev = TRUE;

	public $show_other_days = TRUE;

    /**
     * Generate the calendar
     *
     * @param string $year
     * @param string $month
     * @param array $data the data to be shown in the calendar cells
     * @return string
     * @internal param the $int year
     * @internal param the $int month
     */
	public function generate($year = '', $month = '', $data = array())
	{
		$local_time = time();

		// Set and validate the supplied month/year
		if (empty($year))
		{
			$year = date('Y', $local_time);
		}
		elseif (strlen($year) === 1)
		{
			$year = '200'.$year;
		}
		elseif (strlen($year) === 2)
		{
			$year = '20'.$year;
		}

		if (empty($month))
		{
			$month = date('m', $local_time);
		}
		elseif (strlen($month) === 1)
		{
			$month = '0'.$month;
		}

		$adjusted_date = $this->adjust_date($month, $year);

		$month	= $adjusted_date['month'];
		$year	= $adjusted_date['year'];

		// Determine the total days in the month
		$total_days = $this->get_total_days($month, $year);

		// Set the starting day of the week
		$start_days	= array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
		$start_day	= isset($start_days[$this->start_day]) ? $start_days[$this->start_day] : 0;

		// Set the starting day number
		$local_date = mktime(12, 0, 0, $month, 1, $year);
		$date = getdate($local_date);
		$day  = $start_day + 1 - $date['wday'];

		while ($day > 1)
		{
			$day -= 7;
		}

		// Set the current month/year/day
		// We use this to determine the "today" date
		$cur_year	= date('Y', $local_time);
		$cur_month	= date('m', $local_time);
		$cur_day	= date('j', $local_time);

		$is_current_month = ($cur_year == $year && $cur_month == $month);

        if (isset($data['url'], $data['url_suffix'])) {
            $url = $data['url'];
            $url_suffix = $data['url_suffix'];
            unset($data['url'], $data['url_suffix']);
        }

        // Generate the template data array
        $this->parse_template();

        // Begin building the calendar output
        $out = $this->replacements['table_open']."\n\n".$this->replacements['heading_row_start']."\n";

        // "previous" month link
		if ($this->show_next_prev === TRUE)
		{
			// Add a trailing slash to the URL if needed
            $this->next_prev_url = preg_replace('/(.+?)\/*$/', '\\1/', $this->next_prev_url);
            $this->next_prev_url = $url.$url_suffix;

            $adjusted_date = $this->adjust_date($month - 1, $year);
			//$out .= str_replace('{previous_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->replacements['heading_previous_cell'])."\n";
            $out .= str_replace('{previous_url}', $this->next_prev_url .'filter_year='. $adjusted_date['year'].'&filter_month='.$adjusted_date['month'], $this->replacements['heading_previous_cell']);
		}

		// Heading containing the month/year
		$colspan = ($this->show_next_prev === TRUE) ? 5 : 7;

		$this->replacements['heading_title_cell'] = str_replace('{colspan}', $colspan,
								str_replace('{heading}', $this->get_month_name($month).'&nbsp;'.$year, $this->replacements['heading_title_cell']));

		$out .= $this->replacements['heading_title_cell']."\n";

		// "next" month link
		if ($this->show_next_prev === TRUE)
		{
			$adjusted_date = $this->adjust_date($month + 1, $year);
			//$out .= str_replace('{next_url}', $this->next_prev_url.$adjusted_date['year'].'/'.$adjusted_date['month'], $this->replacements['heading_next_cell']);
            $out .= str_replace('{next_url}', $this->next_prev_url .'filter_year='. $adjusted_date['year'].'&filter_month='.$adjusted_date['month'], $this->replacements['heading_next_cell']);
		}

		$out .= "\n".$this->replacements['heading_row_end']."\n\n"
			// Write the cells containing the days of the week
			.$this->replacements['week_row_start']."\n";

		$day_names = $this->get_day_names();

		for ($i = 0; $i < 7; $i ++)
		{
			$out .= str_replace('{week_day}', $day_names[($start_day + $i) %7], $this->replacements['week_day_cell']);
		}

		$out .= "\n".$this->replacements['week_row_end']."\n";

		// Build the main body of the calendar
		while ($day <= $total_days)
		{
			$out .= "\n".$this->replacements['cal_row_start']."\n";

			for ($i = 0; $i < 7; $i++)
			{
				if ($day > 0 && $day <= $total_days)
				{
					$out .= ($is_current_month === TRUE && $day == $cur_day) ? $this->replacements['cal_cell_start_today'] : $this->replacements['cal_cell_start'];

					if (isset($data[$day]))
					{
						// Cells with content
						//$temp = ($is_current_month === TRUE && $day == $cur_day) ?
						//		$this->replacements['cal_cell_content_today'] : $this->replacements['cal_cell_content'];
						//$out .= str_replace(array('{content}', '{day}'), array($data[$day], $day), $temp);
                        $fmt_day = (strlen($day) == 1) ? '0'.$day : $day;
                        $day_id = $year .'-'. $month .'-'. $fmt_day;
                        $day_url = $this->next_prev_url.'filter_year='.$year.'&filter_month='. $month .'&filter_day='. $fmt_day;
                        $temp = ($is_current_month == TRUE AND $day == $cur_day) ? $this->replacements['cal_cell_content_today'] : $this->replacements['cal_cell_content'];
                        $out .= str_replace('{day}', $day, str_replace('{day_url}', $day_url, str_replace('{state}', $data[$day], str_replace('{day_id}', $day_id, $temp))));
					}
					else
					{
						// Cells with no content
						$temp = ($is_current_month === TRUE && $day == $cur_day) ?
								$this->replacements['cal_cell_no_content_today'] : $this->replacements['cal_cell_no_content'];
						$out .= str_replace('{day}', $day, $temp);
					}

					$out .= ($is_current_month === TRUE && $day == $cur_day) ? $this->replacements['cal_cell_end_today'] : $this->replacements['cal_cell_end'];
				}
				elseif ($this->show_other_days === TRUE)
				{
					$out .= $this->replacements['cal_cell_start_other'];

					if ($day <= 0)
					{
						// Day of previous month
						$prev_month = $this->adjust_date($month - 1, $year);
						$prev_month_days = $this->get_total_days($prev_month['month'], $prev_month['year']);
						$out .= str_replace('{day}', $prev_month_days + $day, $this->replacements['cal_cell_other']);
					}
					else
					{
						// Day of next month
						$out .= str_replace('{day}', $day - $total_days, $this->replacements['cal_cell_other']);
					}

					$out .= $this->replacements['cal_cell_end_other'];
				}
				else
				{
					// Blank cells
					$out .= $this->replacements['cal_cell_start'].$this->replacements['cal_cell_blank'].$this->replacements['cal_cell_end'];
				}

				$day++;
			}

			$out .= "\n".$this->replacements['cal_row_end']."\n";
		}

		$out .= "\n".$this->replacements['table_close'];

        return $out;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Default Template Data
	 *
	 * This is used in the event that the user has not created their own template
	 *
	 * @return	array
	 */
	public function default_template()
	{
		return array(
			'table_open'				=> '<table class="table table-calendar" border="0" cellpadding="4" cellspacing="0">',
			'heading_row_start'			=> '<tr>',
            'heading_previous_cell'     => '<th class="prev"><a class="calender-nav" href="{previous_url}"><i class="fa fa-caret-square-o-left fa-3x"></i></a></th>',
            'heading_title_cell'        => '<th class="title" colspan="{colspan}">{heading}</th>',
            'heading_next_cell'         => '<th class="next"><a class="calender-nav" href="{next_url}"><i class="fa fa-caret-square-o-right fa-3x"></i></a></th>',
			'heading_row_end'			=> '</tr>',
			'week_row_start'			=> '<tr>',
			'week_day_cell'				=> '<td class="week">{week_day}</td>',
			'week_row_end'				=> '</tr>',
			'cal_row_start'				=> '<tr>',
			'cal_cell_start'			=> '<td class="day">',
			'cal_cell_start_today'		=> '<td class="today">',
			'cal_cell_start_other'		=> '<td class="day other">',
            'cal_cell_start_select'     => '<td class="day">',
            'cal_cell_content'          => '<a href="{day_url}" id="{day_id}" class="{state}"><span>{day}</span></a>',
            'cal_cell_content_today'    => '<a href="{day_url}" id="{day_id}" class="{state}"><span>{day}</span></a>',
            'cal_cell_content_select'   => '<a href="{day_url}" id="{day_id}" class="{state} selected"><span>{day}</span></a>',
            'cal_cell_no_content'       => '<span>{day}</span>',
            'cal_cell_no_content_today' => '<span>{day}</span>',
            'cal_cell_no_content_select'=> '<span>{day}</span>',
			'cal_cell_blank'			=> '&nbsp;',
			'cal_cell_other'			=> '<span>{day}</span>',
			'cal_cell_end'				=> '</td>',
			'cal_cell_end_today'		=> '</td>',
			'cal_cell_end_other'		=> '</td>',
            'cal_cell_end_select'       => '</td>',
			'cal_row_end'				=> '</tr>',
			'table_close'				=> '</table>'
		);
	}

	// --------------------------------------------------------------------

	/**
	 * Parse Template
	 *
	 * Harvests the data within the template {pseudo-variables}
	 * used to display the calendar
	 *
	 * @return	CI_Calendar
	 */
	public function parse_template()
	{
		$this->replacements = $this->default_template();

		if (empty($this->template))
		{
			return $this;
		}

		if (is_string($this->template))
		{
			$today = array('cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today');
       		$select = array('cal_cell_start_select', 'cal_cell_content_select', 'cal_cell_no_content_select', 'cal_cell_end_select');

			foreach (array('table_open', 'table_close', 'heading_row_start', 'heading_previous_cell', 'heading_title_cell', 'heading_next_cell', 'heading_row_end', 'week_row_start', 'week_day_cell', 'week_row_end', 'cal_row_start', 'cal_cell_start', 'cal_cell_content', 'cal_cell_no_content', 'cal_cell_blank', 'cal_cell_end', 'cal_row_end', 'cal_cell_start_today', 'cal_cell_content_today', 'cal_cell_no_content_today', 'cal_cell_end_today', 'cal_cell_start_other', 'cal_cell_other', 'cal_cell_end_other', 'cal_cell_start_select', 'cal_cell_content_select', 'cal_cell_no_content_select', 'cal_cell_end_select') as $val)
			{
				if (preg_match('/\{'.$val.'\}(.*?)\{\/'.$val.'\}/si', $this->template, $match))
				{
					$this->replacements[$val] = $match[1];
				}
				elseif (in_array($val, $today, TRUE))
				{
					$this->replacements[$val] = $this->replacements[substr($val, 0, -6)];
				}
                else if (in_array($val, $select, TRUE))
                {
                    $this->replacements[$val] = $this->replacements[str_replace('_select', '', $val)];
                }
			}
		}
		elseif (is_array($this->template))
		{
			$this->replacements = array_merge($this->replacements, $this->template);
		}

		return $this;
	}

}

/* End of file Calendar.php */
/* Location: ./system/tastyigniter/libraries/Calendar.php */