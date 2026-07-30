<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreateTerminalActionResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var TerminalAction|null
     */
    private $action;

    /**
     * Returns Errors.
     * Information on errors encountered during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Information on errors encountered during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * Returns Action.
     * Represents an action processed by the Square Terminal.
     */
    public function getAction(): ?TerminalAction
    {
        return $this->action;
    }

    /**
     * Sets Action.
     * Represents an action processed by the Square Terminal.
     *
     * @maps action
     */
    public function setAction(?TerminalAction $action): void
    {
        $this->action = $action;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->errors)) {
            $json['errors'] = $this->errors;
        }
        if (isset($this->action)) {
            $json['action'] = $this->action;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
