<?php

declare(strict_types=1);

namespace Core\Request\Parameters;

use CoreInterfaces\Core\Request\RequestSetterInterface;

class TemplateParam extends Parameter
{
    /**
     * Initializes a template parameter with the key and value provided.
     */
    public static function init(string $key, $value): self
    {
        return new self($key, $value);
    }

    private $encode = true;
    private function __construct(string $key, $value)
    {
        parent::__construct($key, $value, 'template');
    }

    /**
     * Disables http encoding for the parameter.
     */
    public function dontEncode(): self
    {
        $this->encode = false;
        return $this;
    }

    private function getReplacerValue($value): string
    {
        if (is_null($value)) {
            return '';
        }
        if (is_bool($value)) {
            return $this->getEncodedReplacer(var_export($value, true));
        }
        if (is_object($value)) {
            return $this->getReplacerForArray((array) $value);
        }
        if (is_array($value)) {
            return $this->getReplacerForArray($value);
        }
        return $this->getEncodedReplacer($value);
    }

    private function getReplacerForArray(array $value): string
    {
        return implode("/", array_map([$this, 'getReplacerValue'], $value));
    }

    private function getEncodedReplacer($value): string
    {
        $value = strval($value);
        return $this->encode ? urlencode($value) : $value;
    }

    /**
     * Adds the parameter to the request provided.
     *
     * @param RequestSetterInterface $request The request to add the parameter to.
     */
    public function apply(RequestSetterInterface $request): void
    {
        if ($this->validated) {
            $request->addTemplate($this->key, $this->getReplacerValue($this->value));
        }
    }
}
