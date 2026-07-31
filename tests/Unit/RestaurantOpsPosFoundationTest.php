<?php

declare(strict_types=1);

namespace Tests\Unit;

require_once __DIR__.'/../../extensions/naxas/restaurantops/src/Pos/PosOrderStatus.php';
require_once __DIR__.'/../../extensions/naxas/restaurantops/src/Pos/Exceptions/PosException.php';
require_once __DIR__.'/../../extensions/naxas/restaurantops/src/Pos/PosStateMachine.php';

use Naxas\RestaurantOps\Pos\Exceptions\PosException;
use Naxas\RestaurantOps\Pos\PosOrderStatus;
use Naxas\RestaurantOps\Pos\PosStateMachine;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class RestaurantOpsPosFoundationTest extends TestCase
{
    #[DataProvider('validTransitions')]
    public function test_explicit_foundation_transitions_are_allowed(string $from, string $to): void
    {
        (new PosStateMachine)->assertCan($from, $to);
        self::addToAssertionCount(1);
    }

    public static function validTransitions(): array
    {
        return [[PosOrderStatus::DRAFT, PosOrderStatus::HELD], [PosOrderStatus::DRAFT, PosOrderStatus::ACTIVE], [PosOrderStatus::HELD, PosOrderStatus::DRAFT], [PosOrderStatus::ACTIVE, PosOrderStatus::KITCHEN_PENDING], [PosOrderStatus::ACTIVE, PosOrderStatus::PAYMENT_PENDING], [PosOrderStatus::KITCHEN_PENDING, PosOrderStatus::PAYMENT_PENDING]];
    }

    public function test_payment_pending_and_cancelled_are_terminal(): void
    {
        foreach ([PosOrderStatus::PAYMENT_PENDING, PosOrderStatus::CANCELLED] as $state) {
            try {
                (new PosStateMachine)->assertCan($state, PosOrderStatus::DRAFT);
                self::fail('Expected structured conflict.');
            } catch (PosException $exception) {
                self::assertSame('pos_order_state_invalid', $exception->errorCode);
                self::assertSame(409, $exception->status);
            }
        }
    }
}
