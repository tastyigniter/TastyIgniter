<?php namespace System\Models;

use Igniter\Flame\ActivityLog\Models\Activity;

/**
 * Activities Model Class
 * @package System
 */
class Activities_model extends Activity
{
    public static function listMenuActivities($menu, $item, $user)
    {
        $query = self::with(['causer'])->listRecent([
            'exceptUser' => $user,
        ]);

        return [
            'total' => $query->toBase()->getCountForPagination(),
            'items' => $query->get(),
        ];
    }

    //
    // Scopes
    //

    public function scopeListRecent($query, $options)
    {
        extract(array_merge([
            'page'       => 1,
            'pageLimit'  => 20,
            'sort'       => 'date_added desc',
            'exceptUser' => null,
        ], $options));

        if ($exceptUser) {
            $query->where('causer_type', get_class($exceptUser))
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