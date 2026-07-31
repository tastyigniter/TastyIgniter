<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Shifts;

enum ShiftStatus: string
{
    case Open = 'open';
    case ClosingRequested = 'closing_requested';
    case Submitted = 'submitted';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case ForceClosed = 'force_closed';
    case Cancelled = 'cancelled';

    public function isActive(): bool
    {
        return in_array($this, [self::Open, self::ClosingRequested, self::Submitted, self::Rejected], true);
    }

    public function isTerminal(): bool
    {
        return in_array($this, [self::Approved, self::ForceClosed, self::Cancelled], true);
    }
}
