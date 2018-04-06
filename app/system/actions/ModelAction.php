<?php

namespace System\Actions;

use Igniter\Flame\Traits\ExtensionTrait;
use Model;
use System\Traits\ConfigMaker;
use SystemException;

/**
 * Model Action base Class
 * @package System
 */
class ModelAction
{
    use ConfigMaker;
    use ExtensionTrait;

    /**
     * @var Model Reference to the controller associated to this action
     */
    protected $model;

    /**
     * @var array Properties that must exist in the controller using this action.
     */
    protected $requiredProperties = [];

    /**
     * ModelAction constructor.
     *
     * @param null $model
     *
     * @throws \SystemException
     */
    public function __construct($model = null)
    {
        $this->model = $model;

        foreach ($this->requiredProperties as $property) {
            if (!isset($model->{$property})) {
                throw new SystemException(
                    "Class %s must define property %s used by %s",
                    get_class($model), $property, get_called_class()
                );
            }
        }
    }
}
