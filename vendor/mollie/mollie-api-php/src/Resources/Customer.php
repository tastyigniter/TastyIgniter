<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Exceptions\ApiException;

class Customer extends BaseResource
{
    use HasPresetOptions;

    /**
     * Id of the customer.
     *
     * @var string
     */
    public $id;

    /**
     * Either "live" or "test". Indicates this being a test or a live (verified) customer.
     *
     * @var string
     */
    public $mode;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string|null
     */
    public $locale;

    /**
     * @var \stdClass|mixed|null
     */
    public $metadata;

    /**
     * @var string[]|array
     */
    public $recentlyUsedMethods;

    /**
     * @var string
     */
    public $createdAt;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * @return \Mollie\Api\Resources\Customer
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "name" => $this->name,
            "email" => $this->email,
            "locale" => $this->locale,
            "metadata" => $this->metadata,
        ];

        $result = $this->client->customers->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new Customer($this->client));
    }

    /**
     * @param array $options
     * @param array $filters
     *
     * @return Payment
     * @throws ApiException
     */
    public function createPayment(array $options = [], array $filters = [])
    {
        return $this->client->customerPayments->createFor($this, $this->withPresetOptions($options), $filters);
    }

    /**
     * Get all payments for this customer
     *
     * @return PaymentCollection
     * @throws ApiException
     */
    public function payments()
    {
        return $this->client->customerPayments->listFor($this, null, null, $this->getPresetOptions());
    }

    /**
     * @param array $options
     * @param array $filters
     *
     * @return Subscription
     * @throws ApiException
     */
    public function createSubscription(array $options = [], array $filters = [])
    {
        return $this->client->subscriptions->createFor($this, $this->withPresetOptions($options), $filters);
    }

    /**
     * @param string $subscriptionId
     * @param array $parameters
     *
     * @return Subscription
     * @throws ApiException
     */
    public function getSubscription($subscriptionId, array $parameters = [])
    {
        return $this->client->subscriptions->getFor($this, $subscriptionId, $this->withPresetOptions($parameters));
    }

    /**
     * @param string $subscriptionId
     *
     * @return \Mollie\Api\Resources\Subscription
     * @throws ApiException
     */
    public function cancelSubscription($subscriptionId)
    {
        return $this->client->subscriptions->cancelFor($this, $subscriptionId, $this->getPresetOptions());
    }

    /**
     * Get all subscriptions for this customer
     *
     * @return SubscriptionCollection
     * @throws ApiException
     */
    public function subscriptions()
    {
        return $this->client->subscriptions->listFor($this, null, null, $this->getPresetOptions());
    }

    /**
     * @param array $options
     * @param array $filters
     *
     * @return Mandate
     * @throws ApiException
     */
    public function createMandate(array $options = [], array $filters = [])
    {
        return $this->client->mandates->createFor($this, $this->withPresetOptions($options), $filters);
    }

    /**
     * @param string $mandateId
     * @param array $parameters
     *
     * @return Mandate
     * @throws ApiException
     */
    public function getMandate($mandateId, array $parameters = [])
    {
        return $this->client->mandates->getFor($this, $mandateId, $parameters);
    }

    /**
     * @param string $mandateId
     *
     * @return null
     * @throws ApiException
     */
    public function revokeMandate($mandateId)
    {
        return $this->client->mandates->revokeFor($this, $mandateId, $this->getPresetOptions());
    }

    /**
     * Get all mandates for this customer
     *
     * @return MandateCollection
     * @throws ApiException
     */
    public function mandates()
    {
        return $this->client->mandates->listFor($this, null, null, $this->getPresetOptions());
    }

    /**
     * Helper function to check for mandate with status valid
     *
     * @return bool
     */
    public function hasValidMandate()
    {
        $mandates = $this->mandates();
        foreach ($mandates as $mandate) {
            if ($mandate->isValid()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Helper function to check for specific payment method mandate with status valid
     *
     * @return bool
     */
    public function hasValidMandateForMethod($method)
    {
        $mandates = $this->mandates();
        foreach ($mandates as $mandate) {
            if ($mandate->method === $method && $mandate->isValid()) {
                return true;
            }
        }

        return false;
    }
}
