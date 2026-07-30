<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class DisputeEvidence implements \JsonSerializable
{
    /**
     * @var array
     */
    private $evidenceId = [];

    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $disputeId = [];

    /**
     * @var DisputeEvidenceFile|null
     */
    private $evidenceFile;

    /**
     * @var array
     */
    private $evidenceText = [];

    /**
     * @var array
     */
    private $uploadedAt = [];

    /**
     * @var string|null
     */
    private $evidenceType;

    /**
     * Returns Evidence Id.
     * The Square-generated ID of the evidence.
     */
    public function getEvidenceId(): ?string
    {
        if (count($this->evidenceId) == 0) {
            return null;
        }
        return $this->evidenceId['value'];
    }

    /**
     * Sets Evidence Id.
     * The Square-generated ID of the evidence.
     *
     * @maps evidence_id
     */
    public function setEvidenceId(?string $evidenceId): void
    {
        $this->evidenceId['value'] = $evidenceId;
    }

    /**
     * Unsets Evidence Id.
     * The Square-generated ID of the evidence.
     */
    public function unsetEvidenceId(): void
    {
        $this->evidenceId = [];
    }

    /**
     * Returns Id.
     * The Square-generated ID of the evidence.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-generated ID of the evidence.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Dispute Id.
     * The ID of the dispute the evidence is associated with.
     */
    public function getDisputeId(): ?string
    {
        if (count($this->disputeId) == 0) {
            return null;
        }
        return $this->disputeId['value'];
    }

    /**
     * Sets Dispute Id.
     * The ID of the dispute the evidence is associated with.
     *
     * @maps dispute_id
     */
    public function setDisputeId(?string $disputeId): void
    {
        $this->disputeId['value'] = $disputeId;
    }

    /**
     * Unsets Dispute Id.
     * The ID of the dispute the evidence is associated with.
     */
    public function unsetDisputeId(): void
    {
        $this->disputeId = [];
    }

    /**
     * Returns Evidence File.
     * A file to be uploaded as dispute evidence.
     */
    public function getEvidenceFile(): ?DisputeEvidenceFile
    {
        return $this->evidenceFile;
    }

    /**
     * Sets Evidence File.
     * A file to be uploaded as dispute evidence.
     *
     * @maps evidence_file
     */
    public function setEvidenceFile(?DisputeEvidenceFile $evidenceFile): void
    {
        $this->evidenceFile = $evidenceFile;
    }

    /**
     * Returns Evidence Text.
     * Raw text
     */
    public function getEvidenceText(): ?string
    {
        if (count($this->evidenceText) == 0) {
            return null;
        }
        return $this->evidenceText['value'];
    }

    /**
     * Sets Evidence Text.
     * Raw text
     *
     * @maps evidence_text
     */
    public function setEvidenceText(?string $evidenceText): void
    {
        $this->evidenceText['value'] = $evidenceText;
    }

    /**
     * Unsets Evidence Text.
     * Raw text
     */
    public function unsetEvidenceText(): void
    {
        $this->evidenceText = [];
    }

    /**
     * Returns Uploaded At.
     * The time when the evidence was uploaded, in RFC 3339 format.
     */
    public function getUploadedAt(): ?string
    {
        if (count($this->uploadedAt) == 0) {
            return null;
        }
        return $this->uploadedAt['value'];
    }

    /**
     * Sets Uploaded At.
     * The time when the evidence was uploaded, in RFC 3339 format.
     *
     * @maps uploaded_at
     */
    public function setUploadedAt(?string $uploadedAt): void
    {
        $this->uploadedAt['value'] = $uploadedAt;
    }

    /**
     * Unsets Uploaded At.
     * The time when the evidence was uploaded, in RFC 3339 format.
     */
    public function unsetUploadedAt(): void
    {
        $this->uploadedAt = [];
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
        if (!empty($this->evidenceId)) {
            $json['evidence_id']   = $this->evidenceId['value'];
        }
        if (isset($this->id)) {
            $json['id']            = $this->id;
        }
        if (!empty($this->disputeId)) {
            $json['dispute_id']    = $this->disputeId['value'];
        }
        if (isset($this->evidenceFile)) {
            $json['evidence_file'] = $this->evidenceFile;
        }
        if (!empty($this->evidenceText)) {
            $json['evidence_text'] = $this->evidenceText['value'];
        }
        if (!empty($this->uploadedAt)) {
            $json['uploaded_at']   = $this->uploadedAt['value'];
        }
        if (isset($this->evidenceType)) {
            $json['evidence_type'] = $this->evidenceType;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
