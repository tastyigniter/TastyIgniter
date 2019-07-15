<?php namespace System\Models;

use Igniter\Flame\ActivityLog\Models\Activity;
use System\Classes\ExtensionManager;

/**
 * Activities Model Class
 * @package System
 */
class Activities_model extends Activity
{
    public static function listMenuActivities($menu, $item, $user)
    {
        $query = self::listRecent([
            'onlyUser' => $user,
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
            'page' => 1,
            'pageLimit' => 20,
            'sort' => 'date_added desc',
            'onlyUser' => null,
            'exceptUser' => null,
        ], $options));

        $query->with(['subject', 'causer']);

        if ($onlyUser) {
            $query->where('user_id', $onlyUser->getKey())
                  ->where('user_type', $onlyUser->getMorphClass());
        }

        if ($exceptUser) {
            $query->where('causer_type', '!=', $exceptUser->getMorphClass());
            $query->orWhere(function ($q) use ($exceptUser) {
                $q->where('causer_type', $exceptUser->getMorphClass())
                  ->where('causer_id', '<>', $exceptUser->getKey());
            });
        }

        $query->whereNotNull('subject_id');

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

    //
    // Registration
    //

    public function loadActivityTypes()
    {
        parent::loadActivityTypes();

        $activityTypes = ExtensionManager::instance()->getRegistrationMethodValues('registerActivityTypes');
        foreach ($activityTypes as $bundles) {
            $this->registerActivityTypes($bundles);
        }
    }
}