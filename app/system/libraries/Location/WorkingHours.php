<?php namespace Igniter\Libraries\Location;

use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Location Working Hour Class
 *
 * @package System
 */
class WorkingHours
{
    public static $types = ['opening', 'delivery', 'collection'];

    public static $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    protected $hours;

    protected $location;

    protected $periods = [];

    public $dateFormat = "%Y-%m-%d";

    public $timeFormat = "%H:%i";

    public $currentDate;

    /**
     * @var \Igniter\Libraries\Location\WorkingPeriod
     */
    public $currentPeriod;

    public function __construct(Location $location)
    {
        $this->location = $location;

        $this->setDateTimeFormat();
    }

    public function initialize()
    {
        $this->currentDate = mdate($this->getDateFormat(), time());

        $this->loadHours();

        $this->periods = $this->makePeriods();

        $this->setCurrentPeriod($this->getPeriod($this->currentDate));
    }

    public function setCurrentPeriod($workingPeriod)
    {
        $this->currentPeriod = $workingPeriod;
    }

    /**
     * @return \Igniter\Libraries\Location\WorkingPeriod
     */
    public function getCurrentPeriod()
    {
        return $this->currentPeriod;
    }

    /**
     * @return Location
     */
    public function location()
    {
        return $this->location;
    }

    public function getTypes()
    {
        return self::$types;
    }

    public function getHours()
    {
        return $this->hours;
    }

    public function currentTime()
    {
        return $this->location()->currentTime();
    }

    public function openTime($type = null, $formatTime = TRUE)
    {
        return $this->getCurrentPeriod()->getTypeHour($type, 'open', $formatTime);
    }

    public function closeTime($type = null, $formatTime = TRUE)
    {
        return $this->getCurrentPeriod()->getTypeHour($type, 'close', $formatTime);
    }

    public function isOpened()
    {
        $currentPeriod = $this->getCurrentPeriod();

        return ($currentPeriod->getTypeStatus(Location::OPENING) == Location::OPEN
            AND $currentPeriod->getTypeStatus(Location::DELIVERY) == Location::OPEN
            AND $currentPeriod->getTypeStatus(Location::COLLECTION) == Location::OPEN);
    }

    public function isClosed()
    {
        $currentPeriod = $this->getCurrentPeriod();

        return ($currentPeriod->getTypeStatus(Location::OPENING) == Location::CLOSED
            AND $currentPeriod->getTypeStatus(Location::DELIVERY) == Location::CLOSED
            AND $currentPeriod->getTypeStatus(Location::COLLECTION) == Location::CLOSED);
    }

    public function setDateTimeFormat($dateFormat = null, $timeFormat = null)
    {
        $this->dateFormat = (is_null($dateFormat)) ? setting('date_format') : $dateFormat;
        $this->timeFormat = (is_null($timeFormat)) ? setting('time_format') : $timeFormat;

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

    public function generateHours()
    {
        $hours = $this->getHours()->groupBy('type');

        $grouped = $hours->transform(function ($model) {
            return $model->keyBy('weekday');
        })->toArray();

        return $grouped;
    }

    public function getPeriods()
    {
        return $this->periods;
    }

    public function getPeriod($date, $type = null)
    {
        $periods = $this->getPeriods();

        if (!isset($periods[$date]))
            return null;

        if (!$periods[$date] instanceof WorkingPeriod)
            return null;

        if (is_null($type))
            return $periods[$date];

        return $periods[$date]->period($type);
    }

    /**
     * Generates periods of working hours
     *
     * @param string $startTime period start time, Default: yesterday
     * @param string $endTime period end time, Default: a week
     *
     * @return array
     */
    public function makePeriods($startTime = "-1 day", $endTime = "+7 day")
    {
        $currentTime = $this->currentTime();
        $startDate = strtotime($startTime, $currentTime);
        $endDate = strtotime($endTime, $currentTime);

        $grouped = $this->getHours()->groupBy('weekday')->all();

        $result = [];
        while ($startDate <= $endDate) {
            $day = mdate('%N', $startDate) - 1;

            if (isset($grouped[$day])) {
                $config = [];
                $config['hours'] = $grouped[$day];
                $config['dateFormat'] = $this->getDateFormat();
                $config['timeFormat'] = $this->getTimeFormat();

                $weekDate = mdate($config['dateFormat'], $startDate);
                $workingPeriod = new WorkingPeriod($day, $weekDate);

                $workingPeriod->setUpAs(Location::OPENING, $config);

                $result[$weekDate] = $workingPeriod;
            }

            $startDate = strtotime("+1 day", $startDate);
        }

        return $result;
    }

    protected function loadHours()
    {
        $model = $this->prepareModel();

        $this->hours = $model->get();
    }

    protected function prepareModel()
    {
        if (!$model = $this->location()->getModel())
            throw new Exception("No 'Locations_model' found");

        if (!$model->hasRelation('working_hours'))
            throw new Exception(sprintf("Model '%s' does not contain a definition for '%s'.",
                get_class($this->model),
                $this->valueFrom
            ));

        return $model->working_hours();
    }
}
