<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the parameters for a `DeprecatedCreateDisputeEvidenceFile` request.
 */
class DeprecatedCreateDisputeEvidenceFileRequest implements \JsonSerializable
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
     * @var array
     */
    private $contentType = [];

    /**
     * @param string $idempotencyKey
     */
    public function __construct(string $idempotencyKey)
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Idempotency Key.
     * The Unique ID. For more information, see [Idempotency](https://developer.squareup.com/docs/working-
     * with-apis/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * The Unique ID. For more information, see [Idempotency](https://developer.squareup.com/docs/working-
     * with-apis/idempotency).
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
        if (count($this->contentType) == 0) {
            return null;
        }
        return $this->contentType['value'];
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
        $this->contentType['value'] = $contentType;
    }

    /**
     * Unsets Content Type.
     * The MIME type of the uploaded file.
     * The type can be image/heic, image/heif, image/jpeg, application/pdf, image/png, or image/tiff.
     */
    public function unsetContentType(): void
    {
        $this->contentType = [];
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
        if (!empty($this->contentType)) {
            $json['content_type']  = $this->contentType['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
