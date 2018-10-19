<?php namespace System\Models;

use Admin\Models\Customers_model;
use Admin\Models\Users_model;
use Igniter\Flame\ActivityLog\ActivityLogger;
use Igniter\Flame\ActivityLog\Models\Activity;

/**
 * Activities Model Class
 * @package System
 */
class Activities_model extends Activity
{
    public static function listMenuActivities($menu, $item, $user)
    {
        $query = self::listRecent([
            'exceptUser' => $user,
        ]);

        return [
            'total' => $query->toBase()->getCountForPagination(),
            'items' => $query->get(),
        ];
    }

    public function getCauserNameAttribute($value)
    {
        if (!$this->causer)
            return 'System';

        if ($this->causer instanceof Users_model)
            return $this->causer->staff_name;

        if ($this->causer instanceof Customers_model)
            return $this->causer->getCustomerName();
    }

    public function getMessageAttribute($value)
    {
        return app(ActivityLogger::class)->replacePlaceholders($value, $this);
    }

    //
    // Scopes
    //

    public function scopeListRecent($query, $options)
    {
        extract(array_merge([
            'page' => 1,
            'pageLimit' => 20,
            'sort' => 'date_added desc',
            'exceptUser' => null,
        ], $options));

        if ($exceptUser) {
            $query->where('causer_type', $exceptUser->getMorphClass())
                  ->where('causer_id', '<>', $exceptUser->getKey());
        }

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {

            if (in_array($_sort, ['date_added asc', 'date_added desc', 'date_updated asc', 'date_updated desc'])) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query->take($pageLimit);
    }
}