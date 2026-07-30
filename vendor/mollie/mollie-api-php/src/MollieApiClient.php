<?php

namespace Mollie\Api;

use Mollie\Api\Endpoints\BalanceEndpoint;
use Mollie\Api\Endpoints\BalanceReportEndpoint;
use Mollie\Api\Endpoints\BalanceTransactionEndpoint;
use Mollie\Api\Endpoints\CapabilityEndpoint;
use Mollie\Api\Endpoints\ChargebackEndpoint;
use Mollie\Api\Endpoints\ClientEndpoint;
use Mollie\Api\Endpoints\ClientLinkEndpoint;
use Mollie\Api\Endpoints\CustomerEndpoint;
use Mollie\Api\Endpoints\CustomerPaymentsEndpoint;
use Mollie\Api\Endpoints\InvoiceEndpoint;
use Mollie\Api\Endpoints\MandateEndpoint;
use Mollie\Api\Endpoints\MethodEndpoint;
use Mollie\Api\Endpoints\MethodIssuerEndpoint;
use Mollie\Api\Endpoints\OnboardingEndpoint;
use Mollie\Api\Endpoints\OrderEndpoint;
use Mollie\Api\Endpoints\OrderLineEndpoint;
use Mollie\Api\Endpoints\OrderPaymentEndpoint;
use Mollie\Api\Endpoints\OrderRefundEndpoint;
use Mollie\Api\Endpoints\OrganizationEndpoint;
use Mollie\Api\Endpoints\OrganizationPartnerEndpoint;
use Mollie\Api\Endpoints\PaymentCaptureEndpoint;
use Mollie\Api\Endpoints\PaymentChargebackEndpoint;
use Mollie\Api\Endpoints\PaymentEndpoint;
use Mollie\Api\Endpoints\PaymentLinkEndpoint;
use Mollie\Api\Endpoints\PaymentLinkPaymentEndpoint;
use Mollie\Api\Endpoints\PaymentRefundEndpoint;
use Mollie\Api\Endpoints\PaymentRouteEndpoint;
use Mollie\Api\Endpoints\PermissionEndpoint;
use Mollie\Api\Endpoints\ProfileEndpoint;
use Mollie\Api\Endpoints\ProfileMethodEndpoint;
use Mollie\Api\Endpoints\RefundEndpoint;
use Mollie\Api\Endpoints\SalesInvoiceEndpoint;
use Mollie\Api\Endpoints\SessionEndpoint;
use Mollie\Api\Endpoints\SettlementCaptureEndpoint;
use Mollie\Api\Endpoints\SettlementChargebackEndpoint;
use Mollie\Api\Endpoints\SettlementPaymentEndpoint;
use Mollie\Api\Endpoints\SettlementRefundEndpoint;
use Mollie\Api\Endpoints\SettlementsEndpoint;
use Mollie\Api\Endpoints\ShipmentEndpoint;
use Mollie\Api\Endpoints\SubscriptionEndpoint;
use Mollie\Api\Endpoints\SubscriptionPaymentEndpoint;
use Mollie\Api\Endpoints\TerminalEndpoint;
use Mollie\Api\Endpoints\WalletEndpoint;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Exceptions\HttpAdapterDoesNotSupportDebuggingException;
use Mollie\Api\Exceptions\IncompatiblePlatform;
use Mollie\Api\HttpAdapter\MollieHttpAdapterPicker;
use Mollie\Api\Idempotency\DefaultIdempotencyKeyGenerator;

class MollieApiClient
{
    /**
     * Version of our client.
     */
    public const CLIENT_VERSION = "2.79.1";

    /**
     * Endpoint of the remote API.
     */
    public const API_ENDPOINT = "https://api.mollie.com";

    /**
     * Version of the remote API.
     */
    public const API_VERSION = "v2";

    /**
     * HTTP Methods
     */
    public const HTTP_GET = "GET";
    public const HTTP_POST = "POST";
    public const HTTP_DELETE = "DELETE";
    public const HTTP_PATCH = "PATCH";

    /**
     * @var \Mollie\Api\HttpAdapter\MollieHttpAdapterInterface
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $apiEndpoint = self::API_ENDPOINT;

    /**
     * RESTful Payments resource.
     *
     * @var PaymentEndpoint
     */
    public $payments;

    /**
     * RESTful Methods resource.
     *
     * @var MethodEndpoint
     */
    public $methods;

    /**
     * @var ProfileMethodEndpoint
     */
    public $profileMethods;

    /**
     * @var \Mollie\Api\Endpoints\MethodIssuerEndpoint
     */
    public $methodIssuers;

