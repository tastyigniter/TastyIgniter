<?php

declare(strict_types=1);

namespace Igniter\Api\ApiResources\Transformers;

use Igniter\Api\Traits\MergesIdAttribute;
use Igniter\Cart\Models\Ingredient;
use League\Fractal\TransformerAbstract;

class IngredientTransformer extends TransformerAbstract
{
    use MergesIdAttribute;

    public function transform(Ingredient $ingredient): array
    {
        return $this->mergesIdAttribute($ingredient);
    }
}
