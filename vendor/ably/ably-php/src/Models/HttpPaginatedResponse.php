<?php
namespace Ably\Models;

use Ably\Exceptions\AblyRequestException;

/**
 * RSC19d, HP1 - This class is used as a container for response data from AblyRest::request
 * It provides automatic pagination.
 */
class HttpPaginatedResponse extends PaginatedResult {
    /**
     * @var integer HTTP status code of the page
     */
    public $statusCode;

    /**
     * @var boolean True when the HTTP status code indicates sucess (200 <= statusCode < 300)
     */
    public $success;

    /**
     * @var integer Ably error code
     */
    public $errorCode;

    /**
     * @var string Error message
     */
    public $errorMessage;

    /**
     * @var Array Array of key value pairs for each response header
     */
    public $headers;

    /**
     * Constructor.
     * @param \Ably\AblyRest $ably Ably API instance
     * @param mixed $model Name of a class that will be instantiated for returned results. It must implement a fromJSON() method.
     * @param CipherParams|null $cipherParams Optional cipher parameters if data should be decoded
     * @param string $method HTTP method
     * @param string $path Request path
     * @param array $params Parameters to be sent with the request
     * @param array $headers Headers to be sent with the request
     * @throws AblyRequestException Thrown when the server and all the fallbacks are unreachable
     */
    public function __construct( \Ably\AblyRest $ably, $model, $cipherParams,
                                 $method, $path, $params = [], $headers = [] ) {
        try {
            parent::__construct( $ably, $model, $cipherParams, $method, $path, $params, $headers );
        } catch (AblyRequestException $ex) {
            $this->response = $ex->getResponse();

            if ($ex->getCode() >= 50000) { // all fallback hosts failed, rethrow exception
                throw $ex;
            }
        }

        $this->parseHeaders($this->response['headers']);

        if ($this->statusCode < 200 | $this->statusCode >= 300) {
            $this->success = false;

            if ( isset($this->headers['X-Ably-Errorcode']) ) {
                $this->errorCode = $this->headers['X-Ably-Errorcode'] * 1;
            }

            if ( isset($this->headers['X-Ably-Errormessage']) ) {
                $this->errorMessage = $this->headers['X-Ably-Errormessage'];
            }
        } else {
            $this->success = true;
        }
    }

    private function parseHeaders( $headers ) {
        $headers = explode("\n", $headers);
        $http = array_shift($headers);
        $http = explode(' ', $http);

        $this->statusCode = $http[1] * 1;
        $this->headers = [];

        foreach($headers as $header) {
            if(!trim($header)) continue;
            list($key, $value) = explode(':', $header, 2);
            $key = trim($key);

            // Title-Case
            $key = preg_replace_callback('/\w+/', function ($match) {
                return ucfirst(strtolower($match[0]));
            }, $key);

            $this->headers[$key] = trim($value);
        }
    }
}
