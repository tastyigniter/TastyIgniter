<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Igniter\Admin\Classes\FilterScope;
use Igniter\Admin\Classes\ListColumn;
use Igniter\Admin\Widgets\Filter;
use Igniter\Admin\Widgets\Lists;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;

trait ListExtendable
{
    /**
     * Called after the list columns are defined.
     */
    public function listExtendColumns(Lists $host) {}

    /**
     * Controller override: Extend supplied model
     */
    public function listExtendModel(Model $model, ?string $alias = null): Model
    {
        return $model;
    }

    /**
     * Controller override: Extend the query used for populating the list
     * before the default query is processed.
     */
    public function listExtendQueryBefore(Builder $query, ?string $alias = null) {}

    /**
     * Controller override: Extend the query used for populating the list
     * after the default query is processed.
     *
     * @param \Igniter\Flame\Database\Builder $query
     */
    public function listExtendQuery(Builder $query, ?string $alias = null) {}

    /**
     * listExtendRecords controller override: Extend the records used for populating the list
     * after the query is processed.
     * @param LengthAwarePaginator|Collection $records
     */
    public function listExtendRecords(mixed $records, ?string $alias = null) {}

    /**
     * Controller override: Extend the query used for populating the filter
     * options before the default query is processed.
     */
    public function listFilterExtendQuery(Builder $query, FilterScope $scope) {}

    /** Called before the filter scopes are defined. */
    public function listFilterExtendScopesBefore(Filter $host) {}

    /**
     * Called after the filter scopes are defined.
     */
    public function listFilterExtendScopes(Filter $host, array $scopes) {}

    /**
     * Replace a table column value (<td>...</td>)
     */
    public function listOverrideColumnValue(Model $record, ListColumn $column, ?string $alias = null) {}

    /**
     * Replace the entire table header contents (<th>...</th>) with custom HTML
     */
    public function listOverrideHeaderValue(ListColumn $column, ?string $alias = null) {}

    /**
     * Static helper for extending list columns.
     */
    public static function extendListColumns(callable $callback): void
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('admin.list.extendColumns', function($widget) use ($calledClass, $callback) {
            if (is_a($widget->getController(), $calledClass)) {
                $callback($widget, $widget->model);
            }
        });
    }

    public static function extendListQuery(callable $callback): void
    {
        $calledClass = self::getCalledExtensionClass();
        Event::listen('admin.list.extendQuery', function($widget, $query) use ($calledClass, $callback) {
            if (is_a($widget->getController(), $calledClass)) {
                $callback($widget, $query);
            }
        });
    }
}