    /**
     * @var \Mollie\Api\Endpoints\CapabilityEndpoint
     */
    public $capabilities;

    /**
     * RESTful Customers resource.
     *
     * @var CustomerEndpoint
     */
    public $customers;

    /**
     * RESTful Customer payments resource.
     *
     * @var CustomerPaymentsEndpoint
     */
    public $customerPayments;

    /**
     * RESTful Sales Invoice resource.
     *
     * @var SalesInvoiceEndpoint
     */
    public $salesInvoices;

    /**
     * RESTful Settlement resource.
     *
     * @var SettlementsEndpoint
     */
    public $settlements;

    /**
     * RESTful Settlement capture resource.
     *
     * @var \Mollie\Api\Endpoints\SettlementCaptureEndpoint
     */
    public $settlementCaptures;

    /**
     * RESTful Settlement chargeback resource.
     *
     * @var \Mollie\Api\Endpoints\SettlementChargebackEndpoint
     */
    public $settlementChargebacks;

    /**
     * RESTful Settlement payment resource.
     *
     * @var \Mollie\Api\Endpoints\SettlementPaymentEndpoint
     */
    public $settlementPayments;

    /**
     * RESTful Settlement refund resource.
     *
     * @var \Mollie\Api\Endpoints\SettlementRefundEndpoint
     */
    public $settlementRefunds;

    /**
     * RESTful Subscription resource.
     *
     * @var SubscriptionEndpoint
     */
    public $subscriptions;

    /**
     * RESTful Subscription Payments resource.
     *
     * @var SubscriptionPaymentEndpoint
     */
    public $subscriptionPayments;

    /**
     * RESTful Mandate resource.
     *
     * @var MandateEndpoint
     */
    public $mandates;

    /**
     * RESTful Profile resource.
     *
     * @var ProfileEndpoint
     */
    public $profiles;

    /**
     * RESTful Organization resource.
     *
     * @var OrganizationEndpoint
     */
    public $organizations;

    /**
     * RESTful Permission resource.
     *
     * @var PermissionEndpoint
     */
    public $permissions;

    /**
     * RESTful Invoice resource.
     *
     * @var InvoiceEndpoint
     */
    public $invoices;

    /**
     * RESTful Balance resource.
     *
     * @var BalanceEndpoint
     */
    public $balances;

    /**
     * @var BalanceTransactionEndpoint
     */
    public $balanceTransactions;

    /**
     * @var BalanceReportEndpoint
     */
    public $balanceReports;

    /**
     * RESTful Onboarding resource.
     *
     * @var OnboardingEndpoint
     */
    public $onboarding;

    /**
     * RESTful Order resource.
     *
     * @var OrderEndpoint
     */
    public $orders;

    /**
     * RESTful OrderLine resource.
     *
     * @var OrderLineEndpoint
     */
    public $orderLines;

    /**
     * RESTful OrderPayment resource.
     *
     * @var OrderPaymentEndpoint
     */
    public $orderPayments;

    /**
     * RESTful Shipment resource.
     *
     * @var ShipmentEndpoint
     */
    public $shipments;

    /**
     * RESTful Refunds resource.
     *
     * @var RefundEndpoint
     */
    public $refunds;

    /**
     * RESTful Payment Refunds resource.
     *
     * @var PaymentRefundEndpoint
     */
    public $paymentRefunds;

    /**
     * RESTful Payment Route resource.
     *
     * @var PaymentRouteEndpoint
     */
    public $paymentRoutes;

    /**
     * RESTful Payment Captures resource.
     *
     * @var PaymentCaptureEndpoint
     */
    public $paymentCaptures;

    /**
     * RESTful Chargebacks resource.
     *
     * @var ChargebackEndpoint
     */
    public $chargebacks;

    /**
     * RESTful Payment Chargebacks resource.
     *
     * @var PaymentChargebackEndpoint
     */
    public $paymentChargebacks;

    /**
     * RESTful Order Refunds resource.
     *
     * @var OrderRefundEndpoint
     */
    public $orderRefunds;

    /**
     * RESTful Payment Link Payment resource.
     *
     * @var PaymentLinkPaymentEndpoint
     */
    public $paymentLinkPayments;

    /**
     * Manages Payment Links requests
     *
     * @var PaymentLinkEndpoint
     */
    public $paymentLinks;

    /**
     * RESTful Terminal resource.
     *
     * @var TerminalEndpoint
     */
    public $terminals;

    /**
     * RESTful Onboarding resource.
     *
     * @var OrganizationPartnerEndpoint
     */
    public $organizationPartners;

