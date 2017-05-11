<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location Working Hours Class
 *
 * @category       Libraries
 * @package        Igniter\Libraries\Location_hours.php
 * @link           http://docs.tastyigniter.com
 */
class Location_hours
{
    const CLOSED = 'closed';
    const OPEN = 'open';
    const OPENING = 'opening';

    public $workingType = null;
    public $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    public $currentDay = null;
    public $currentTime = null;
    public $dateFormat = "%d/%m/%Y";
    public $timeFormat = "%H:%i";
    public $weekDay = null;
    protected $allWorkingHours = [];
    public $workingTime = [];
    public $workingSchedule = [];

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->database();
        $this->CI->load->model('Working_hours_model');

        $this->currentDay = date('l');
        $this->currentTime = time();

        $this->setDateTimeFormat();
        $this->setWeekDay(mdate('%N', time()));
    }

    public function getHours()
    {
        $workingHours = $this->getByLocation();

        foreach ($workingHours as $type => &$workingHour) {
            foreach ($workingHour as $day => &$hour) {
                $hour['open'] = mdate($this->getTimeFormat(), $hour['open']);
                $hour['close'] = mdate($this->getTimeFormat(), $hour['close']);
            }
        }

        return $workingHours;
    }

    public function getWorkingTime()
    {
        if (empty($this->workingTime))
            $this->setWorkingTime();

        return $this->workingTime;
    }

    public function setWorkingTime()
    {
        $workingSchedule = $this->getWorkingSchedule();
        foreach ($workingSchedule as $schedule) {
            if ($schedule['working_status'] != 'closed') {
                $this->workingTime = $schedule;
                break;
            }
        }
    }

    public function getWorkingSchedule($date = null)
    {
        if (empty($this->workingSchedule))
            $this->setWorkingSchedule();

        if (is_null($date))
            return $this->workingSchedule;

        return isset($this->workingSchedule[$date]) ? $this->workingSchedule[$date] : null;
    }

    public function setWorkingSchedule()
    {
        $currentTime = $this->getLocation()->currentTime();
        $startDate = mdate("%d-%m-%Y", strtotime("-1 day", $currentTime));
        $endDate = mdate("%d-%m-%Y", strtotime("+7 day", $currentTime));

        $this->workingSchedule = $this->createSchedule($startDate, $endDate);
    }

    public function getOrderSchedule($startDate, $endDate)
    {
        $workingSchedule = $this->createSchedule($startDate, $endDate);

        $timeInterval = $this->orderTimeInterval();
        $lastOrderTime = $this->lastOrderTime();
        $currentTime = $this->getLocation()->currentTime();

        $count = 1;
        $scheduleRange = [];
        foreach ($workingSchedule as $date => $workingHour) {

            $startTime = mdate("%d-%m-%Y %H:%i", $workingHour['open'] + ($timeInterval * 60));
            $endTime = mdate("%d-%m-%Y %H:%i", $workingHour['close'] - $lastOrderTime);
            $timeRange = $this->getTimeRange($startTime, $endTime);

            foreach ($timeRange as $time) {
                if (strtotime($time) >= $currentTime + ($timeInterval * 60)) {
                    if ($workingHour['working_status'] === 'open' AND $count === 1) {
                        $scheduleRange['asap'] = mdate('%d-%m-%Y %H:%i', $currentTime + ($timeInterval * 60));
                    } else {
                        $date = mdate('%d-%m-%Y', strtotime($time));
                        $hour = mdate('%H', strtotime($time));
                        $scheduleRange[$date][$hour][] = mdate('%i', strtotime($time));
                    }

                    $count++;
                }
            }
        }

        return $scheduleRange;
    }

    public function getTimeRange($startTime, $endTime)
    {
        return time_range($startTime, $endTime, $this->orderTimeInterval(), "%d-%m-%Y %H:%i");
    }

    public function createSchedule($startDate, $endDate)
    {
        $result = [];

        while (strtotime($startDate) <= strtotime($endDate)) {
            $day = mdate('%N', strtotime($startDate)) - 1;

            if ($workingTime = $this->setWeekDay($day)->getByLocationWorkingTypeDay()) {
                $close = strtotime("{$startDate} {$workingTime['closing_time']}");
                $workingTime['open'] = strtotime("{$startDate} {$workingTime['opening_time']}");
                $workingTime['till_next_day'] = ($workingTime['open'] > $close) ? TRUE : FALSE;
                $workingTime['close'] = ($workingTime['till_next_day']) ? $close + 86400 : $close;

                $workingTime['working_status'] = $this->checkStatus(null, $workingTime);

                $result[$startDate] = $workingTime;
            }

            $startDate = mdate("%d-%m-%Y", strtotime("+1 day", strtotime($startDate)));
        }

        return $result;
    }

    public function getWorkingHour($hourType, $formatTime = TRUE)
    {
        $workingTime = $this->getWorkingTime();

        if (empty($workingTime) OR empty($workingTime[$hourType]))
            return null;

        $timeFormat = $this->getTimeFormat();
        if ($workingTime['till_next_day'] === TRUE) {
            $timeFormat = '%D '.$this->getTimeFormat();
        }

        return $formatTime ? mdate($timeFormat, $workingTime[$hourType]) : $workingTime[$hourType];
    }

    public function checkStatus($currentTime = null, $workingTime = [])
    {
        $workingStatus = self::CLOSED;

        $workingTime = (array)$workingTime ? $workingTime : $this->getWorkingTime();
        $currentTime = !empty($currentTime) ? strtotime($currentTime) : $this->getLocation()->currentTime();

        if (!isset($workingTime['open'], $workingTime['close']))
            return $workingStatus;

        $openTime = $workingTime['open'];
        $closeTime = $workingTime['close'];

        if (in_array($workingTime['type'], ['delivery', 'collection']))
            $closeTime = $closeTime - $this->lastOrderTime();

        if ($workingTime['status'] == '1' AND $currentTime <= $closeTime)
            $workingStatus = ($currentTime >= $openTime) ? self::OPEN : self::OPENING;

        return $workingStatus;
    }

    /**
     * @return array|mixed
     */
    protected function getByLocation()
    {
        if (empty($this->allWorkingHours))
            $this->allWorkingHours = $this->getModel()->getHoursByLocation();

        return isset($this->allWorkingHours[$this->getLocation()->getId()]) ?
            $this->allWorkingHours[$this->getLocation()->getId()] : [];
    }

    /**
     * @return array|mixed
     */
    protected function getByLocationWorkingType()
    {
        $workingHours = $this->getByLocation();

        return isset($workingHours[$this->getWorkingType()]) ? $workingHours[$this->getWorkingType()] : [];
    }

    /**
     * @return array|mixed
     */
    protected function getByLocationWorkingTypeDay()
    {
        $workingHours = $this->getByLocationWorkingType();

        return isset($workingHours[$this->getWeekDay()]) ? $workingHours[$this->getWeekDay()] : [];
    }

    /**
     * @return Working_hours_model
     */
    public function getModel()
    {
        return $this->CI->Working_hours_model;
    }

    public function getWorkingType()
    {
        return is_null($this->workingType) ? 'opening' : $this->workingType;
    }

    public function setWorkingType($workingType)
    {
        $this->workingType = $workingType;

        return $this;
    }

    /**
     * @return Location null
     */
    public function getLocation()
    {
        return $this->CI->location;
    }

    public function getCurrentTime()
    {
        return $this->currentTime;
    }

    public function setCurrentTime($currentTime)
    {
        $this->currentTime = $currentTime;

        return $this;
    }

    public function getCurrentDay()
    {
        return $this->currentDay;
    }

    public function setCurrentDay($currentDay)
    {
        $this->currentDay = $currentDay;

        return $this;
    }

    public function getWeekDay()
    {
        return $this->weekDay;
    }

    public function setWeekDay($weekDay)
    {
        $this->weekDay = $weekDay;

        return $this;
    }

    public function setDateTimeFormat($dateFormat = null, $timeFormat = null)
    {
        $this->dateFormat = (is_null($dateFormat)) ? $this->CI->config->item('date_format') : $dateFormat;
        $this->timeFormat = (is_null($timeFormat)) ? $this->CI->config->item('time_format') : $timeFormat;

        return $this;
    }

    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;

        return $this;
    }

    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    public function getTimeFormat()
    {
        return $this->timeFormat;
    }

    public function setTimeFormat($timeFormat)
    {
        $this->timeFormat = $timeFormat;

        return $this;
    }

    public function getWeekDayText()
    {
        return $this->getModel()->getWeekDays()[$this->getWeekDay()];
    }

    public function lastOrderTime()
    {
        $lastOrderTime = !is_null($this->getLocation()->local()['last_order_time']) ?
            $this->getLocation()->local()['last_order_time'] : 0;

        return (is_numeric($lastOrderTime) AND $lastOrderTime > 0) ? $lastOrderTime * 60 : $lastOrderTime;
    }

    public function orderTimeInterval()
    {
        if ($this->getLocation()->orderType() == '1') {
            return $this->getLocation()->deliveryTime();
        } else {
            return $this->getLocation()->collectionTime();
        }
    }
}
