<?php

namespace System\Traits;

trait Defaultable
{
    protected static $defaultableCache;

    public function makeDefault()
    {
        if (!$this->is_enabled) {
            throw new ValidationException(['is_enabled' => sprintf('"%s" is disabled and cannot be set as default.', $this->name)]);
        }

        $this->newQuery()->where('id', $this->id)->update(['is_default' => TRUE]);
        $this->newQuery()->where('id', '<>', $this->id)->update(['is_default' => FALSE]);
    }

    public static function getDefault()
    {
        if (self::$defaultableCache !== null) {
            return self::$defaultableCache;
        }

        $defaultGroup = self::where('customer_group_id', setting('customer_group_id'))->first();
        if (!$defaultGroup) {
            if ($defaultGroup = self::first()) {
                $defaultGroup->makeDefault();
            }
        }

        return self::$defaultableCache = $defaultGroup;
    }

}