    /**
     * Manages Wallet requests
     *
     * @var WalletEndpoint
     */
    public $wallets;

    /**
     * RESTful Client resource.
     *
     * @var ClientEndpoint
     */
    public $clients;

    /**
     * RESTful Client resource.
     *
     * @var ClientLinkEndpoint
     */
    public $clientLinks;

    /**
     * RESTful Session resource.
     *
     * @var SessionEndpoint
     */
    public $sessions;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * True if an OAuth access token is set as API key.
     *
     * @var bool
     */
    protected $oauthAccess;

    /**
     * A unique string ensuring a request to a mutating Mollie endpoint is processed only once.
     * This key resets to null after each request.
     *
     * @var string|null
     */
    protected $idempotencyKey = null;

    /**
     * @var \Mollie\Api\Idempotency\IdempotencyKeyGeneratorContract|null
     */
    protected $idempotencyKeyGenerator;

    /**
     * @var array
     */
    protected $versionStrings = [];

    /**
     * @param \GuzzleHttp\ClientInterface|\Mollie\Api\HttpAdapter\MollieHttpAdapterInterface|null $httpClient
     * @param \Mollie\Api\HttpAdapter\MollieHttpAdapterPickerInterface|null $httpAdapterPicker,
     * @param \Mollie\Api\Idempotency\IdempotencyKeyGeneratorContract $idempotencyKeyGenerator,
     * @throws \Mollie\Api\Exceptions\IncompatiblePlatform|\Mollie\Api\Exceptions\UnrecognizedClientException
     */
    public function __construct($httpClient = null, $httpAdapterPicker = null, $idempotencyKeyGenerator = null)
    {
        $httpAdapterPicker = $httpAdapterPicker ?: new MollieHttpAdapterPicker;
        $this->httpClient = $httpAdapterPicker->pickHttpAdapter($httpClient);

        $compatibilityChecker = new CompatibilityChecker;
        $compatibilityChecker->checkCompatibility();

        $this->initializeEndpoints();
        $this->initializeVersionStrings();
        $this->initializeIdempotencyKeyGenerator($idempotencyKeyGenerator);
    }

    public function initializeEndpoints()
    {
        $this->balanceReports = new BalanceReportEndpoint($this);
        $this->balanceTransactions = new BalanceTransactionEndpoint($this);
        $this->balances = new BalanceEndpoint($this);
        $this->capabilities = new CapabilityEndpoint($this);
        $this->chargebacks = new ChargebackEndpoint($this);
        $this->clientLinks = new ClientLinkEndpoint($this);
        $this->clients = new ClientEndpoint($this);
        $this->customerPayments = new CustomerPaymentsEndpoint($this);
        $this->customers = new CustomerEndpoint($this);
        $this->invoices = new InvoiceEndpoint($this);
        $this->mandates = new MandateEndpoint($this);
        $this->methods = new MethodEndpoint($this);
        $this->methodIssuers = new MethodIssuerEndpoint($this);
        $this->onboarding = new OnboardingEndpoint($this);
        $this->orderLines = new OrderLineEndpoint($this);
        $this->orderPayments = new OrderPaymentEndpoint($this);
        $this->orderRefunds = new OrderRefundEndpoint($this);
        $this->orders = new OrderEndpoint($this);
        $this->organizationPartners = new OrganizationPartnerEndpoint($this);
        $this->organizations = new OrganizationEndpoint($this);
        $this->paymentCaptures = new PaymentCaptureEndpoint($this);
        $this->paymentChargebacks = new PaymentChargebackEndpoint($this);
        $this->paymentLinkPayments = new PaymentLinkPaymentEndpoint($this);
        $this->paymentLinks = new PaymentLinkEndpoint($this);
        $this->paymentRefunds = new PaymentRefundEndpoint($this);
        $this->paymentRoutes = new PaymentRouteEndpoint($this);
        $this->payments = new PaymentEndpoint($this);
        $this->permissions = new PermissionEndpoint($this);
        $this->profileMethods = new ProfileMethodEndpoint($this);
        $this->profiles = new ProfileEndpoint($this);
        $this->refunds = new RefundEndpoint($this);
        $this->salesInvoices = new SalesInvoiceEndpoint($this);
        $this->settlementCaptures = new SettlementCaptureEndpoint($this);
        $this->settlementChargebacks = new SettlementChargebackEndpoint($this);
        $this->settlementPayments = new SettlementPaymentEndpoint($this);
        $this->settlementRefunds = new SettlementRefundEndpoint($this);
        $this->settlements = new SettlementsEndpoint($this);
        $this->sessions = new SessionEndpoint($this);
        $this->shipments = new ShipmentEndpoint($this);
        $this->subscriptionPayments = new SubscriptionPaymentEndpoint($this);
        $this->subscriptions = new SubscriptionEndpoint($this);
        $this->terminals = new TerminalEndpoint($this);
        $this->wallets = new WalletEndpoint($this);
    }

