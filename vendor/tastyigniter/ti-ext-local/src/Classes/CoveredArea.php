<?php

declare(strict_types=1);

namespace Igniter\Local\Classes;

use Igniter\Flame\Geolite\Contracts\CoordinatesInterface;
use Igniter\Local\Facades\Location;
use Igniter\Local\Models\LocationArea;
use Illuminate\Support\Collection;

/**
 * @method getLocationId()
 * @method getKey()
 * @method checkBoundary(CoordinatesInterface $userPosition)
 */
class CoveredArea
{
    public function __construct(protected LocationArea $model) {}

    public function deliveryAmount($cartTotal): float|int
    {
        return $this->getConditionValue('amount', $cartTotal) + $this->calculateDistanceCharges();
    }

    public function minimumOrderTotal($cartTotal): float|int
    {
        return $this->getConditionValue('total', $cartTotal);
    }

    public function listConditions(): Collection
    {
        return collect($this->model->conditions ?? [])
            ->sortBy('priority')
            ->mapInto(CoveredAreaCondition::class);
    }

    public function getConditionLabels(): array
    {
        return $this->listConditions()->map(fn(CoveredAreaCondition $condition): string => ucfirst(strtolower($condition->getLabel())))->all();
    }

    protected function getConditionValue($type, $cartTotal): float|int
    {
        if (!($condition = $this->checkConditions($cartTotal, $type)) instanceof CoveredAreaCondition) {
            return 0;
        }

        // Delivery is unavailable when delivery charge from the matched rule is -1
        if ($condition->amount < 0) {
            return $type == 'total' ? $condition->total : -1;
        }

        // At this stage, return the minimum total when the matched condition is a below
        if ($type == 'total' && $condition->type === 'below') {
            return $condition->total;
        }

        return $condition->{$type};
    }

    protected function checkConditions($cartTotal, $value = 'total'): ?CoveredAreaCondition
    {
        return $this->listConditions()->first(fn(CoveredAreaCondition $condition): bool => $condition->isValid($cartTotal));
    }

    protected function calculateDistanceCharges(): float|int
    {
        $distanceCharges = collect($this->model->boundaries['distance'] ?? []);

        if (!Location::userPosition()->isValid() || $distanceCharges->isEmpty()) {
            return 0;
        }

        $distanceFromLocation = round(Location::checkDistance(), 2);

        $condition = $distanceCharges
            ->sortBy('priority')
            ->map(fn(array $condition): CoveredAreaCondition => new CoveredAreaCondition([
                'type' => $condition['type'],
                'amount' => $condition['charge'],
                'total' => $condition['distance'],
            ]))
            ->first(fn(CoveredAreaCondition $condition): bool => $condition->isValid($distanceFromLocation));

        return optional($condition)->amount ?? 0;
    }

    public function __get(string $key): mixed
    {
        return $this->model->getAttribute($key);
    }

    public function __call(string $method, array $parameters)
    {
        return method_exists($this->model, $method) ? call_user_func_array([$this->model, $method], $parameters) : null;
    }
}
