<?php namespace System\Models;

use Igniter\Flame\Database\Builder;
use Model;

/**
 * Activities Model Class
 * @package System
 */
class Activities_model extends Model
{
    /**
     * @var array Auto-fill the created date field on insert
     */
    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    /**
     * @var string The database table name
     */
    public $table = 'activities';

    /**
     * @var string The database table primary key
     */
    public $primaryKey = 'activity_id';

    protected $fillable = ['domain', 'context', 'user', 'user_id', 'action', 'message', 'status', 'date_added'];

    public $timestamps = TRUE;

    public $casts = [
        'properties' => 'collection',
    ];

    public $relation = [
        'morphTo' => [
            'subject' => [],
            'causer'  => [],
        ],
    ];

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

    /**
     * Filter database records
     *
     * @param $query
     * @param array $filter an associative array of field/value pairs
     *
     * @return $this
     */
    public function scopeFilter($query, $filter = [])
    {
        if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
            $query->where('status', $filter['filter_status']);
        }

        return $query;
    }

    /**
     * Scope a query to only include activities by a given causer.
     *
     * @param \Igniter\Flame\Database\Builder $query
     * @param \Model $causer
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCausedBy(Builder $query, Model $causer)
    {
        return $query
            ->where('causer_type', $causer->getMorphClass())
            ->where('causer_id', $causer->getKey());
    }

    /**
     * Scope a query to only include activities for a given subject.
     *
     * @param \Igniter\Flame\Database\Builder $query
     * @param \Model $subject
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForSubject(Builder $query, Model $subject)
    {
        return $query
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey());
    }
}