<?php

declare(strict_types=1);

namespace Core;

use Core\Authentication\Auth;
use Core\Request\Parameters\MultipleParams;
use Core\Request\Request;
use Core\Response\Context;
use Core\Response\ResponseHandler;
use Core\Response\Types\ErrorType;
use Core\Types\Sdk\CoreCallback;
use Core\Utils\JsonHelper;
use CoreInterfaces\Core\Authentication\AuthInterface;
use CoreInterfaces\Core\Request\ParamInterface;
use CoreInterfaces\Http\HttpClientInterface;
use CoreInterfaces\Sdk\ConverterInterface;

class Client
{
    private static $converter;
    private static $jsonHelper;
    public static function getConverter(Client $client = null): ConverterInterface
    {
        if (isset($client)) {
            return $client->localConverter;
        }
        return self::$converter;
    }
    public static function getJsonHelper(Client $client = null): JsonHelper
    {
        if (isset($client)) {
            return $client->localJsonHelper;
        }
        return self::$jsonHelper;
    }

    private $httpClient;
    private $localConverter;
    private $localJsonHelper;
    private $authManagers;
    private $serverUrls;
    private $defaultServer;
    private $globalConfig;
    private $globalRuntimeConfig;
    private $globalErrors;
    private $apiCallback;

    /**
     * @param HttpClientInterface $httpClient
     * @param ConverterInterface $converter
     * @param JsonHelper $jsonHelper
     * @param array<string,AuthInterface> $authManagers
     * @param array<string,string> $serverUrls
     * @param string $defaultServer
     * @param ParamInterface[] $globalConfig
     * @param ParamInterface[] $globalRuntimeConfig
     * @param array<string,ErrorType> $globalErrors
     * @param CoreCallback|null $apiCallback
     */
    public function __construct(
        HttpClientInterface $httpClient,
        ConverterInterface $converter,
        JsonHelper $jsonHelper,
        array $authManagers,
        array $serverUrls,
        string $defaultServer,
        array $globalConfig,
        array $globalRuntimeConfig,
        array $globalErrors,
        ?CoreCallback $apiCallback
    ) {
        $this->httpClient = $httpClient;
        self::$converter = $converter;
        $this->localConverter = $converter;
        self::$jsonHelper = $jsonHelper;
        $this->localJsonHelper = $jsonHelper;
        $this->authManagers = $authManagers;
        $this->serverUrls = $serverUrls;
        $this->defaultServer = $defaultServer;
        $this->globalConfig = $globalConfig;
        $this->globalRuntimeConfig = $globalRuntimeConfig;
        $this->globalErrors = $globalErrors;
        $this->apiCallback = $apiCallback;
    }

    public function getGlobalRequest(?string $server = null): Request
    {
        $request = new Request($this->serverUrls[$server ?? $this->defaultServer], $this);
        $paramGroup = new MultipleParams('Global Parameters');
        $paramGroup->parameters($this->globalConfig)->validate(self::getJsonHelper($this));
        $paramGroup->apply($request);
        return $request;
    }

    public function getGlobalResponseHandler(): ResponseHandler
    {
        $responseHandler = new ResponseHandler();
        array_walk($this->globalErrors, function (ErrorType $error, string $key) use ($responseHandler): void {
            $responseHandler->throwErrorOn($key, $error);
        });
        return $responseHandler;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }

    public function validateAuth(Auth $auth): Auth
    {
        $auth->withAuthManagers($this->authManagers)->validate(self::getJsonHelper($this));
        return $auth;
    }

    /**
     * @param ParamInterface[] $parameters
     */
    public function validateParameters(array $parameters): MultipleParams
    {
        $parameters = array_merge($parameters, $this->globalRuntimeConfig);
        $paramGroup = new MultipleParams('Endpoint Parameters');
        $paramGroup->parameters($parameters)->validate(self::getJsonHelper($this));
        return $paramGroup;
    }

    public function beforeRequest(Request $request)
    {
        if (isset($this->apiCallback)) {
            $this->apiCallback->callOnBeforeWithConversion($request, self::getConverter($this));
        }
    }

    public function afterResponse(Context $context)
    {
        if (isset($this->apiCallback)) {
            $this->apiCallback->callOnAfterWithConversion($context, self::getConverter($this));
        }
    }
}
