<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields in a `CreateDisputeEvidenceFile` response.
 */
class CreateDisputeEvidenceFileResponse implements \JsonSerializable
{
    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var DisputeEvidence|null
     */
    private $evidence;

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
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
     * Returns Evidence.
     */
    public function getEvidence(): ?DisputeEvidence
    {
        return $this->evidence;
    }

    /**
     * Sets Evidence.
     *
     * @maps evidence
     */
    public function setEvidence(?DisputeEvidence $evidence): void
    {
        $this->evidence = $evidence;
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
            $json['errors']   = $this->errors;
        }
        if (isset($this->evidence)) {
            $json['evidence'] = $this->evidence;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
