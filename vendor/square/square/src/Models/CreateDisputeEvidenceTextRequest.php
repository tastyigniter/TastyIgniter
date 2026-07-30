<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the parameters for a `CreateDisputeEvidenceText` request.
 */
class CreateDisputeEvidenceTextRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var string|null
     */
    private $evidenceType;

    /**
     * @var string
     */
    private $evidenceText;

    /**
     * @param string $idempotencyKey
     * @param string $evidenceText
     */
    public function __construct(string $idempotencyKey, string $evidenceText)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->evidenceText = $evidenceText;
    }

    /**
     * Returns Idempotency Key.
     * A unique key identifying the request. For more information, see [Idempotency](https://developer.
     * squareup.com/docs/working-with-apis/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique key identifying the request. For more information, see [Idempotency](https://developer.
     * squareup.com/docs/working-with-apis/idempotency).
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Evidence Type.
     * The type of the dispute evidence.
     */
    public function getEvidenceType(): ?string
    {
        return $this->evidenceType;
    }

    /**
     * Sets Evidence Type.
     * The type of the dispute evidence.
     *
     * @maps evidence_type
     */
    public function setEvidenceType(?string $evidenceType): void
    {
        $this->evidenceType = $evidenceType;
    }

    /**
     * Returns Evidence Text.
     * The evidence string.
     */
    public function getEvidenceText(): string
    {
        return $this->evidenceText;
    }

    /**
     * Sets Evidence Text.
     * The evidence string.
     *
     * @required
     * @maps evidence_text
     */
    public function setEvidenceText(string $evidenceText): void
    {
        $this->evidenceText = $evidenceText;
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
        $json['idempotency_key']   = $this->idempotencyKey;
        if (isset($this->evidenceType)) {
            $json['evidence_type'] = $this->evidenceType;
        }
        $json['evidence_text']     = $this->evidenceText;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
