<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the parameters for a `CreateDisputeEvidenceFile` request.
 */
class CreateDisputeEvidenceFileRequest implements \JsonSerializable
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
     * @var string|null
     */
    private $contentType;

    /**
     * @param string $idempotencyKey
     */
    public function __construct(string $idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
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
     * Returns Content Type.
     * The MIME type of the uploaded file.
     * The type can be image/heic, image/heif, image/jpeg, application/pdf, image/png, or image/tiff.
     */
    public function getContentType(): ?string
    {
        return $this->contentType;
    }

    /**
     * Sets Content Type.
     * The MIME type of the uploaded file.
     * The type can be image/heic, image/heif, image/jpeg, application/pdf, image/png, or image/tiff.
     *
     * @maps content_type
     */
    public function setContentType(?string $contentType): void
    {
        $this->contentType = $contentType;
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
        if (isset($this->contentType)) {
            $json['content_type']  = $this->contentType;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
