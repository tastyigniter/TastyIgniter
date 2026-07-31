<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration;

use Naxas\RestaurantOps\MenuConfiguration\Exceptions\InvalidConfiguration;

final class SelectionValidator
{
    public function validateGroup(array $group, array $selections): void
    {
        if (! ($group['is_active'] ?? false) || ! ($group['visible'] ?? true)) {
            throw new InvalidConfiguration('Inactive or hidden modifier group submitted.');
        }
        $min = (int) ($group['min_selections'] ?? (($group['is_required'] ?? false) ? 1 : 0));
        $max = isset($group['max_selections']) ? (int) $group['max_selections'] : null;
        if ($min < 0 || ($max !== null && ($max < $min || $max < 1))) {
            throw new InvalidConfiguration('Invalid modifier selection limits.');
        }
        if (($group['selection_type'] ?? 'multiple') === 'single' && ($max === null || $max > 1)) {
            throw new InvalidConfiguration('Single-select groups must have a maximum of one.');
        }
        $count = 0;
        foreach ($selections as $selection) {
            if (! ($selection['attached'] ?? false) || ! ($selection['is_active'] ?? false) || ! ($selection['available'] ?? true) || ! ($selection['visible'] ?? true)) {
                throw new InvalidConfiguration('Unavailable or unattached modifier submitted.');
            }
            $quantity = (int) ($selection['quantity'] ?? 1);
            $allowed = (bool) ($selection['allow_quantity'] ?? false);
            $minQty = (int) ($selection['min_quantity'] ?? 0);
            $maxQty = (int) ($selection['max_quantity'] ?? 1);
            if ($quantity < max(1, $minQty) || $quantity > $maxQty || (! $allowed && $quantity !== 1)) {
                throw new InvalidConfiguration('Invalid modifier quantity.');
            }
            $count += $quantity;
        }
        if ($count < $min || ($max !== null && $count > $max)) {
            throw new InvalidConfiguration('Modifier selection count is outside the configured range.');
        }
    }

    public function validateConditionGraph(array $edges): void
    {
        $graph = [];
        foreach ($edges as $edge) {
            $graph[(int) $edge[0]][] = (int) $edge[1];
        }
        $visiting = [];
        $visited = [];
        $visit = function (int $node) use (&$visit, &$graph, &$visiting, &$visited): void {
            if (isset($visiting[$node])) {
                throw new InvalidConfiguration('Cyclic configuration is not allowed.');
            }
            if (isset($visited[$node])) {
                return;
            }
            $visiting[$node] = true;
            foreach ($graph[$node] ?? [] as $child) {
                $visit($child);
            }
            unset($visiting[$node]);
            $visited[$node] = true;
        };
        foreach (array_keys($graph) as $node) {
            $visit((int) $node);
        }
    }
}
