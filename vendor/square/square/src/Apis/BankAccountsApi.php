<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\GetBankAccountByV1IdResponse;
use Square\Models\GetBankAccountResponse;
use Square\Models\ListBankAccountsResponse;

class BankAccountsApi extends BaseApi
{
    /**
     * Returns a list of [BankAccount]($m/BankAccount) objects linked to a Square account.
     *
     * @param string|null $cursor The pagination cursor returned by a previous call to this
     *        endpoint.
     *        Use it in the next `ListBankAccounts` request to retrieve the next set
     *        of results.
     *
     *        See the [Pagination](https://developer.squareup.com/docs/working-with-
     *        apis/pagination) guide for more information.
     * @param int|null $limit Upper limit on the number of bank accounts to return in the response.
     *        Currently, 1000 is the largest supported limit. You can specify a limit
     *        of up to 1000 bank accounts. This is also the default limit.
     * @param string|null $locationId Location ID. You can specify this optional filter to retrieve
     *        only the linked bank accounts belonging to a specific location.
     *
     * @return ApiResponse Response from the API call
     */
    public function listBankAccounts(
        ?string $cursor = null,
        ?int $limit = null,
        ?string $locationId = null
    ): ApiResponse {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/bank-accounts')
            ->auth('global')
            ->parameters(
                QueryParam::init('cursor', $cursor),
                QueryParam::init('limit', $limit),
                QueryParam::init('location_id', $locationId)
            );

        $_resHandler = $this->responseHandler()->type(ListBankAccountsResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns details of a [BankAccount]($m/BankAccount) identified by V1 bank account ID.
     *
     * @param string $v1BankAccountId Connect V1 ID of the desired `BankAccount`. For more
     *        information, see
     *        [Retrieve a bank account by using an ID issued by V1 Bank Accounts API](https:
     *        //developer.squareup.com/docs/bank-accounts-api#retrieve-a-bank-account-by-using-an-
     *        id-issued-by-v1-bank-accounts-api).
     *
     * @return ApiResponse Response from the API call
     */
    public function getBankAccountByV1Id(string $v1BankAccountId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/bank-accounts/by-v1-id/{v1_bank_account_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('v1_bank_account_id', $v1BankAccountId));

        $_resHandler = $this->responseHandler()->type(GetBankAccountByV1IdResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns details of a [BankAccount]($m/BankAccount)
     * linked to a Square account.
     *
     * @param string $bankAccountId Square-issued ID of the desired `BankAccount`.
     *
     * @return ApiResponse Response from the API call
     */
    public function getBankAccount(string $bankAccountId): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::GET, '/v2/bank-accounts/{bank_account_id}')
            ->auth('global')
            ->parameters(TemplateParam::init('bank_account_id', $bankAccountId));

        $_resHandler = $this->responseHandler()->type(GetBankAccountResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
