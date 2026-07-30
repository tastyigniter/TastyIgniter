<?php

namespace Mollie\Api\Types;

class ApprovalPrompt
{
    const AUTO = "auto";

    /**
     * Force showing the consent screen to the merchant, even when it is not necessary.
     * Note that already active authorizations will be revoked when the user creates the new authorization.
     */
    const FORCE = "force";
}
