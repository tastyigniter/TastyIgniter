<?php

declare(strict_types=1);

namespace Core\Types\Sdk;

use Closure;
use CoreInterfaces\Core\ContextInterface;
use CoreInterfaces\Core\Request\RequestInterface;
use CoreInterfaces\Sdk\ConverterInterface;

class CoreCallback
{
    /**
     * Callable for on-before event of API calls
     */
    private $onBeforeRequest;

    /**
     * Callable for on-after event of API calls
     */
    private $onAfterRequest;

    /**
     * Create a new HttpCallBack instance
     *
     * @param callable|null $onBeforeRequest Called before an API call
     * @param callable|null $onAfterRequest  Called after an API call
     */
    public function __construct(callable $onBeforeRequest = null, callable $onAfterRequest = null)
    {
        $this->onBeforeRequest = $onBeforeRequest;
        $this->onAfterRequest = $onAfterRequest;
    }

    /**
     * Set On-before API call event callable
     *
     * @param callable $func On-before event callable
     */
    public function setOnBeforeRequest(callable $func): void
    {
        $this->onBeforeRequest = $func;
    }

    /**
     * Get On-before API call event callable
     *
     * @return callable|null Callable
     */
    public function getOnBeforeRequest(): ?callable
    {
        return $this->onBeforeRequest;
    }

    /**
     * Set On-after API call event callable
     *
     * @param callable $func On-after event callable
     */
    public function setOnAfterRequest(callable $func): void
    {
        $this->onAfterRequest = $func;
    }

    /**
     * Get On-After API call event callable
     *
     * @return callable|null On-after event callable
     */
    public function getOnAfterRequest(): ?callable
    {
        return $this->onAfterRequest;
    }

    /**
     * Call on-before event callable
     *
     * @param mixed $request Request for this call
     */
    public function callOnBeforeRequest($request): void
    {
        if ($this->onBeforeRequest != null) {
            Closure::fromCallable($this->onBeforeRequest)($request);
        }
    }

    public function callOnBeforeWithConversion(RequestInterface $request, ConverterInterface $converter)
    {
        $this->callOnBeforeRequest($converter->createHttpRequest($request));
    }

    /**
     * Call on-after event callable
     *
     * @param mixed $context HttpContext for this call
     */
    public function callOnAfterRequest($context): void
    {
        if ($this->onAfterRequest != null) {
            Closure::fromCallable($this->onAfterRequest)($context);
        }
    }

    public function callOnAfterWithConversion(ContextInterface $context, ConverterInterface $converter)
    {
        $this->callOnAfterRequest($converter->createHttpContext($context));
    }
}
