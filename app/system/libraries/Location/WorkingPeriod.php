<?php

namespace Igniter\Libraries\Location;

use Carbon\Carbon;
use Exception;
use Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * Working period definition
 *
 * @package System
 */
class WorkingPeriod
{
    const CLOSED = 'closed';
    const OPEN = 'open';
    const OPENING = 'opening';

    public $weekDay;

    public $date;

    public $type;

    public $hours;

    public $timeFormat;

    public $dateFormat;

    /**
     * Constructor.
     *
     * @param string $weekDay
     * @param string $date
     */
    public function __construct($weekDay, $date)
    {
        $this->weekDay = $weekDay;
        $this->date = $date;
    }

    public function setUpAs($type, $config)
    {
        $this->type = strtolower($type) ?: $this->type;
        $this->config = $this->evalConfig($config);

        return $this;
    }

    protected function evalConfig($config)
    {
        if (isset($config['hours']))
            $this->hours = $this->periods($config['hours']);

        if (isset($config['timeFormat']))
            $this->timeFormat = $config['timeFormat'];

        if (isset($config['dateFormat']))
            $this->dateFormat = $config['dateFormat'];

        return $config;
    }

    public function periods($hours)
    {
        if (!$hours instanceof Collection)
            return [];

        $newCollection = $hours->keyBy('type');

        return $newCollection;
    }

    public function period($type)
    {
        if (!isset($this->hours[$type]))
            return null;

        return $this->hours[$type];
    }

    public function getStatus()
    {
        return $this->getTypeStatus($this->type);
    }

    public function getTypeStatus($type, $time = null)
    {
        if (!$model = $this->period($type))
            return self::CLOSED;

        return $this->checkStatus($model, $time);
    }

    public function getTypeHour($type, $hour, $format = '')
    {
        if (!in_array($hour, ['open', 'close']))
            throw new Exception("Parameter [$hour] passed to 'WorkingPeriod::getTypeHours' must be one of 'open' or 'close'");

        if (!$model = $this->period($type) OR !$model->{$hour} instanceof Carbon)
            return null;

        return $format ? mdate($this->timeFormat, $model->{$hour}->timestamp) : $model->{$hour};
    }

    public function checkStatus($model, $time = null)
    {
        if (!$model instanceof Model)
            throw new Exception("Expected instance of model ".get_class($model));

        $model->setWeekDate($this->date);

        $time = make_carbon(!empty($time) ? strtotime($time) : time());

        if (!$model->open OR !$model->close OR !$model->status)
            return FALSE;

        if ($model->open->eq($model->close))
            return self::OPEN;

        $closeTime = $model->close;
        if (in_array($this->type, ['delivery', 'collection']))
            $closeTime = $model->close->subMinutes($model->lastOrderTime());

        if ($closeTime->gte($time))
            return $model->open->lte($time) ? self::OPEN : self::OPENING;

        return self::CLOSED;
    }
}
