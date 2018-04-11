<?php namespace Admin\Models;

use Carbon\Carbon;
use Model;

/**
 * Menu Specials Model Class
 * @package Admin
 */
class Menus_specials_model extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'menus_specials';

    protected $primaryKey = 'special_id';

    protected $fillable = ['menu_id', 'start_date', 'end_date', 'special_price', 'special_status'];

    public $dates = ['start_date', 'end_date'];

    public $dateFormat = 'Y-m-d';

    public function active()
    {
        if (!$this->special_status)
            return FALSE;

        return Carbon::now()->between($this->start_date, $this->end_date);
    }

    public function daysRemaining()
    {
        if (!$this->end_date->greaterThan(Carbon::now()))
            return 0;

        return $this->end_date->diffInDays(Carbon::now());
    }

    public function getPrettyEndDateAttribute()
    {
        if (!$this->end_date)
            return null;

        return mdate(setting('date_format'), $this->end_date->getTimestamp());
    }
}