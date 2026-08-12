<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Tables\Events;

final class TableClosed { public function __construct(public readonly array $payload) {} }
