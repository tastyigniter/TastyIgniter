<?php

declare(strict_types=1);

namespace Igniter\System\Actions;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Traits\ExtensionTrait;
use Igniter\System\Traits\ConfigMaker;
use LogicException;

/**
 * Model Action base Class
 */
class ModelAction
{
    use ConfigMaker;
    use ExtensionTrait;

    /** Properties that must exist in the controller using this action. */
    protected array $requiredProperties = [];

    public function __construct(
        /** Reference to the controller associated to this action */
        protected ?Model $model = null,
    ) {
        foreach ($this->requiredProperties as $property) {
            if (!isset($this->model->{$property})) {
                throw new LogicException(sprintf(
                    'Class %s must define property %s used by %s',
                    $this->model::class, $property, static::class,
                ));
            }
        }
    }
}
