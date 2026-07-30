<?php
namespace Ably\Exceptions;

use Ably\Models\ErrorInfo;
use \Exception;

/**
 * Generic Ably exception
 */
class AblyException extends Exception {

    /**
     * @var ErrorInfo
     */
    public $errorInfo;

    /**
     * @param string $message Exception's error message text
     * @param integer|null $code 5-digit Ably error code
     *        also used as a PHP exception code
     *        @see https://github.com/ably/ably-common/blob/main/protocol/errors.json
     * @param integer|null $statusCode HTTP error code
     */
    public function __construct( $message, $code = null, $statusCode = null ) {
        parent::__construct( $message, $code );
        $this->errorInfo = new ErrorInfo();
        $this->errorInfo->message = $message;
        $this->errorInfo->code = $code;
        $this->errorInfo->statusCode = $statusCode;
    }

    public function getStatusCode() {
        return $this->errorInfo->statusCode;
    }

    // PHP doesn't allow overriding these methods

    // public function getCode() {
    //     return $this->errorInfo->code;
    // }

    // public function getMessage() {
    //     return $this->errorInfo->message;
    // }
}
