<?php

declare(strict_types=1);

namespace Core;

use Core\Request\RequestBuilder;
use Core\Response\Context;
use Core\Response\ResponseHandler;

class ApiCall
{
    private $coreClient;

    /**
     * @var RequestBuilder|null
     */
    private $requestBuilder;

    /**
     * @var ResponseHandler
     */
    private $responseHandler;

    public function __construct(Client $coreClient)
    {
        $this->coreClient = $coreClient;
        $this->responseHandler = $coreClient->getGlobalResponseHandler();
    }

    public function requestBuilder(RequestBuilder $requestBuilder): self
    {
        $this->requestBuilder = $requestBuilder;
        return $this;
    }

    public function responseHandler(ResponseHandler $responseHandler): self
    {
        $this->responseHandler = $responseHandler;
        return $this;
    }

    public function execute()
    {
        $request = $this->requestBuilder->build($this->coreClient);
        $request->addAcceptHeader($this->responseHandler->getFormat());
        $this->coreClient->beforeRequest($request);
        $response = $this->coreClient->getHttpClient()->execute($request);
        $context = new Context($request, $response, $this->coreClient);
        $this->coreClient->afterResponse($context);
        return $this->responseHandler->getResult($context);
    }
}
