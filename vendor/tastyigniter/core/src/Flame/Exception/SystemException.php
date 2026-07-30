<?php

declare(strict_types=1);

namespace Igniter\Flame\Exception;

use Exception;

/**
 * This class represents a critical system exception.
 * System exceptions are logged in the error log.
 */
class SystemException extends Exception {}