    protected function initializeVersionStrings()
    {
        $this->addVersionString("Mollie/" . self::CLIENT_VERSION);
        $this->addVersionString("PHP/" . phpversion());

        $httpClientVersionString = $this->httpClient->versionString();
        if ($httpClientVersionString) {
            $this->addVersionString($httpClientVersionString);
        }
    }

    /**
     * @param \Mollie\Api\Idempotency\IdempotencyKeyGeneratorContract $generator
     * @return void
     */
    protected function initializeIdempotencyKeyGenerator($generator)
    {
        $this->idempotencyKeyGenerator = $generator ? $generator : new DefaultIdempotencyKeyGenerator;
    }

    /**
     * @param string $url
     *
     * @return MollieApiClient
     */
    public function setApiEndpoint($url)
    {
        $this->apiEndpoint = rtrim(trim($url), '/');

        return $this;
    }

    /**
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    /**
     * @return array
     */
    public function getVersionStrings()
    {
        return $this->versionStrings;
    }

    /**
     * @param string $apiKey The Mollie API key, starting with 'test_' or 'live_'
     *
     * @return MollieApiClient
     * @throws ApiException
     */
    public function setApiKey($apiKey)
    {
        $apiKey = trim($apiKey);

        if (! preg_match('/^(live|test)_\w{30,}$/', $apiKey)) {
            throw new ApiException("Invalid API key: '{$apiKey}'. An API key must start with 'test_' or 'live_' and must be at least 30 characters long.");
        }

        $this->apiKey = $apiKey;
        $this->oauthAccess = false;

        return $this;
    }

    /**
     * @param string $accessToken OAuth access token, starting with 'access_'
     *
     * @return MollieApiClient
     * @throws ApiException
     */
    public function setAccessToken($accessToken)
    {
        $accessToken = trim($accessToken);

        if (! preg_match('/^access_\w+$/', $accessToken)) {
            throw new ApiException("Invalid OAuth access token: '{$accessToken}'. An access token must start with 'access_'.");
        }

        $this->apiKey = $accessToken;
        $this->oauthAccess = true;

        return $this;
    }

    /**
     * Returns null if no API key has been set yet.
     *
     * @return bool|null
     */
    public function usesOAuth()
    {
        return $this->oauthAccess;
    }

    /**
     * @param string $versionString
     *
     * @return MollieApiClient
     */
    public function addVersionString($versionString)
    {
        $this->versionStrings[] = str_replace([" ", "\t", "\n", "\r"], '-', $versionString);

        return $this;
    }

    /**
     * Enable debugging mode. If debugging mode is enabled, the attempted request will be included in the ApiException.
     * By default, debugging is disabled to prevent leaking sensitive request data into exception logs.
     *
     * @throws \Mollie\Api\Exceptions\HttpAdapterDoesNotSupportDebuggingException
     */
    public function enableDebugging()
    {
        if (
            ! method_exists($this->httpClient, 'supportsDebugging')
            || ! $this->httpClient->supportsDebugging()
        ) {
            throw new HttpAdapterDoesNotSupportDebuggingException(
                "Debugging is not supported by " . get_class($this->httpClient) . "."
            );
        }

        $this->httpClient->enableDebugging();
    }

    /**
     * Disable debugging mode. If debugging mode is enabled, the attempted request will be included in the ApiException.
     * By default, debugging is disabled to prevent leaking sensitive request data into exception logs.
     *
     * @throws \Mollie\Api\Exceptions\HttpAdapterDoesNotSupportDebuggingException
     */
    public function disableDebugging()
    {
        if (
            ! method_exists($this->httpClient, 'supportsDebugging')
            || ! $this->httpClient->supportsDebugging()
        ) {
            throw new HttpAdapterDoesNotSupportDebuggingException(
                "Debugging is not supported by " . get_class($this->httpClient) . "."
            );
        }

        $this->httpClient->disableDebugging();
    }

    /**
     * Set the idempotency key used on the next request. The idempotency key is a unique string ensuring a request to a
     * mutating Mollie endpoint is processed only once. The idempotency key resets to null after each request. Using
     * the setIdempotencyKey method supersedes the IdempotencyKeyGenerator.
     *
     * @param $key
     * @return $this
     */
    public function setIdempotencyKey($key)
    {
        $this->idempotencyKey = $key;

        return $this;
    }

