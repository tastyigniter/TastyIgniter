<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The list of possible dispute states.
 */
class DisputeState
{
    /**
     * The initial state of an inquiry with evidence required
     */
    public const INQUIRY_EVIDENCE_REQUIRED = 'INQUIRY_EVIDENCE_REQUIRED';

    /**
     * Inquiry evidence has been submitted and the bank is processing the inquiry
     */
    public const INQUIRY_PROCESSING = 'INQUIRY_PROCESSING';

    /**
     * The inquiry is complete
     */
    public const INQUIRY_CLOSED = 'INQUIRY_CLOSED';

    /**
     * The initial state of a dispute with evidence required
     */
    public const EVIDENCE_REQUIRED = 'EVIDENCE_REQUIRED';

    /**
     * Dispute evidence has been submitted and the bank is processing the dispute
     */
    public const PROCESSING = 'PROCESSING';

    /**
     * The bank has completed processing the dispute and the seller has won
     */
    public const WON = 'WON';

    /**
     * The bank has completed processing the dispute and the seller has lost
     */
    public const LOST = 'LOST';

    /**
     * The seller has accepted the dispute
     */
    public const ACCEPTED = 'ACCEPTED';
}
