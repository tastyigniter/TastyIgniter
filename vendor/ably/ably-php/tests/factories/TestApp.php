<?php
namespace tests;
use Ably\AblyRest;
use Ably\Log;
use Ably\Models\ClientOptions;
use \stdClass;

require_once __DIR__ . '/../../vendor/autoload.php';


/**
 * Generates test application keys in the Ably sandbox
 */
class TestApp {

    private static $fixtureFile = '/../../ably-common/test-resources/test-app-setup.json';
    private $options;
    private $fixture;
    private $appId;
    private $appKeys = [];
    public $server;
    private $debugRequests = false;

    public function __construct() {

        $settings = [];

        $settings['environment'] = getenv( 'ABLY_ENV' ) ? : 'sandbox';
        $settings['useBinaryProtocol'] = getenv('PROTOCOL') !== 'json';
        //$settings['logLevel'] = Log::DEBUG;

        $clientOpts = new ClientOptions( $settings );

        $this->options = $settings;

        $this->server = $clientOpts->getHostUrl($clientOpts->getPrimaryRestHost());
        $this->init();

        return $this;
    }

    private function init() {

        $this->fixture = json_decode ( file_get_contents( __DIR__ . self::$fixtureFile, 1 ) );

        if (!$this->fixture) {
            echo 'Unable to read fixture file';
            exit(1);
        }

        $raw = $this->request( 'POST', $this->server . '/apps', [], json_encode( $this->fixture->post_apps ) );
        $response = json_decode( $raw );

        if ($response === null) {
            echo 'Could not connect to API.';
            exit(1);
        }

        $this->appId = $response->appId;

        foreach ($response->keys as $key) {
            $obj = new stdClass();
            $obj->appId = $this->appId;
            $obj->id = $key->id;
            $obj->value = $key->value;
            $obj->name = $this->appId . '.' . $key->id;
            $obj->string = $this->appId . '.' . $key->id . ':' . $key->value;
            $obj->capability = $key->capability;

            $this->appKeys[] = $obj;
        }
    }

    public function release() {
        if (!empty($this->options)) {
            $headers = [ 'authorization: Basic ' . base64_encode( $this->getAppKeyDefault()->string ) ];
            $this->request( 'DELETE', $this->server . '/apps/' . $this->appId, $headers );
            $this->options = null;
        }
    }

    public function getFixture() {
        return $this->fixture;
    }

    public function getOptions() {
        return $this->options;
    }

    public function getAppId() {
        return $this->appId;
    }

    public function getAppKeyDefault() {
        return $this->appKeys[0];
    }

    public function getAppKeyWithCapabilities() {
        return $this->appKeys[1];
    }

    private function request( $mode, $url, $headers = [], $params = '' ) {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via call to curl_error($ch)

        if ( $mode == 'DELETE') curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
        if ( $mode == 'POST' )  curl_setopt ( $ch, CURLOPT_POST, 1 );

        if (!empty($params)) {
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
            array_push( $headers, 'Accept: application/json', 'Content-Type: application/json' );
        }

        if (!empty($headers)) {
            curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
        }

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        if ($this->debugRequests) {
            curl_setopt( $ch, CURLOPT_VERBOSE, 1 );
        } 

        $raw = curl_exec($ch);

        if (curl_errno($ch)) {
            var_dump(curl_error($ch));  // Prints curl request error if exists
        }

        curl_close ($ch);

        if ($this->debugRequests) {
            var_dump($raw);
        }

        return $raw;
    }
}
