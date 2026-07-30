<?php
namespace net\authorize\util;

use net\authorize\util\LogFactory;
use net\authorize\util\Log;

/**
 * A class to send a request to the XML API.
 *
 * @package    AuthorizeNet
 * @subpackage net\authorize\util
 */
class HttpClient
{
    private $_Url = "";

    public $VERIFY_PEER = true; // attempt trust validation of SSL certificates when establishing secure connections.
    private $logger = NULL;
    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->logger = LogFactory::getLog(get_class($this));
    }

    /**
     * Set a log file.
     *
     * @param string $endPoint end point to hit from  \net\authorize\api\constants\ANetEnvironment
     */
    public function setPostUrl( $endPoint = \net\authorize\api\constants\ANetEnvironment::CUSTOM)
    {
        $this->_Url = sprintf( "%s/xml/v1/request.api", $endPoint);
    }

    /**
     * @return string
     */
    public function _getPostUrl()
    {
        //return (self::URL);
        return ($this->_Url);
    }

    /**
     * Set a log file.
     *
     * @param string $filepath Path to log file.
     */
    public function setLogFile($filepath)
    {
        $this->logger->setLogFile($filepath);
    }

    /**
     * Posts the request to AuthorizeNet endpoint using Curl & returns response.
     *
     * @param string $xmlRequest
     * @return string $xmlResponse The response.
     */
    public function _sendRequest($xmlRequest)
    {
        $xmlResponse = "";

        $post_url = $this->_getPostUrl();
        $curl_request = curl_init($post_url);
        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $xmlRequest);
        curl_setopt($curl_request, CURLOPT_HEADER, 0);
        curl_setopt($curl_request, CURLOPT_TIMEOUT, 45);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYHOST, 2);

        $this->logger->info(sprintf(" Url: %s", $post_url));
        // Do not log requests that could contain CC info.
        $this->logger->info(sprintf("Request to AnetApi: \n%s", $xmlRequest));

        if ($this->VERIFY_PEER) {
            curl_setopt($curl_request, CURLOPT_CAINFO, dirname(dirname(__FILE__)) . '/../../ssl/cert.pem');
        } else {
            $this->logger->error("Invalid SSL option for the request");
            return false;
        }

        if (preg_match('/xml/',$post_url)) {
            curl_setopt($curl_request, CURLOPT_HTTPHEADER, Array("Content-Type: text/json"));
//            file_put_contents($this->_log_file, "\nSending 'XML' Request type", FILE_APPEND);
            $this->logger->info("Sending 'XML' Request type");
        }

        try
        {
            $this->logger->info("Sending http request via Curl");
            $xmlResponse = curl_exec($curl_request);
            $this->logger->info("Response from AnetApi: $xmlResponse");

        } catch (\Exception $ex)
        {
            $errorMessage = sprintf("\n%s:Error making http request via curl: Code:'%s', Message:'%s', Trace:'%s', File:'%s':'%s'",
                $this->now(), $ex->getCode(), $ex->getMessage(), $ex->getTraceAsString(), $ex->getFile(), $ex->getLine() );
            $this->logger->error($errorMessage);
        }
        if ($this->logger && $this->logger->getLogFile()) {
            if ($curl_error = curl_error($curl_request)) {
                $this->logger->error("CURL ERROR: $curl_error");
            }

        }
        curl_close($curl_request);

        return $xmlResponse;
    }

    private function now()
    {
        return date( DATE_RFC2822);
    }
}