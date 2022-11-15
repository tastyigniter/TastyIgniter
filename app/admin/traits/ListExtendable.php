<?php

namespace Admin\Traits;

use Igniter\Flame\Database\Model;
use Illuminate\Support\Facades\Event;

trait ListExtendable
{
    /**
     * Called after the list columns are defined.
     *
     * @param \Admin\Widgets\Lists $host The hosting list widget
     *
     * @return void
     */
    public function listExtendColumns($host)
    {
    }

    /**
     * Controller override: Extend supplied model
     *
     * @param Model $model
     * @param null $alias
     *
     * @return\Igniter\Flame\Database\Model
     */
    public function listExtendModel($model, $alias = null)
    {
        return $model;
    }

    /**
     * Controller override: Extend the query used for populating the list
     * before the default query is processed.
     *
     * @param \Igniter\Flame\Database\Builder $query
     */
    public function listExtendQueryBefore($query, $alias = null)
    {
    }

    /**
     * Controller override: Extend the query used for populating the list
     * after the default query is processed.
     *
     * @param \Igniter\Flame\Database\Builder $query
     */
    public function listExtendQuery($query, $alias = null)
    {
    }

    /**
     * listExtendRecords controller override: Extend the records used for populating the list
     * after the query is processed.
     * @param Illuminate\Contracts\Pagination\LengthAwarePaginator|Illuminate\Database\Eloquent\Collection $records
     */
    public function listExtendRecords($records, $alias = null)
    {
    }

    /**
     * Controller override: Extend the query used for populating the filter
     * options before the default query is processed.
     *
     * @param \Igniter\Flame\Database\Builder $query
     * @param array $scope
     */
    public function listFilterExtendQuery($query, $scope)
    {
    }

    /**
     * Called before the filter scopes are defined.
     *
     * @param \Admin\Widgets\Filter $host The hosting filter widget
     *
     * @return void
     */
    public function listFilterExtendScopesBefore($host)
    {
    }

    /**
     * Called after the filter scopes are defined.
     *
     * @param \Admin\Widgets\Filter $host The hosting filter widget
     *
     * @param $scopes
     * @return void
     */
    public function listFilterExtendScopes($host, $scopes)
    {
    }

    /**
     * Replace a table column value (<td>...</td>)
     *
     * @param Model $record The populated model used for the column
     * @param string $column The column to override
     * @param string $alias List alias (optional)
     *
     * @return string HTML view
     */
    public function listOverrideColumnValue($record, $column, $alias = null)
    {
    }

    /**
     * Replace the entire table header contents (<th>...</th>) with custom HTML
     *
     * @param string $columnName The column name to override
     * @param string $alias List alias (optional)
     *
     * @return string HTML view
     */
    public function listOverrideHeaderValue($columnName, $alias = null)
    {
    }

    /**
     * Static helper for extending list columns.
     *
     * @param callable $callback
     *
     * @return void
     */
    public static function extendListColumns($callback)
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('admin.list.extendColumns', function ($widget) use ($calledClass, $callback) {
            if (!is_a($widget->getController(), $calledClass)) {
                return;
            }
            call_user_func_array($callback, [$widget, $widget->model]);
        });
    }
}
