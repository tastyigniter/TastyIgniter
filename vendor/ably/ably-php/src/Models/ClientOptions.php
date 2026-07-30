<?php
namespace Ably\Models;

use Ably\Defaults;
use Ably\Log;

/**
 * Client library options
 */
class ClientOptions extends AuthOptions {

    /**
     * @var boolean value indicating whether or not a TLS (“SSL”) secure connection should be used.
     */
    public $tls = true;

    /**
     * integer a number controlling the verbosity of the output from 1 (minimum, errors only) to 4 (most verbose);
     * @see \Ably\Log
     */
    public $logLevel = Log::WARNING;

    /**
     * @var function|null a function to handle each line of log output. If handler is not specified, STDOUT is used.
     * Note that the log level and log handler have global scope in the library and will thus not act independently between library instances when multiple library instances are existing concurrently.
     * @see \Ably\Log
     */
    public $logHandler;

    /**
     * TO3f
     * @var bool If true, msgpack is used for communication, otherwise JSON is used

     */
    public $useBinaryProtocol = true;

    /**
     * @var string alternate server domain
     * For development environments only.
     */
    public $restHost;

    /**
     * @var integer Allows a non-default Ably non-TLS port to be used.
     * For development environments only.
     */
    public $port;

    /**
     * @var integer Allows a non-default Ably TLS port to be used.
     * For development environments only.
     */
    public $tlsPort;

    /**
     * @var string optional prefix to be prepended to $restHost
     * Example: 'sandbox' -> 'sandbox-rest.ably.io'
     */
    public $environment;

    /**
     * @var string[] fallback hosts, used when connection to default host fails, populated automatically
     */
    public $fallbackHosts = [];

    /**
     * @var integer – default 600000 (10 minutes) the period in milliseconds
     * before HTTP requests are retried against the default endpoint
     */
    public $fallbackRetryTimeout = 600000;

    /**
     * @var \Ably\Models\TokenParams defaultTokenParams – overrides the client library defaults described in TokenParams
     */
    public $defaultTokenParams;

    /**
     * @var integer Timeout for opening the connection
     * Warning: may be rounded down on some OSes and values < 1000 will always fail in that case.
     */
    public $httpOpenTimeout = 4000;

    /**
     * @var integer connection timeout after which a next fallback host is used
     */
    public $httpRequestTimeout = 10000;

    /**
     * @var integer Max number of fallback host retries for HTTP requests that fail due to network issues or server problems
     */
    public $httpMaxRetryCount = 3;

    /**
     * @var integer Max elapsed time in which fallback host retries for HTTP requests will be attempted
     */
    public $httpMaxRetryDuration = 15000;

    /**
     * @var string a class that should be used for making HTTP connections
     * To allow mocking in tests.
     */
    public $httpClass = 'Ably\Http';

    /**
     * @var bool defaults to false for clients with version < 1.2, otherwise true
     */
    public $idempotentRestPublishing = true;

    /**
     * @var string a class that should be used for Auth
     * To allow mocking in tests.
     */
    public $authClass = 'Ably\Auth';


    private function isProductionEnvironment() {
        return empty($this->environment) || strcasecmp($this->environment, "production") == 0;
    }

    private function isDefaultPort() {
        return $this->tls ? $this->tlsPort == Defaults::$tlsPort : $this->port == Defaults::$port;
    }

    private function activePort() {
        return $this->tls ? $this->tlsPort : $this->port;
    }

    private function isDefaultRestHost() {
        return $this->restHost == Defaults::$restHost;
    }

    public function getPrimaryRestHost() {
        if ($this->isDefaultRestHost()) {
            return $this->isProductionEnvironment() ? $this->restHost : $this->environment.'-'.$this->restHost;
        }
        return $this->restHost;
    }

    public function getFallbackHosts() {
        $fallbacks = $this->fallbackHosts ?? [];
        if (empty($this->fallbackHosts) && $this->isDefaultRestHost() && $this->isDefaultPort()) {
            $fallbacks = $this->isProductionEnvironment() ? Defaults::$fallbackHosts : Defaults::getEnvironmentFallbackHosts($this->environment);
        }
        return $fallbacks;
    }

    public function getHostUrl($host) {
        return ($this-> tls ? 'https://' : 'http://') . $host. ':' .$this->activePort();
    }

    public function __construct( $options = [] ) {
        parent::__construct( $options );
        if (empty($this->restHost)) {
            $this->restHost = Defaults::$restHost;
        }
        if (empty($this->port)) {
            $this->port = Defaults::$port;
        }
        if (empty($this->tlsPort)) {
            $this->tlsPort = Defaults::$tlsPort;
        }
        if (empty($this->defaultTokenParams)) {
            $this->defaultTokenParams = new TokenParams();
        }
    }
}
