<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreateTerminalActionRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var TerminalAction
     */
    private $action;

    /**
     * @param string $idempotencyKey
     * @param TerminalAction $action
     */
    public function __construct(string $idempotencyKey, TerminalAction $action)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->action = $action;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `CreateAction` request. Keys can be any valid string
     * but must be unique for every `CreateAction` request.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more
     * information.
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `CreateAction` request. Keys can be any valid string
     * but must be unique for every `CreateAction` request.
     *
     * See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more
     * information.
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Action.
     * Represents an action processed by the Square Terminal.
     */
    public function getAction(): TerminalAction
    {
        return $this->action;
    }

    /**
     * Sets Action.
     * Represents an action processed by the Square Terminal.
     *
     * @required
     * @maps action
     */
    public function setAction(TerminalAction $action): void
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
        $json['idempotency_key'] = $this->idempotencyKey;
        $json['action']          = $this->action;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
