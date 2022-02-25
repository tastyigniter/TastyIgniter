<?php

namespace System\Models;

use Igniter\Flame\Database\Model;
use System\Classes\ExtensionManager;

/**
 * Activities Model Class
 */
class Activity extends \Igniter\Flame\ActivityLog\Models\Activity
{
    public static function unreadCount($menu, $item, Model $user)
    {
        return self::query()->user($user)->whereIsUnread()->count();
    }

    public static function markAllAsRead($menu, $item, Model $user)
    {
        $query = self::listRecent(['onlyUser' => $user, 'pageLimit' => null])->whereIsUnread();

        $query->get()->each(function ($model) {
            $model->markAsRead()->save();
        });
    }

    public static function listMenuActivities($menu, $item, Model $user)
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
            'sort' => 'created_at desc',
            'onlyUser' => null,
            'exceptUser' => null,
        ], $options));

        $query->with(['subject']);

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
            if (in_array($_sort, ['created_at asc', 'created_at desc', 'updated_at asc', 'updated_at desc'])) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                [$sortField, $sortDirection] = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        if ($pageLimit)
            return $query->take($pageLimit);

        return $query;
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
