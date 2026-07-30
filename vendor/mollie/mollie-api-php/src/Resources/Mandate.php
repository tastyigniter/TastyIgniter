<?php

namespace Mollie\Api\Resources;

use Mollie\Api\MollieApiClient;
use Mollie\Api\Types\MandateStatus;

class Mandate extends BaseResource
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $mode;

    /**
     * @var string
     */
    public $method;

    /**
     * @var \stdClass|null
     */
    public $details;

    /**
     * @var string
     */
    public $customerId;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var string
     */
    public $mandateReference;

    /**
     * Date of signature, for example: 2018-05-07
     *
     * @var string
     */
    public $signatureDate;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->status === MandateStatus::STATUS_VALID;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return $this->status === MandateStatus::STATUS_PENDING;
    }

    /**
     * @return bool
     */
    public function isInvalid()
    {
        return $this->status === MandateStatus::STATUS_INVALID;
    }

    /**
     * Revoke the mandate
     *
     * @return null|\stdClass|\Mollie\Api\Resources\Mandate
     */
    public function revoke()
    {
        if (! isset($this->_links->self->href)) {
            return $this;
        }

        $body = null;
        if ($this->client->usesOAuth()) {
            $body = json_encode([
                "testmode" => $this->mode === "test" ? true : false,
            ]);
        }

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_DELETE,
            $this->_links->self->href,
            $body
        );

        return $result;
    }
}
