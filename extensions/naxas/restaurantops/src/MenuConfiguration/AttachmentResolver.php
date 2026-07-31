<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\MenuConfiguration;

final class AttachmentResolver
{
    /** Variant override wins, then item override, then shared defaults. Null means inherit. */
    public function resolve(array $defaults, ?array $item, ?array $variant): array
    {
        $resolved = $defaults;
        foreach ([$item ?? [], $variant ?? []] as $override) {
            foreach ($override as $key => $value) {
                if ($value !== null) {
                    $resolved[$key] = $value;
                }
            }
        }

        return $resolved;
    }
}
