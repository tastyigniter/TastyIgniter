<?php

namespace System\Actions;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Traits\ExtensionTrait;
use System\Traits\ConfigMaker;

/**
 * Model Action base Class
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
     * @throws \Igniter\Flame\Exception\SystemException
     */
    public function __construct($model)
    {
        $this->model = $model;

        foreach ($this->requiredProperties as $property) {
            if (!isset($model->{$property})) {
                throw new SystemException(sprintf(
                    'Class %s must define property %s used by %s',
                    get_class($model), $property, get_called_class()
                ));
            }
        }
    }
}
