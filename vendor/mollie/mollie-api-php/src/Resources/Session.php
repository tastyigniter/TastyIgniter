<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Types\SessionStatus;

class Session extends BaseResource
{
    use HasPresetOptions;

    /**
     * The session's unique identifier,
     *
     * @example sess_dfsklg13jO
     * @var string
     */
    public $id;

    /**
     * Status of the session.
     *
     * @var string
     */
    public $status;

    /**
     * UTC datetime indicating the time at which the Session failed in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $failedAt;

    /**
     * Unique identifier to record the Userʼs authentication with a method
     *
     * @var string
     */
    public $authenticationId;

    /**
     * Indicates the next action to take in the payment preparation flow.
     *
     * @var string
     */
    public $nextAction;

    /**
     * The URL the buyer will be redirected to in case the
     * payment preparation process requires a 3rd party redirect.
     *
     * @var string
     */
    public $redirectUrl;

    /**
     * The URL the buyer will be redirected to if they
     * cancel their payment during a 3rd party redirect..
     *
     * @var string
     */
    public $cancelUrl;

    /**
     * The amount you intend to charge containing the value and currency.
     *
     * Note - this is not necessarily the final amount of the
     * payment.You will specify the final amount upon Order creation
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * Description of the payment intent.
     *
     * @var string
     */
    public $description;

    /**
     * Payment method currently selected by the shopper.
     *
     * @var string
     */
    public $method;

    /**
     * All additional information relating to the selected method.
     *
     * @var \stdClass
     */
    public $methodDetails;

    /**
     * The person and the address the payment is shipped to.
     *
     * @deprecated
     * @var \stdClass
     */
    public $shippingAddress;

    /**
     * The person and the address the payment is billed to.
     *
     * @deprecated
     * @var \stdClass
     *
     */
    public $billingAddress;

    /**
     * An object with several URL objects relevant to the customer. Every URL object will contain an href and a type field.
     * @var \stdClass
     */
    public $_links;

    public function isCreated()
    {
        return $this->status === SessionStatus::STATUS_CREATED;
    }

    public function isReadyForProcessing()
    {
        return $this->status === SessionStatus::STATUS_READY_FOR_PROCESSING;
    }

    public function isCompleted()
    {
        return $this->status === SessionStatus::STATUS_COMPLETED;
    }

    public function hasFailed()
    {
        return $this->status === SessionStatus::STATUS_FAILED;
    }

    /**
     * Saves the session's updatable properties.
     *
     * @return \Mollie\Api\Resources\Session
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            'billingAddress' => $this->billingAddress,
            'shippingAddress' => $this->shippingAddress,
        ];

        $result = $this->client->sessions->update($this->id, $this->withPresetOptions($body));

        return ResourceFactory::createFromApiResult($result, new Session($this->client));
    }

    /**
     * Cancels this session.
     *
     * @return Session
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function cancel()
    {
        return $this->client->sessions->cancel($this->id, $this->getPresetOptions());
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl()
    {
        if (empty($this->_links->redirect)) {
            return null;
        }

        return $this->_links->redirect->href;
    }
}
