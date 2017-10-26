<?php namespace Admin\FormWidgets;

use Admin\Classes\BaseFormWidget;
use Admin\Classes\FormField;
use Carbon\Carbon;

/**
 * Date picker
 * Renders a date picker field.
 *
 * @package Admin
 */
class DatePicker extends BaseFormWidget
{
    //
    // Configurable properties
    //

    /**
     * @var bool Display mode: datetime, date, time.
     */
    public $mode = 'date';

    /**
     * @var string the minimum/earliest date that can be selected.
     * eg: 2000-01-01
     */
    public $startDate = null;

    /**
     * @var string the maximum/latest date that can be selected.
     * eg: 2020-12-31
     */
    public $endDate = null;

    public $dateFormat = '%d-%m-%Y';

    public $timeFormat = '%H:%i';

    protected $datesDisabled;

    //
    // Object properties
    //
    protected $defaultAlias = 'datepicker';

    public function initialize()
    {
        $this->fillFromConfig([
            'format',
            'mode',
            'startDate',
            'endDate',
        ]);

        $this->mode = strtolower($this->mode);

        if ($this->startDate !== null) {
            $this->startDate = is_integer($this->startDate)
                ? Carbon::createFromTimestamp($this->startDate)
                : Carbon::parse($this->startDate);
        }

        if ($this->endDate !== null) {
            $this->endDate = is_integer($this->endDate)
                ? Carbon::createFromTimestamp($this->endDate)
                : Carbon::parse($this->endDate);
        }
    }

    public function loadAssets()
    {
        if (isset($this->config['mode']) AND strtolower($this->config['mode']) == 'time') {
            $this->addCss('vendor/clockpicker/bootstrap-clockpicker.min.css', 'bootstrap-clockpicker-css');
            $this->addJs('vendor/clockpicker/bootstrap-clockpicker.min.js', 'bootstrap-clockpicker-js');
            $this->addCss('css/clockpicker.css', 'clockpicker-css');
            $this->addJs('js/clockpicker.js', 'clockpicker-js');
        }
        else {
            $this->addCss('vendor/datepicker/bootstrap-datepicker.min.css', 'bootstrap-datepicker-css');
            $this->addJs('vendor/datepicker/bootstrap-datepicker.min.js', 'bootstrap-datepicker-js');
            $this->addCss('css/datepicker.css', 'datepicker-css');
            $this->addJs('js/datepicker.js', 'datepicker-js');
        }
    }

    public function render()
    {
        $this->prepareVars();

        return $this->makePartial('datepicker/datepicker');
    }

    /**
     * Prepares the list data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();

        if ($value = $this->getLoadValue()) {
            $value = make_carbon($value, FALSE);
            $value = $value instanceof Carbon ? $value->toDateTimeString() : $value;
        }

        // Display alias, used by preview mode
        if ($this->mode == 'time') {
            $formatAlias = setting('time_format');
        }
        elseif ($this->mode == 'date') {
            $formatAlias = setting('date_format');
        }
        else {
            $formatAlias = setting('date_format')
                .' '.setting('time_format');
        }

        $find = ['%d', '%D', '%m', '%M', '%y', '%Y', '%H', '%i'];
        $replace = ['dd', 'DD', 'mm', 'MM', 'yy', 'yyyy', 'HH', 'i'];
        $format = ($this->mode == 'time') ? $this->timeFormat : $this->dateFormat;

        $this->vars['format'] = str_replace($find, $replace, $format);
        $this->vars['value'] = !in_array($value, ['00:00:00', '00:00', '0000-00-00']) ? mdate($format, strtotime($value)) : '';
        $this->vars['formatAlias'] = $formatAlias;
        $this->vars['field'] = $this->formField;
        $this->vars['mode'] = $this->mode;
        $this->vars['startDate'] = $this->startDate ? mdate($format, strtotime($this->startDate)) : null;
        $this->vars['endDate'] = $this->endDate ? mdate($format, strtotime($this->endDate)) : null;
        $this->vars['datesDisabled'] = $this->datesDisabled;
    }

    public function getSaveValue($value)
    {
        if ($this->formField->disabled || $this->formField->hidden) {
            return FormField::NO_SAVE_DATA;
        }

        $defaultValue = ($this->mode == 'time') ? '00:00' : '0000-00-00';
        if (!strlen($value) OR $value == $defaultValue) {
            return $defaultValue;
        }

        return $value;
    }
}
