<?php

namespace CoreInterfaces\Http;

interface RetryOption
{
    /**
     * To retry request, ignoring httpMethods whitelist.
     */
    const ENABLE_RETRY = "enableRetries";

    /**
     * To disable retries, ignoring httpMethods whitelist.
     */
    const DISABLE_RETRY = "disableRetries";

    /**
     * To use global httpMethods whitelist to determine if request needs retrying.
     */
    const USE_GLOBAL_SETTINGS = "useGlobalSettings";

}
