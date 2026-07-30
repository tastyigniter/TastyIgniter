<?php

declare(strict_types=1);

namespace Igniter\Automation\Classes;

use Igniter\Flame\Database\Model;

class BaseCondition extends AbstractBase
{
    public function __construct(protected ?Model $model = null)
    {
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
    }

    /**
     * Initializes configuration data when the action is first created.
     * @param Model $model
     */
    public function initConfigData($model) {}

    /**
     * Returns information about this condition, including name and description.
     * @return array<string, string>
     */
    public function conditionDetails(): array
    {
        return [
            'name' => 'Condition',
            'description' => 'Condition description',
        ];
    }

    /**
     * @return string
     */
    public function getConditionName()
    {
        return array_get($this->conditionDetails(), 'name', 'Condition');
    }

    /**
     * @return string
     */
    public function getConditionDescription()
    {
        return array_get($this->conditionDetails(), 'description', 'Condition description');
    }

    /**
     * Checks whether the condition is TRUE for specified parameters
     * @param array $params
     * @return bool
     */
    public function isTrue(&$params)
    {
        return false;
    }

    public static function findConditions(): array
    {
        $results = [];
        $ruleConditions = (array)BaseEvent::findRulesValues('conditions');
        foreach ($ruleConditions as $conditionClass) {
            if (!class_exists($conditionClass)) {
                continue;
            }

            $conditionObj = new $conditionClass;
            $results[$conditionClass] = $conditionObj;
        }

        return $results;
    }
}
