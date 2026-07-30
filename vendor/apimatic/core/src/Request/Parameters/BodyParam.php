<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

use CoreInterfaces\Core\Request\RequestSetterInterface;

class BodyParam extends Parameter
{
    /**
     * Initializes a body parameter with the value specified.
     */
    public static function init($value): self
    {
        return new self('', $value);
    }

    /**
     * Initializes a body parameter with the value and key provided.
     *
     * @param string $key
     * @param mixed $value
     */
    public static function initWrapped(string $key, $value): self
    {
        return new self($key, $value);
    }

    private function __construct(string $key, $value)
    {
        parent::__construct($key, $value, 'body');
    }

    /**
     * Adds the parameter to the request provided.
     *
     * @param RequestSetterInterface $request The request to add the parameter to.
     */
    public function apply(RequestSetterInterface $request): void
    {
        if ($this->validated) {
            $request->addBodyParam($this->value, $this->key);
        }
    }
}
