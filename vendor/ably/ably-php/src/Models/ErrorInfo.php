<?php
namespace Ably\Models;

/**
 * Represents an error as returned from the Ably server
 */
class ErrorInfo {
    /**
     * @var int $code Exception code @see https://github.com/ably/ably-common/blob/main/protocol/errors.json
     */
    public $code;
    /**
     * @var int $statusCode HTTP error code
     */
    public $statusCode;
    /**
     * @var string $message Exception message
     */
    public $message;
}