    /**
     * Retrieve the idempotency key. The idempotency key is a unique string ensuring a request to a
     * mutating Mollie endpoint is processed only once. Note that the idempotency key gets reset to null after each
     * request.
     *
     * @return string|null
     */
    public function getIdempotencyKey()
    {
        return $this->idempotencyKey;
    }

    /**
     * Reset the idempotency key. Note that the idempotency key automatically resets to null after each request.
     * @return $this
     */
    public function resetIdempotencyKey()
    {
        $this->idempotencyKey = null;

        return $this;
    }

    /**
     * @param \Mollie\Api\Idempotency\IdempotencyKeyGeneratorContract $generator
     * @return \Mollie\Api\MollieApiClient
     */
    public function setIdempotencyKeyGenerator($generator)
    {
        $this->idempotencyKeyGenerator = $generator;

        return $this;
    }

    /**
     * @return \Mollie\Api\MollieApiClient
     */
    public function clearIdempotencyKeyGenerator()
    {
        $this->idempotencyKeyGenerator = null;

        return $this;
    }

    /**
     * Perform a http call. This method is used by the resource specific classes. Please use the $payments property to
     * perform operations on payments.
     *
     * @param string $httpMethod
     * @param string $apiMethod
     * @param string|null $httpBody
     *
     * @return \stdClass
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCall($httpMethod, $apiMethod, $httpBody = null)
    {
        $url = $this->apiEndpoint . "/" . self::API_VERSION . "/" . $apiMethod;

        return $this->performHttpCallToFullUrl($httpMethod, $url, $httpBody);
    }

    /**
     * Perform a http call to a full url. This method is used by the resource specific classes.
     *
     * @see $payments
     * @see $isuers
     *
     * @param string $httpMethod
     * @param string $url
     * @param string|null $httpBody
     *
     * @return \stdClass|null
     * @throws ApiException
     *
     * @codeCoverageIgnore
     */
    public function performHttpCallToFullUrl($httpMethod, $url, $httpBody = null)
    {
        if (empty($this->apiKey)) {
            throw new ApiException("You have not set an API key or OAuth access token. Please use setApiKey() to set the API key.");
        }

        $userAgent = implode(' ', $this->versionStrings);

        if ($this->usesOAuth()) {
            $userAgent .= " OAuth/2.0";
        }

        $headers = [
            'Accept' => "application/json",
            'Authorization' => "Bearer {$this->apiKey}",
            'User-Agent' => $userAgent,
        ];

        if ($httpBody !== null) {
            $headers['Content-Type'] = "application/json";
        }

        if (function_exists("php_uname")) {
            $headers['X-Mollie-Client-Info'] = php_uname();
        }

        $headers = $this->applyIdempotencyKey($headers, $httpMethod);

        $response = $this->httpClient->send($httpMethod, $url, $headers, $httpBody);

        $this->resetIdempotencyKey();

        return $response;
    }

    /**
     * Conditionally apply the idempotency key to the request headers
     *
     * @param array $headers
     * @param string $httpMethod
     * @return array
     */
    private function applyIdempotencyKey(array $headers, string $httpMethod)
    {
        if (! in_array($httpMethod, [self::HTTP_POST, self::HTTP_PATCH, self::HTTP_DELETE])) {
            unset($headers['Idempotency-Key']);

            return $headers;
        }

        if ($this->idempotencyKey) {
            $headers['Idempotency-Key'] = $this->idempotencyKey;

            return $headers;
        }

        if ($this->idempotencyKeyGenerator) {
            $headers['Idempotency-Key'] = $this->idempotencyKeyGenerator->generate();

            return $headers;
        }

        unset($headers['Idempotency-Key']);

        return $headers;
    }

    /**
     * Serialization can be used for caching. Of course doing so can be dangerous but some like to live dangerously.
     *
     * \serialize() should be called on the collections or object you want to cache.
     *
     * We don't need any property that can be set by the constructor, only properties that are set by setters.
     *
     * Note that the API key is not serialized, so you need to set the key again after unserializing if you want to do
     * more API calls.
     *
     * @deprecated
     * @return string[]
     */
    public function __sleep()
    {
        return ["apiEndpoint"];
    }

    /**
     * When unserializing a collection or a resource, this class should restore itself.
     *
     * Note that if you have set an HttpAdapter, this adapter is lost on wakeup and reset to the default one.
     *
     * @throws IncompatiblePlatform If suddenly unserialized on an incompatible platform.
     */
    public function __wakeup()
    {
        $this->__construct();
    }
}
