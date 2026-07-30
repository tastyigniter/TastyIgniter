<?php

namespace Core\Tests\Mocking;

use Core\ApiCall;
use Core\Client;
use Core\ClientBuilder;
use Core\Request\Parameters\AdditionalHeaderParams;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\TemplateParam;
use Core\Response\ResponseHandler;
use Core\Response\Types\ErrorType;
use Core\Tests\Mocking\Authentication\FormAuthManager;
use Core\Tests\Mocking\Authentication\HeaderAuthManager;
use Core\Tests\Mocking\Authentication\QueryAuthManager;
use Core\Tests\Mocking\Other\MockChild1;
use Core\Tests\Mocking\Other\MockChild2;
use Core\Tests\Mocking\Other\MockChild3;
use Core\Tests\Mocking\Other\MockClass;
use Core\Tests\Mocking\Other\MockException1;
use Core\Tests\Mocking\Other\MockException2;
use Core\Tests\Mocking\Response\MockResponse;
use Core\Tests\Mocking\Types\MockCallback;
use Core\Tests\Mocking\Types\MockFileWrapper;
use Core\Types\CallbackCatcher;
use Core\Utils\JsonHelper;

class MockHelper
{
    /**
     * @var Client
     */
    private static $client;

    /**
     * @var JsonHelper
     */
    private static $jsonHelper;

    /**
     * @var MockResponse
     */
    private static $response;

    /**
     * @var CallbackCatcher
     */
    private static $callbackCatcher;

    /**
     * @var MockFileWrapper
     */
    private static $fileWrapper;

    /**
     * @var MockFileWrapper
     */
    private static $urlFileWrapper;

    public static function getClient(): Client
    {
        if (!isset(self::$client)) {
            $clientBuilder = ClientBuilder::init(new MockHttpClient())
                ->converter(new MockConverter())
                ->apiCallback(self::getCallbackCatcher())
                ->serverUrls([
                    'Server1' => 'http://my/path:3000/{one}',
                    'Server2' => 'https://my/path/{two}'
                ], 'Server1')
                ->jsonHelper(self::getJsonHelper())
                ->globalConfig([
                    TemplateParam::init('one', 'v1')->dontEncode(),
                    TemplateParam::init('two', 'v2')->dontEncode(),
                    HeaderParam::init('additionalHead1', 'headVal1'),
                    HeaderParam::init('additionalHead2', 'headVal2')
                ])
                ->globalRuntimeParam(AdditionalHeaderParams::init(['key5' => 890.098]))
                ->globalErrors([
                    strval(400) => ErrorType::init('Exception num 1', MockException1::class),
                    strval(401) => ErrorType::init('Exception num 2', MockException2::class),
                    strval(403) => ErrorType::init('Exception num 3')
                ])
                ->authManagers([
                    "header" => new HeaderAuthManager('someAuthToken', 'accessToken'),
                    "headerWithNull" => new HeaderAuthManager('someAuthToken', null),
                    "query" => new QueryAuthManager('someAuthToken', 'accessToken'),
                    "queryWithNull" => new QueryAuthManager(null, 'accessToken'),
                    "form" => new FormAuthManager('someAuthToken', 'accessToken'),
                    "formWithNull" => new FormAuthManager('newAuthToken', null)
                ])
                ->userAgent("{language}|{version}|{engine}|{engine-version}|{os-info}")
                ->userAgentConfig([
                    '{language}' => 'my lang',
                    '{version}' => '1.*.*'
                ]);
            self::$client = $clientBuilder->build();
            // @phan-suppress-next-next-line PhanPluginDuplicateAdjacentStatement Following duplicated line will
            // call `addUserAgentToGlobalHeaders` again to see test if its added again or not
            self::$client = $clientBuilder->build();
        }
        return self::$client;
    }

    public static function newApiCall(): ApiCall
    {
        return new ApiCall(self::getClient());
    }

    public static function responseHandler(): ResponseHandler
    {
        return self::getClient()->getGlobalResponseHandler();
    }

    public static function getJsonHelper(): JsonHelper
    {
        if (!isset(self::$jsonHelper)) {
            self::$jsonHelper = new JsonHelper(
                [MockClass::class => [MockChild1::class, MockChild2::class, MockChild3::class]],
                'addAdditionalProperty',
                'Core\\Tests\\Mocking\\Other'
            );
        }
        return self::$jsonHelper;
    }

    public static function getResponse(): MockResponse
    {
        if (!isset(self::$response)) {
            self::$response = new MockResponse();
        }
        return self::$response;
    }

    public static function getCallback(): MockCallback
    {
        return new MockCallback();
    }

    public static function getCallbackCatcher(): CallbackCatcher
    {
        if (!isset(self::$callbackCatcher)) {
            self::$callbackCatcher = new CallbackCatcher();
        }
        return self::$callbackCatcher;
    }

    public static function getFileWrapper(): MockFileWrapper
    {
        if (!isset(self::$fileWrapper)) {
            $filePath = realpath(__DIR__ . '/Other/testFile.txt');
            self::$fileWrapper = MockFileWrapper::createFromPath($filePath, 'text/plain', 'My Text');
        }
        return self::$fileWrapper;
    }

    public static function getFileWrapperFromUrl(): MockFileWrapper
    {
        if (!isset(self::$urlFileWrapper)) {
            $filePath = MockFileWrapper::getDownloadedRealFilePath('https://gist.githubusercontent.com/asadali214' .
                '/0a64efec5353d351818475f928c50767/raw/8ad3533799ecb4e01a753aaf04d248e6702d4947/testFile.txt');
            self::$urlFileWrapper = MockFileWrapper::createFromPath($filePath, 'text/plain', 'My Text');
        }
        return self::$urlFileWrapper;
    }
}
