<?php

declare(strict_types=1);

namespace Igniter\Automation\Classes;

use Igniter\Flame\Database\Model;
use LogicException;

class BaseAction extends AbstractBase
{
    /**
     * @var mixed Extra field configuration for the action.
     */
    protected $fieldConfig;

    /**
     * @param Model $model
     */
    public function __construct(protected $model = null)
    {
        $this->fieldConfig = $this->defineFormFields();

        $this->initialize($this->model);
    }

    /**
     * Initialize method called when the action class is first loaded
     * with an existing model.
     */
    public function initialize($model): void
    {
        if (!$model) {
            return;
        }

        if (!$model->exists) {
            $this->initConfigData($model);
        }

        // Apply validation rules
        $model->rules = array_merge($model->rules, $this->defineValidationRules());
    }

    /**
     * Initializes configuration data when the action is first created.
     * @param Model $model
     */
    public function initConfigData($model) {}

    /**
     * Returns information about this action, including name and description.
     * @return array<string, string>
     */
    public function actionDetails(): array
    {
        return [
            'name' => 'Action',
            'description' => 'Action description',
        ];
    }

    /**
     * Extra field configuration for the action.
     * @return array<string, array>
     */
    public function defineFormFields()
    {
        return [];
    }

    /**
     * Defines validation rules for the custom fields.
     * @return array
     */
    public function defineValidationRules()
    {
        return [];
    }

    public function hasFieldConfig(): bool
    {
        return (bool)$this->fieldConfig;
    }

    public function getFieldConfig(): array
    {
        return $this->fieldConfig;
    }

    public function triggerAction($params)
    {
        throw new LogicException('Method '.static::class.'::triggerAction() is not implemented.');
    }

    public function getActionName()
    {
        return array_get($this->actionDetails(), 'name', 'Action');
    }

    public function getActionDescription()
    {
        return array_get($this->actionDetails(), 'description');
    }

    public static function findActions()
    {
        $results = [];
        $ruleActions = (array)BaseEvent::findRulesValues('actions');
        foreach ($ruleActions as $actionClass) {
            if (!class_exists($actionClass)) {
                continue;
            }

            $actionObj = new $actionClass;
            $results[$actionClass] = $actionObj;
        }

        return $results;
    }
}
