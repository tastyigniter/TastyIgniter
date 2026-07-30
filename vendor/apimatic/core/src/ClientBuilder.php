<?php

declare(strict_types=1);

namespace Core;

use Core\Request\Parameters\HeaderParam;
use Core\Response\Types\ErrorType;
use Core\Types\Sdk\CoreCallback;
use Core\Utils\CoreHelper;
use Core\Utils\JsonHelper;
use CoreInterfaces\Core\Authentication\AuthInterface;
use CoreInterfaces\Core\Request\ParamInterface;
use CoreInterfaces\Http\HttpClientInterface;
use CoreInterfaces\Sdk\ConverterInterface;

class ClientBuilder
{
    public static function init(HttpClientInterface $httpClient): self
    {
        return new ClientBuilder($httpClient);
    }

    /**
     * @var HttpClientInterface
     */
    private $httpClient;

    /**
     * @var ConverterInterface
     */
    private $converter;

    /**
     * @var array<string,AuthInterface>
     */
    private $authManagers = [];

    /**
     * @var array<string,ErrorType>
     */
    private $globalErrors = [];

    /**
     * @var array<string,string>
     */
    private $serverUrls = [];

    /**
     * @var string|null
     */
    private $defaultServer;

    /**
     * @var ParamInterface[]
     */
    private $globalConfig = [];

    /**
     * @var ParamInterface[]
     */
    private $globalRuntimeConfig = [];

    /**
     * @var CoreCallback|null
     */
    private $apiCallback;

    /**
     * @var string|null
     */
    private $userAgent;

    /**
     * @var array<string,string>
     */
    private $userAgentConfig = [];

    /**
     * @var JsonHelper
     */
    private $jsonHelper;

    private function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function converter(ConverterInterface $converter): self
    {
        $this->converter = $converter;
        return $this;
    }

    /**
     * @param array<string,AuthInterface> $authManagers
     * @return $this
     */
    public function authManagers(array $authManagers): self
    {
        $this->authManagers = $authManagers;
        return $this;
    }

    /**
     * @param array<string,ErrorType> $globalErrors
     * @return $this
     */
    public function globalErrors(array $globalErrors): self
    {
        $this->globalErrors = $globalErrors;
        return $this;
    }

    /**
     * @param array<string,string> $serverUrls
     * @return $this
     */
    public function serverUrls(array $serverUrls, string $defaultServer): self
    {
        $this->serverUrls = $serverUrls;
        $this->defaultServer = $defaultServer;
        return $this;
    }

    public function apiCallback($apiCallback): self
    {
        if ($apiCallback instanceof CoreCallback) {
            $this->apiCallback = $apiCallback;
        }
        return $this;
    }

    /**
     * @param ParamInterface[] $globalParams
     * @return $this
     */
    public function globalConfig(array $globalParams): self
    {
        $this->globalConfig = $globalParams;
        return $this;
    }

    public function globalRuntimeParam(ParamInterface $globalRuntimeParam): self
    {
        $this->globalRuntimeConfig[] = $globalRuntimeParam;
        return $this;
    }

    public function userAgent(string $userAgent): self
    {
        $this->userAgent = $userAgent;
        return $this;
    }

    /**
     * @param array<string,string> $userAgentConfig
     * @return $this
     */
    public function userAgentConfig(array $userAgentConfig): self
    {
        $this->userAgentConfig = $userAgentConfig;
        return $this;
    }

    public function jsonHelper(JsonHelper $jsonHelper): self
    {
        $this->jsonHelper = $jsonHelper;
        return $this;
    }

    private function addUserAgentToGlobalHeaders(): void
    {
        if (is_null($this->userAgent)) {
            return;
        }

        $placeHolders = [
            '{engine}' => 'PHP',
            '{engine-version}' => phpversion(),
            '{os-info}' => CoreHelper::getOsInfo(),
        ];
        $placeHolders = array_merge($placeHolders, $this->userAgentConfig);
        $this->userAgent = str_replace(
            array_keys($placeHolders),
            array_values($placeHolders),
            $this->userAgent
        );
        $this->globalConfig[] = HeaderParam::init('user-agent', $this->userAgent);
        $this->userAgent = null;
    }

    public function build(): Client
    {
        $this->addUserAgentToGlobalHeaders();
        return new Client(
            $this->httpClient,
            $this->converter,
            $this->jsonHelper,
            $this->authManagers,
            $this->serverUrls,
            $this->defaultServer,
            $this->globalConfig,
            $this->globalRuntimeConfig,
            $this->globalErrors,
            $this->apiCallback
        );
    }
}
