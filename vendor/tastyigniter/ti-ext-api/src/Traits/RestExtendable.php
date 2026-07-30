<?php

declare(strict_types=1);

namespace Igniter\Api\Traits;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;

trait RestExtendable
{
    public function getRestModel()
    {
        return $this->model;
    }

    /**
     * Run logic before the store or update resource operation
     * by overriding it in the controller.
     * @param Model $model
     * @return void
     */
    public function restBeforeSave($model) {}

    /**
     * Run logic before the store resource operation
     * by overriding it in the controller.
     * @param Model $model
     * @return void
     */
    public function restBeforeCreate($model) {}

    /**
     * Run logic before the update resource operation
     * by overriding it in the controller.
     * @param Model $model
     * @return void
     */
    public function restBeforeUpdate($model) {}

    /**
     * Run logic after the store or update resource operation
     * by overriding it in the controller.
     * @param Model $model
     * @return void
     */
    public function restAfterSave($model) {}

    /**
     * Run logic after the store resource operation
     * by overriding it in the controller.
     * @param Model $model
     * @return void
     */
    public function restAfterCreate($model) {}

    /**
     * Run logic after the update resource operation
     * by overriding it in the controller.
     * @param Model $model
     * @return void
     */
    public function restAfterUpdate($model) {}

    /**
     * Run logic after the delete resource operation
     * by overriding it in the controller.
     * @param Model $model
     * @return void
     */
    public function restAfterDelete($model) {}

    /**
     * Extend supplied model query, the model query can
     * be altered by overriding it in the controller.
     * @param Builder $query
     * @return void
     */
    public function restExtendQuery($query) {}

    /**
     * Called to validate index or show action request.
     */
    public function restValidateQuery(array $requestQuery): array
    {
        return $requestQuery;
    }

    /**
     * Called to validate store, update or delete action request.
     */
    public function restValidate(array $requestData): array
    {
        return $requestData;
    }
}
