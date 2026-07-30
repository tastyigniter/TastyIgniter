<?php
/**
 * Bootstraps the AuthorizeNet PHP SDK test suite
 */

//properties set in file take precedence over environment
//default the value to use
$global_api_login_id    = (defined('AUTHORIZENET_API_LOGIN_ID')    && ''!=AUTHORIZENET_API_LOGIN_ID)    ? AUTHORIZENET_API_LOGIN_ID    : getenv("api_login_id");
$global_transaction_key = (defined('AUTHORIZENET_TRANSACTION_KEY') && ''!=AUTHORIZENET_TRANSACTION_KEY) ? AUTHORIZENET_TRANSACTION_KEY : getenv("transaction_key");
if (!defined('AUTHORIZENET_LOG_FILE'))
{
    define( "AUTHORIZENET_LOG_FILE",  "./authorize-net.log");
}

// Append to log file
$logMessage = sprintf("Logging Started: %s\n", date(DATE_RFC2822));
if (AUTHORIZENET_LOG_FILE)
{
    file_put_contents(AUTHORIZENET_LOG_FILE, $logMessage, FILE_APPEND);
} else {
    echo $logMessage;
}

// validate existence of available extensions
if (!function_exists('simplexml_load_file'))
{
    $errorMessage = 'The AuthorizeNet SDK requires the SimpleXML PHP extension.';
    throw new RuntimeException( $errorMessage );
}

if (!function_exists('curl_init'))
{
    $errorMessage = 'The AuthorizeNet SDK requires the cURL PHP extension.';
    throw new RuntimeException( $errorMessage );
}

// validate existence of credentials
if (null == $global_api_login_id || "" == $global_api_login_id)
{
    $errorMessage = "Property 'AUTHORIZENET_API_LOGIN_ID' not found. Define the property value or set the environment 'api_login_id'";
    throw new RuntimeException( $errorMessage );
}

if (null == $global_transaction_key || "" == $global_transaction_key)
{
    $errorMessage = "Property 'AUTHORIZENET_TRANSACTION_KEY' not found. Define the property value or set the environment 'transaction_key'";
    throw new RuntimeException( $errorMessage );
}

ini_set('error_reporting', E_ALL);

/*
$loader = require '../vendor/autoload.php';
if (!isset($loader))
{
    $errorMessage = 'vendor/autoload.php could not be found.';
    throw new RuntimeException( $errorMessage );
}
*/
