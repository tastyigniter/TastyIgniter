<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Types\ApprovalPrompt;

class ClientLink extends BaseResource
{
    /**
     * @var string
     */
    public $resource;

    /**
     * Id of the client link.
     *
     * @example csr_vZCnNQsV2UtfXxYifWKWH
     * @var string
     */
    public $id;

    /**
     * An object with several URL objects relevant to the client link. Every URL object will contain an href and a type field.
     *
     * @var \stdClass
     */
    public $_links;

    /**
     * Get the redirect URL where the customer can complete the payment.
     *
     * @return string|null
     */
    public function getRedirectUrl(string $client_id, string $state, array $scopes = [], string $approval_prompt = ApprovalPrompt::AUTO)
    {
        if (! in_array($approval_prompt, [ApprovalPrompt::AUTO, ApprovalPrompt::FORCE])) {
            throw new \Exception('Invalid approval_prompt. Please use "auto" or "force".');
        }

        $query = http_build_query([
            'client_id' => $client_id,
            'state' => $state,
            'approval_prompt' => $approval_prompt,
            'scope' => implode(' ', $scopes),
        ], '', '&', PHP_QUERY_RFC3986);

        return "{$this->_links->clientLink->href}?{$query}";
    }
}
