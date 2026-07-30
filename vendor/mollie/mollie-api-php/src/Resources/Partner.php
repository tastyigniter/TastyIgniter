<?php

namespace Mollie\Api\Resources;

class Partner extends BaseResource
{
    /**
     * Indicates the type of partner. Will be null if the currently authenticated organization is
     * not enrolled as a partner. Possible values: "oauth", "signuplink", "useragent".
     *
     * @var string
     */
    public $partnerType;

    /**
     * Will be true if partner is receiving commissions. Will be null otherwise.
     *
     * @var bool|null
     */
    public $isCommissionPartner;

    /**
     * Array of user agent token objects. Present if the partner is of type "useragent" or if the partner
     * has had user agent tokens in the past. Will be null otherwise.
     *
     * @var array|null
     */
    public $userAgentTokens;

    /**
     * The date and time the contract was signed, in ISO 8601 format. Will be null if the contract has
     * not yet been signed, or if "partnerType" is null.
     *
     * @var string|null
     */
    public $partnerContractSignedAt;

    /**
     * Will be true if an updated contract is available, requiring the partner’s agreement.
     * Will be null otherwise.
     *
     * @var bool
     */
    public $partnerContractUpdateAvailable;

    /**
     * The date and time the contract will expire, in ISO 8601 format.
     *
     * @var string|null
     */
    public $partnerContractExpiresAt;

    /**
     * @var \stdClass
     */
    public $_links;
}
