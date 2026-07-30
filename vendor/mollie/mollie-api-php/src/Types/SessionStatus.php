<?php

namespace Mollie\Api\Types;

class SessionStatus
{
    /**
     * The session has just been created.
     */
    public const STATUS_CREATED = "created";

    /**
     * The session has been paid.
     */
    public const STATUS_READY_FOR_PROCESSING = "ready_for_processing";

    /**
     * The session is completed.
     */
    public const STATUS_COMPLETED = "completed";

    /**
     * The session has failed.
     */
    public const STATUS_FAILED = "failed";
}
