<?php namespace System\Models;

use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Translation\Models\Language;

/**
 * Languages Model Class
 * @package System
 */
class Languages_model extends Language
{
    use Purgeable;

    public $purgeable = ['file'];

    public static function getDropdownOptions()
    {
        return self::isEnabled()->dropdown('name', 'code');
    }

    public static function listCloneableLanguages()
    {
        return self::isEnabled()->whereNull('original_id')->dropdown('name', 'idiom');
    }

    public function getImageAttribute($value)
    {
        if (starts_with($value, 'data/flags/'))
            $value = substr($value, strlen('data/'));

        return $value;
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled language
     *
     * @param $query
     *
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }

    //
    // Events
    //

    public function beforeDelete()
    {
        $this->translations()->delete();
    }

    //
    // Helpers
    //

    public function isDefault()
    {
        return ($this->code == setting('default_language'));
    }
}