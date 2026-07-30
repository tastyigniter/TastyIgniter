<?php

declare(strict_types=1);

namespace Igniter\Api\Traits;

use Igniter\Flame\Database\Model;

trait MergesIdAttribute
{
    public function mergesIdAttribute(Model $model, array $data = []): array
    {
        $array = $model->toArray();
        if (array_key_exists($model->getKeyName(), $array)) {
            unset($array[$model->getKeyName()]);
        }

        return array_merge(['id' => $model->getKey()], $array, $data);
    }
}
