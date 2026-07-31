<?php

declare(strict_types=1);

namespace Tests\Unit;

use Naxas\RestaurantOps\Shifts\Exceptions\ShiftException;
use Naxas\RestaurantOps\Shifts\Money;
use Naxas\RestaurantOps\Shifts\ShiftStateMachine;
use Naxas\RestaurantOps\Shifts\ShiftStatus;
use Tests\TestCase;

final class RestaurantOpsShiftFoundationTest extends TestCase
{
    public function test_money_uses_four_place_scaled_integer_arithmetic(): void
    {
        self::assertSame('15000.0000', Money::subtract(Money::add('5000.0000', '10000.0000', '1000.0000'), '500.0000', '500.0000'));
        self::assertSame('-50.0000', Money::subtract('14950.0000', '15000.0000'));
        self::assertSame('1500.0000', Money::multiply('500.0000', 3));
    }

    public function test_money_rejects_floats_excess_precision_and_non_positive_movements(): void
    {
        $this->expectException(ShiftException::class);
        Money::normalize('1.00001');
    }

    public function test_state_machine_enforces_terminal_and_correction_paths(): void
    {
        $machine = new ShiftStateMachine;
        $machine->assertCan(ShiftStatus::Open, ShiftStatus::ClosingRequested);
        $machine->assertCan(ShiftStatus::Submitted, ShiftStatus::Rejected);
        $machine->assertCan(ShiftStatus::Rejected, ShiftStatus::Submitted);
        self::assertTrue(ShiftStatus::Approved->isTerminal());
        $this->expectException(ShiftException::class);
        $machine->assertCan(ShiftStatus::Approved, ShiftStatus::Open);
    }
}
