<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Tests\Unit;

require_once __DIR__.'/../../src/Payments/Exceptions/PaymentException.php';
require_once __DIR__.'/../../src/Payments/Money.php';
require_once __DIR__.'/../../src/Payments/TenderAllocator.php';
use Naxas\RestaurantOps\Payments\Exceptions\PaymentException;
use Naxas\RestaurantOps\Payments\TenderAllocator;
use PHPUnit\Framework\TestCase;

final class TenderAllocatorTest extends TestCase
{
    public function test_allocates_split_tenders_and_final_cash_change_exactly(): void
    {
        $rows = (new TenderAllocator)->allocate('1200.0000', [['method' => 'card', 'amount' => '700', 'reference' => 'CARD-1'], ['method' => 'cash', 'amount' => '600']]);
        self::assertSame('700.0000', $rows[0]['amount_applied']);
        self::assertSame('500.0000', $rows[1]['amount_applied']);
        self::assertSame('100.0000', $rows[1]['change_amount']);
    }

    public function test_rejects_underpayment(): void
    {
        $this->expectException(PaymentException::class);
        (new TenderAllocator)->allocate('10', [['method' => 'cash', 'amount' => '9']]);
    }

    public function test_rejects_non_cash_overpayment(): void
    {
        $this->expectException(PaymentException::class);
        (new TenderAllocator)->allocate('10', [['method' => 'card', 'amount' => '11', 'reference' => 'x']]);
    }

    public function test_requires_safe_non_cash_references(): void
    {
        $this->expectException(PaymentException::class);
        (new TenderAllocator)->allocate('10', [['method' => 'mobile', 'amount' => '10']]);
    }
}
