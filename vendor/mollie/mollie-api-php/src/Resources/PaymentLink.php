<?php

namespace Mollie\Api\Resources;

class PaymentLink extends BaseResource
{
    /**
     * Id of the payment link (on the Mollie platform).
     *
     * @var string
     */
    public $id;

    /**
     * Mode of the payment link, either "live" or "test" depending on the API Key that was
     * used.
     *
     * @var string
     */
    public $mode;

    /**
     * The profile ID this payment link belongs to.
     *
     * @example pfl_QkEhN94Ba
     * @var string
     */
    public $profileId;

    /**
     * UTC datetime the payment link was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $createdAt;

    /**
     * UTC datetime the payment was paid in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $paidAt;

    /**
     * Whether the payment link is archived. Customers will not be able to complete
     * payments on archived payment links.
     *
     * @var bool
     */
    public $archived;
    
    /**
     * UTC datetime the payment link was updated in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $updatedAt;

    /**
     * UTC datetime - the expiry date of the payment link in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $expiresAt;

    /**
     * Amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * Description of the payment link that is shown to the customer during the payment,
     * and possibly on the bank or credit card statement.
     *
     * @var string
     */
    public $description;

    /**
     * Redirect URL set on this payment
     *
     * @var string
     */
    public $redirectUrl;

    /**
     * Webhook URL set on this payment link
     *
     * @var string|null
     */
    public $webhookUrl;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * Is this payment paid for?
     *
     * @return bool
     */
    public function isPaid()
    {
        return ! empty($this->paidAt);
    }

    /**
     * Get the checkout URL where the customer can complete the payment.
     *
     * @return string|null
     */
    public function getCheckoutUrl()
    {
        if (empty($this->_links->paymentLink)) {
            return null;
        }

        return $this->_links->paymentLink->href;
    }

    /**
     * Persist the current local Payment Link state to the Mollie API.
     *
     * @return mixed|\Mollie\Api\Resources\BaseResource
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = $this->withPresetOptions([
            'description' => $this->description,
            'archived' => $this->archived,
        ]);

        $result = $this->client->paymentLinks->update($this->id, $body);

        return ResourceFactory::createFromApiResult($result, new PaymentLink($this->client));
    }

    /**
     * Archive this Payment Link.
     *
     * @return \Mollie\Api\Resources\PaymentLink
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function archive()
    {
        $data = $this->withPresetOptions([
            'archived' => true,
        ]);

        return $this->client->paymentLinks->update($this->id, $data);
    }

    /**
     * Retrieve a paginated list of payments associated with this payment link.
     *
     * @param string|null $from
     * @param int|null $limit
     * @param array $filters
     * @return mixed|\Mollie\Api\Resources\BaseCollection
     */
    public function payments(?string $from = null, ?int $limit = null, array $filters = [])
    {
        return $this->client->paymentLinkPayments->pageFor(
            $this,
            $from,
            $limit,
            $this->withPresetOptions($filters)
        );
    }

    /**
     * When accessed by oAuth we want to pass the testmode by default
     *
     * @return array
     */
    private function getPresetOptions()
    {
        $options = [];
        if ($this->client->usesOAuth()) {
            $options["testmode"] = $this->mode === "test";
        }

        return $options;
    }

    /**
     * Apply the preset options.
     *
     * @param array $options
     * @return array
     */
    private function withPresetOptions(array $options)
    {
        return array_merge($this->getPresetOptions(), $options);
    }
}
