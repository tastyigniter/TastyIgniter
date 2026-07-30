<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Stores information about an invoice. You use the Invoices API to create and manage
 * invoices. For more information, see [Invoices API Overview](https://developer.squareup.
 * com/docs/invoices-api/overview).
 */
class Invoice implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $orderId = [];

    /**
     * @var InvoiceRecipient|null
     */
    private $primaryRecipient;

    /**
     * @var array
     */
    private $paymentRequests = [];

    /**
     * @var string|null
     */
    private $deliveryMethod;

    /**
     * @var array
     */
    private $invoiceNumber = [];

    /**
     * @var array
     */
    private $title = [];

    /**
     * @var array
     */
    private $description = [];

    /**
     * @var array
     */
    private $scheduledAt = [];

    /**
     * @var string|null
     */
    private $publicUrl;

    /**
     * @var Money|null
     */
    private $nextPaymentAmountMoney;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $timezone;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var InvoiceAcceptedPaymentMethods|null
     */
    private $acceptedPaymentMethods;

    /**
     * @var array
     */
    private $customFields = [];

    /**
     * @var string|null
     */
    private $subscriptionId;

    /**
     * @var array
     */
    private $saleOrServiceDate = [];

    /**
     * @var array
     */
    private $paymentConditions = [];

    /**
     * @var array
     */
    private $storePaymentMethodEnabled = [];

    /**
     * Returns Id.
     * The Square-assigned ID of the invoice.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the invoice.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Version.
     * The Square-assigned version number, which is incremented each time an update is committed to the
     * invoice.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The Square-assigned version number, which is incremented each time an update is committed to the
     * invoice.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Location Id.
     * The ID of the location that this invoice is associated with.
     *
     * If specified in a `CreateInvoice` request, the value must match the `location_id` of the associated
     * order.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The ID of the location that this invoice is associated with.
     *
     * If specified in a `CreateInvoice` request, the value must match the `location_id` of the associated
     * order.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the location that this invoice is associated with.
     *
     * If specified in a `CreateInvoice` request, the value must match the `location_id` of the associated
     * order.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Order Id.
     * The ID of the [order](entity:Order) for which the invoice is created.
     * This field is required when creating an invoice, and the order must be in the `OPEN` state.
     *
     * To view the line items and other information for the associated order, call the
     * [RetrieveOrder](api-endpoint:Orders-RetrieveOrder) endpoint using the order ID.
     */
    public function getOrderId(): ?string
    {
        if (count($this->orderId) == 0) {
            return null;
        }
        return $this->orderId['value'];
    }

    /**
     * Sets Order Id.
     * The ID of the [order](entity:Order) for which the invoice is created.
     * This field is required when creating an invoice, and the order must be in the `OPEN` state.
     *
     * To view the line items and other information for the associated order, call the
     * [RetrieveOrder](api-endpoint:Orders-RetrieveOrder) endpoint using the order ID.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId['value'] = $orderId;
    }

    /**
     * Unsets Order Id.
     * The ID of the [order](entity:Order) for which the invoice is created.
     * This field is required when creating an invoice, and the order must be in the `OPEN` state.
     *
     * To view the line items and other information for the associated order, call the
     * [RetrieveOrder](api-endpoint:Orders-RetrieveOrder) endpoint using the order ID.
     */
    public function unsetOrderId(): void
    {
        $this->orderId = [];
    }

    /**
     * Returns Primary Recipient.
     * Represents a snapshot of customer data. This object stores customer data that is displayed on the
     * invoice
     * and that Square uses to deliver the invoice.
     *
     * When you provide a customer ID for a draft invoice, Square retrieves the associated customer profile
     * and populates
     * the remaining `InvoiceRecipient` fields. You cannot update these fields after the invoice is
     * published.
     * Square updates the customer ID in response to a merge operation, but does not update other fields.
     */
    public function getPrimaryRecipient(): ?InvoiceRecipient
    {
        return $this->primaryRecipient;
    }

    /**
     * Sets Primary Recipient.
     * Represents a snapshot of customer data. This object stores customer data that is displayed on the
     * invoice
     * and that Square uses to deliver the invoice.
     *
     * When you provide a customer ID for a draft invoice, Square retrieves the associated customer profile
     * and populates
     * the remaining `InvoiceRecipient` fields. You cannot update these fields after the invoice is
     * published.
     * Square updates the customer ID in response to a merge operation, but does not update other fields.
     *
     * @maps primary_recipient
     */
    public function setPrimaryRecipient(?InvoiceRecipient $primaryRecipient): void
    {
        $this->primaryRecipient = $primaryRecipient;
    }

    /**
     * Returns Payment Requests.
     * The payment schedule for the invoice, represented by one or more payment requests that
     * define payment settings, such as amount due and due date. An invoice supports the following payment
     * request combinations:
     * - One balance
     * - One deposit with one balance
     * - 2–12 installments
     * - One deposit with 2–12 installments
     *
     * This field is required when creating an invoice. It must contain at least one payment request.
     * All payment requests for the invoice must equal the total order amount. For more information, see
     * [Configuring payment requests](https://developer.squareup.com/docs/invoices-api/create-publish-
     * invoices#payment-requests).
     *
     * Adding `INSTALLMENT` payment requests to an invoice requires an
     * [Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-
     * subscription).
     *
     * @return InvoicePaymentRequest[]|null
     */
    public function getPaymentRequests(): ?array
    {
        if (count($this->paymentRequests) == 0) {
            return null;
        }
        return $this->paymentRequests['value'];
    }

    /**
     * Sets Payment Requests.
     * The payment schedule for the invoice, represented by one or more payment requests that
     * define payment settings, such as amount due and due date. An invoice supports the following payment
     * request combinations:
     * - One balance
     * - One deposit with one balance
     * - 2–12 installments
     * - One deposit with 2–12 installments
     *
     * This field is required when creating an invoice. It must contain at least one payment request.
     * All payment requests for the invoice must equal the total order amount. For more information, see
     * [Configuring payment requests](https://developer.squareup.com/docs/invoices-api/create-publish-
     * invoices#payment-requests).
     *
     * Adding `INSTALLMENT` payment requests to an invoice requires an
     * [Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-
     * subscription).
     *
     * @maps payment_requests
     *
     * @param InvoicePaymentRequest[]|null $paymentRequests
     */
    public function setPaymentRequests(?array $paymentRequests): void
    {
        $this->paymentRequests['value'] = $paymentRequests;
    }

    /**
     * Unsets Payment Requests.
     * The payment schedule for the invoice, represented by one or more payment requests that
     * define payment settings, such as amount due and due date. An invoice supports the following payment
     * request combinations:
     * - One balance
     * - One deposit with one balance
     * - 2–12 installments
     * - One deposit with 2–12 installments
     *
     * This field is required when creating an invoice. It must contain at least one payment request.
     * All payment requests for the invoice must equal the total order amount. For more information, see
     * [Configuring payment requests](https://developer.squareup.com/docs/invoices-api/create-publish-
     * invoices#payment-requests).
     *
     * Adding `INSTALLMENT` payment requests to an invoice requires an
     * [Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-
     * subscription).
     */
    public function unsetPaymentRequests(): void
    {
        $this->paymentRequests = [];
    }

    /**
     * Returns Delivery Method.
     * Indicates how Square delivers the [invoice]($m/Invoice) to the customer.
     */
    public function getDeliveryMethod(): ?string
    {
        return $this->deliveryMethod;
    }

    /**
     * Sets Delivery Method.
     * Indicates how Square delivers the [invoice]($m/Invoice) to the customer.
     *
     * @maps delivery_method
     */
    public function setDeliveryMethod(?string $deliveryMethod): void
    {
        $this->deliveryMethod = $deliveryMethod;
    }

    /**
     * Returns Invoice Number.
     * A user-friendly invoice number that is displayed on the invoice. The value is unique within a
     * location.
     * If not provided when creating an invoice, Square assigns a value.
     * It increments from 1 and is padded with zeros making it 7 characters long
     * (for example, 0000001 and 0000002).
     */
    public function getInvoiceNumber(): ?string
    {
        if (count($this->invoiceNumber) == 0) {
            return null;
        }
        return $this->invoiceNumber['value'];
    }

    /**
     * Sets Invoice Number.
     * A user-friendly invoice number that is displayed on the invoice. The value is unique within a
     * location.
     * If not provided when creating an invoice, Square assigns a value.
     * It increments from 1 and is padded with zeros making it 7 characters long
     * (for example, 0000001 and 0000002).
     *
     * @maps invoice_number
     */
    public function setInvoiceNumber(?string $invoiceNumber): void
    {
        $this->invoiceNumber['value'] = $invoiceNumber;
    }

    /**
     * Unsets Invoice Number.
     * A user-friendly invoice number that is displayed on the invoice. The value is unique within a
     * location.
     * If not provided when creating an invoice, Square assigns a value.
     * It increments from 1 and is padded with zeros making it 7 characters long
     * (for example, 0000001 and 0000002).
     */
    public function unsetInvoiceNumber(): void
    {
        $this->invoiceNumber = [];
    }

    /**
     * Returns Title.
     * The title of the invoice, which is displayed on the invoice.
     */
    public function getTitle(): ?string
    {
        if (count($this->title) == 0) {
            return null;
        }
        return $this->title['value'];
    }

    /**
     * Sets Title.
     * The title of the invoice, which is displayed on the invoice.
     *
     * @maps title
     */
    public function setTitle(?string $title): void
    {
        $this->title['value'] = $title;
    }

    /**
     * Unsets Title.
     * The title of the invoice, which is displayed on the invoice.
     */
    public function unsetTitle(): void
    {
        $this->title = [];
    }

    /**
     * Returns Description.
     * The description of the invoice, which is displayed on the invoice.
     */
    public function getDescription(): ?string
    {
        if (count($this->description) == 0) {
            return null;
        }
        return $this->description['value'];
    }

    /**
     * Sets Description.
     * The description of the invoice, which is displayed on the invoice.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description['value'] = $description;
    }

    /**
     * Unsets Description.
     * The description of the invoice, which is displayed on the invoice.
     */
    public function unsetDescription(): void
    {
        $this->description = [];
    }

    /**
     * Returns Scheduled At.
     * The timestamp when the invoice is scheduled for processing, in RFC 3339 format.
     * After the invoice is published, Square processes the invoice on the specified date,
     * according to the delivery method and payment request settings.
     *
     * If the field is not set, Square processes the invoice immediately after it is published.
     */
    public function getScheduledAt(): ?string
    {
        if (count($this->scheduledAt) == 0) {
            return null;
        }
        return $this->scheduledAt['value'];
    }

    /**
     * Sets Scheduled At.
     * The timestamp when the invoice is scheduled for processing, in RFC 3339 format.
     * After the invoice is published, Square processes the invoice on the specified date,
     * according to the delivery method and payment request settings.
     *
     * If the field is not set, Square processes the invoice immediately after it is published.
     *
     * @maps scheduled_at
     */
    public function setScheduledAt(?string $scheduledAt): void
    {
        $this->scheduledAt['value'] = $scheduledAt;
    }

    /**
     * Unsets Scheduled At.
     * The timestamp when the invoice is scheduled for processing, in RFC 3339 format.
     * After the invoice is published, Square processes the invoice on the specified date,
     * according to the delivery method and payment request settings.
     *
     * If the field is not set, Square processes the invoice immediately after it is published.
     */
    public function unsetScheduledAt(): void
    {
        $this->scheduledAt = [];
    }

    /**
     * Returns Public Url.
     * The URL of the Square-hosted invoice page.
     * After you publish the invoice using the `PublishInvoice` endpoint, Square hosts the invoice
     * page and returns the page URL in the response.
     */
    public function getPublicUrl(): ?string
    {
        return $this->publicUrl;
    }

    /**
     * Sets Public Url.
     * The URL of the Square-hosted invoice page.
     * After you publish the invoice using the `PublishInvoice` endpoint, Square hosts the invoice
     * page and returns the page URL in the response.
     *
     * @maps public_url
     */
    public function setPublicUrl(?string $publicUrl): void
    {
        $this->publicUrl = $publicUrl;
    }

    /**
     * Returns Next Payment Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getNextPaymentAmountMoney(): ?Money
    {
        return $this->nextPaymentAmountMoney;
    }

    /**
     * Sets Next Payment Amount Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps next_payment_amount_money
     */
    public function setNextPaymentAmountMoney(?Money $nextPaymentAmountMoney): void
    {
        $this->nextPaymentAmountMoney = $nextPaymentAmountMoney;
    }

    /**
     * Returns Status.
     * Indicates the status of an invoice.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * Indicates the status of an invoice.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Timezone.
     * The time zone used to interpret calendar dates on the invoice, such as `due_date`.
     * When an invoice is created, this field is set to the `timezone` specified for the seller
     * location. The value cannot be changed.
     *
     * For example, a payment `due_date` of 2021-03-09 with a `timezone` of America/Los\_Angeles
     * becomes overdue at midnight on March 9 in America/Los\_Angeles (which equals a UTC timestamp
     * of 2021-03-10T08:00:00Z).
     */
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * Sets Timezone.
     * The time zone used to interpret calendar dates on the invoice, such as `due_date`.
     * When an invoice is created, this field is set to the `timezone` specified for the seller
     * location. The value cannot be changed.
     *
     * For example, a payment `due_date` of 2021-03-09 with a `timezone` of America/Los\_Angeles
     * becomes overdue at midnight on March 9 in America/Los\_Angeles (which equals a UTC timestamp
     * of 2021-03-10T08:00:00Z).
     *
     * @maps timezone
     */
    public function setTimezone(?string $timezone): void
    {
        $this->timezone = $timezone;
    }

    /**
     * Returns Created At.
     * The timestamp when the invoice was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the invoice was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp when the invoice was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp when the invoice was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Accepted Payment Methods.
     * The payment methods that customers can use to pay an [invoice]($m/Invoice) on the Square-hosted
     * invoice payment page.
     */
    public function getAcceptedPaymentMethods(): ?InvoiceAcceptedPaymentMethods
    {
        return $this->acceptedPaymentMethods;
    }

    /**
     * Sets Accepted Payment Methods.
     * The payment methods that customers can use to pay an [invoice]($m/Invoice) on the Square-hosted
     * invoice payment page.
     *
     * @maps accepted_payment_methods
     */
    public function setAcceptedPaymentMethods(?InvoiceAcceptedPaymentMethods $acceptedPaymentMethods): void
    {
        $this->acceptedPaymentMethods = $acceptedPaymentMethods;
    }

    /**
     * Returns Custom Fields.
     * Additional seller-defined fields that are displayed on the invoice. For more information, see
     * [Custom fields](https://developer.squareup.com/docs/invoices-api/overview#custom-fields).
     *
     * Adding custom fields to an invoice requires an
     * [Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-
     * subscription).
     *
     * Max: 2 custom fields
     *
     * @return InvoiceCustomField[]|null
     */
    public function getCustomFields(): ?array
    {
        if (count($this->customFields) == 0) {
            return null;
        }
        return $this->customFields['value'];
    }

    /**
     * Sets Custom Fields.
     * Additional seller-defined fields that are displayed on the invoice. For more information, see
     * [Custom fields](https://developer.squareup.com/docs/invoices-api/overview#custom-fields).
     *
     * Adding custom fields to an invoice requires an
     * [Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-
     * subscription).
     *
     * Max: 2 custom fields
     *
     * @maps custom_fields
     *
     * @param InvoiceCustomField[]|null $customFields
     */
    public function setCustomFields(?array $customFields): void
    {
        $this->customFields['value'] = $customFields;
    }

    /**
     * Unsets Custom Fields.
     * Additional seller-defined fields that are displayed on the invoice. For more information, see
     * [Custom fields](https://developer.squareup.com/docs/invoices-api/overview#custom-fields).
     *
     * Adding custom fields to an invoice requires an
     * [Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-
     * subscription).
     *
     * Max: 2 custom fields
     */
    public function unsetCustomFields(): void
    {
        $this->customFields = [];
    }

    /**
     * Returns Subscription Id.
     * The ID of the [subscription](entity:Subscription) associated with the invoice.
     * This field is present only on subscription billing invoices.
     */
    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    /**
     * Sets Subscription Id.
     * The ID of the [subscription](entity:Subscription) associated with the invoice.
     * This field is present only on subscription billing invoices.
     *
     * @maps subscription_id
     */
    public function setSubscriptionId(?string $subscriptionId): void
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * Returns Sale or Service Date.
     * The date of the sale or the date that the service is rendered, in `YYYY-MM-DD` format.
     * This field can be used to specify a past or future date which is displayed on the invoice.
     */
    public function getSaleOrServiceDate(): ?string
    {
        if (count($this->saleOrServiceDate) == 0) {
            return null;
        }
        return $this->saleOrServiceDate['value'];
    }

    /**
     * Sets Sale or Service Date.
     * The date of the sale or the date that the service is rendered, in `YYYY-MM-DD` format.
     * This field can be used to specify a past or future date which is displayed on the invoice.
     *
     * @maps sale_or_service_date
     */
    public function setSaleOrServiceDate(?string $saleOrServiceDate): void
    {
        $this->saleOrServiceDate['value'] = $saleOrServiceDate;
    }

    /**
     * Unsets Sale or Service Date.
     * The date of the sale or the date that the service is rendered, in `YYYY-MM-DD` format.
     * This field can be used to specify a past or future date which is displayed on the invoice.
     */
    public function unsetSaleOrServiceDate(): void
    {
        $this->saleOrServiceDate = [];
    }

    /**
     * Returns Payment Conditions.
     * **France only.** The payment terms and conditions that are displayed on the invoice. For more
     * information,
     * see [Payment conditions](https://developer.squareup.com/docs/invoices-api/overview#payment-
     * conditions).
     *
     * For countries other than France, Square returns an `INVALID_REQUEST_ERROR` with a `BAD_REQUEST` code
     * and
     * "Payment conditions are not supported for this location's country" detail if this field is included
     * in `CreateInvoice` or `UpdateInvoice` requests.
     */
    public function getPaymentConditions(): ?string
    {
        if (count($this->paymentConditions) == 0) {
            return null;
        }
        return $this->paymentConditions['value'];
    }

    /**
     * Sets Payment Conditions.
     * **France only.** The payment terms and conditions that are displayed on the invoice. For more
     * information,
     * see [Payment conditions](https://developer.squareup.com/docs/invoices-api/overview#payment-
     * conditions).
     *
     * For countries other than France, Square returns an `INVALID_REQUEST_ERROR` with a `BAD_REQUEST` code
     * and
     * "Payment conditions are not supported for this location's country" detail if this field is included
     * in `CreateInvoice` or `UpdateInvoice` requests.
     *
     * @maps payment_conditions
     */
    public function setPaymentConditions(?string $paymentConditions): void
    {
        $this->paymentConditions['value'] = $paymentConditions;
    }

    /**
     * Unsets Payment Conditions.
     * **France only.** The payment terms and conditions that are displayed on the invoice. For more
     * information,
     * see [Payment conditions](https://developer.squareup.com/docs/invoices-api/overview#payment-
     * conditions).
     *
     * For countries other than France, Square returns an `INVALID_REQUEST_ERROR` with a `BAD_REQUEST` code
     * and
     * "Payment conditions are not supported for this location's country" detail if this field is included
     * in `CreateInvoice` or `UpdateInvoice` requests.
     */
    public function unsetPaymentConditions(): void
    {
        $this->paymentConditions = [];
    }

    /**
     * Returns Store Payment Method Enabled.
     * Indicates whether to allow a customer to save a credit or debit card as a card on file or a bank
     * transfer as a
     * bank account on file. If `true`, Square displays a __Save my card on file__ or __Save my bank on
     * file__ checkbox on the
     * invoice payment page. Stored payment information can be used for future automatic payments. The
     * default value is `false`.
     */
    public function getStorePaymentMethodEnabled(): ?bool
    {
        if (count($this->storePaymentMethodEnabled) == 0) {
            return null;
        }
        return $this->storePaymentMethodEnabled['value'];
    }

    /**
     * Sets Store Payment Method Enabled.
     * Indicates whether to allow a customer to save a credit or debit card as a card on file or a bank
     * transfer as a
     * bank account on file. If `true`, Square displays a __Save my card on file__ or __Save my bank on
     * file__ checkbox on the
     * invoice payment page. Stored payment information can be used for future automatic payments. The
     * default value is `false`.
     *
     * @maps store_payment_method_enabled
     */
    public function setStorePaymentMethodEnabled(?bool $storePaymentMethodEnabled): void
    {
        $this->storePaymentMethodEnabled['value'] = $storePaymentMethodEnabled;
    }

    /**
     * Unsets Store Payment Method Enabled.
     * Indicates whether to allow a customer to save a credit or debit card as a card on file or a bank
     * transfer as a
     * bank account on file. If `true`, Square displays a __Save my card on file__ or __Save my bank on
     * file__ checkbox on the
     * invoice payment page. Stored payment information can be used for future automatic payments. The
     * default value is `false`.
     */
    public function unsetStorePaymentMethodEnabled(): void
    {
        $this->storePaymentMethodEnabled = [];
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
        if (isset($this->id)) {
            $json['id']                           = $this->id;
        }
        if (isset($this->version)) {
            $json['version']                      = $this->version;
        }
        if (!empty($this->locationId)) {
            $json['location_id']                  = $this->locationId['value'];
        }
        if (!empty($this->orderId)) {
            $json['order_id']                     = $this->orderId['value'];
        }
        if (isset($this->primaryRecipient)) {
            $json['primary_recipient']            = $this->primaryRecipient;
        }
        if (!empty($this->paymentRequests)) {
            $json['payment_requests']             = $this->paymentRequests['value'];
        }
        if (isset($this->deliveryMethod)) {
            $json['delivery_method']              = $this->deliveryMethod;
        }
        if (!empty($this->invoiceNumber)) {
            $json['invoice_number']               = $this->invoiceNumber['value'];
        }
        if (!empty($this->title)) {
            $json['title']                        = $this->title['value'];
        }
        if (!empty($this->description)) {
            $json['description']                  = $this->description['value'];
        }
        if (!empty($this->scheduledAt)) {
            $json['scheduled_at']                 = $this->scheduledAt['value'];
        }
        if (isset($this->publicUrl)) {
            $json['public_url']                   = $this->publicUrl;
        }
        if (isset($this->nextPaymentAmountMoney)) {
            $json['next_payment_amount_money']    = $this->nextPaymentAmountMoney;
        }
        if (isset($this->status)) {
            $json['status']                       = $this->status;
        }
        if (isset($this->timezone)) {
            $json['timezone']                     = $this->timezone;
        }
        if (isset($this->createdAt)) {
            $json['created_at']                   = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']                   = $this->updatedAt;
        }
        if (isset($this->acceptedPaymentMethods)) {
            $json['accepted_payment_methods']     = $this->acceptedPaymentMethods;
        }
        if (!empty($this->customFields)) {
            $json['custom_fields']                = $this->customFields['value'];
        }
        if (isset($this->subscriptionId)) {
            $json['subscription_id']              = $this->subscriptionId;
        }
        if (!empty($this->saleOrServiceDate)) {
            $json['sale_or_service_date']         = $this->saleOrServiceDate['value'];
        }
        if (!empty($this->paymentConditions)) {
            $json['payment_conditions']           = $this->paymentConditions['value'];
        }
        if (!empty($this->storePaymentMethodEnabled)) {
            $json['store_payment_method_enabled'] = $this->storePaymentMethodEnabled['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
