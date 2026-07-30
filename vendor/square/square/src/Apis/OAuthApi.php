<?php

declare(strict_types=1);

namespace Square\Apis;

use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\TemplateParam;
use CoreInterfaces\Core\Request\RequestMethod;
use Square\Http\ApiResponse;
use Square\Models\ObtainTokenRequest;
use Square\Models\ObtainTokenResponse;
use Square\Models\RenewTokenRequest;
use Square\Models\RenewTokenResponse;
use Square\Models\RetrieveTokenStatusResponse;
use Square\Models\RevokeTokenRequest;
use Square\Models\RevokeTokenResponse;

class OAuthApi extends BaseApi
{
    /**
     * `RenewToken` is deprecated. For information about refreshing OAuth access tokens, see
     * [Migrate from Renew to Refresh OAuth Tokens](https://developer.squareup.com/docs/oauth-api/migrate-
     * to-refresh-tokens).
     *
     * Renews an OAuth access token before it expires.
     *
     * OAuth access tokens besides your application's personal access token expire after 30 days.
     * You can also renew expired tokens within 15 days of their expiration.
     * You cannot renew an access token that has been expired for more than 15 days.
     * Instead, the associated user must recomplete the OAuth flow from the beginning.
     *
     * __Important:__ The `Authorization` header for this endpoint must have the
     * following format:
     *
     * ```
     * Authorization: Client APPLICATION_SECRET
     * ```
     *
     * Replace `APPLICATION_SECRET` with the application secret on the Credentials
     * page in the [Developer Dashboard](https://developer.squareup.com/apps).
     *
     * @deprecated
     *
     * @param string $clientId Your application ID, which is available in the OAuth page in the
     *        [Developer Dashboard](https://developer.squareup.com/apps).
     * @param RenewTokenRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     * @param string $authorization Client APPLICATION_SECRET
     *
     * @return ApiResponse Response from the API call
     */
    public function renewToken(string $clientId, RenewTokenRequest $body, string $authorization): ApiResponse
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated.', E_USER_DEPRECATED);

        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/oauth2/clients/{client_id}/access-token/renew')
            ->parameters(
                TemplateParam::init('client_id', $clientId),
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body),
                HeaderParam::init('Authorization', $authorization)
            );

        $_resHandler = $this->responseHandler()->type(RenewTokenResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Revokes an access token generated with the OAuth flow.
     *
     * If an account has more than one OAuth access token for your application, this
     * endpoint revokes all of them, regardless of which token you specify. When an
     * OAuth access token is revoked, all of the active subscriptions associated
     * with that OAuth token are canceled immediately.
     *
     * __Important:__ The `Authorization` header for this endpoint must have the
     * following format:
     *
     * ```
     * Authorization: Client APPLICATION_SECRET
     * ```
     *
     * Replace `APPLICATION_SECRET` with the application secret on the OAuth
     * page for your application on the Developer Dashboard.
     *
     * @param RevokeTokenRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     * @param string $authorization Client APPLICATION_SECRET
     *
     * @return ApiResponse Response from the API call
     */
    public function revokeToken(RevokeTokenRequest $body, string $authorization): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/oauth2/revoke')
            ->parameters(
                HeaderParam::init('Content-Type', 'application/json'),
                BodyParam::init($body),
                HeaderParam::init('Authorization', $authorization)
            );

        $_resHandler = $this->responseHandler()->type(RevokeTokenResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns an OAuth access token and a refresh token unless the
     * `short_lived` parameter is set to `true`, in which case the endpoint
     * returns only an access token.
     *
     * The `grant_type` parameter specifies the type of OAuth request. If
     * `grant_type` is `authorization_code`, you must include the authorization
     * code you received when a seller granted you authorization. If `grant_type`
     * is `refresh_token`, you must provide a valid refresh token. If you are using
     * an old version of the Square APIs (prior to March 13, 2019), `grant_type`
     * can be `migration_token` and you must provide a valid migration token.
     *
     * You can use the `scopes` parameter to limit the set of permissions granted
     * to the access token and refresh token. You can use the `short_lived` parameter
     * to create an access token that expires in 24 hours.
     *
     * __Note:__ OAuth tokens should be encrypted and stored on a secure server.
     * Application clients should never interact directly with OAuth tokens.
     *
     * @param ObtainTokenRequest $body An object containing the fields to POST for the request. See
     *        the corresponding object definition for field details.
     *
     * @return ApiResponse Response from the API call
     */
    public function obtainToken(ObtainTokenRequest $body): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/oauth2/token')
            ->parameters(HeaderParam::init('Content-Type', 'application/json'), BodyParam::init($body));

        $_resHandler = $this->responseHandler()->type(ObtainTokenResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }

    /**
     * Returns information about an [OAuth access token](https://developer.squareup.com/docs/build-
     * basics/access-tokens#get-an-oauth-access-token) or an application’s [personal access token](https:
     * //developer.squareup.com/docs/build-basics/access-tokens#get-a-personal-access-token).
     *
     * Add the access token to the Authorization header of the request.
     *
     * __Important:__ The `Authorization` header you provide to this endpoint must have the following
     * format:
     *
     * ```
     * Authorization: Bearer ACCESS_TOKEN
     * ```
     *
     * where `ACCESS_TOKEN` is a
     * [valid production authorization credential](https://developer.squareup.com/docs/build-basics/access-
     * tokens).
     *
     * If the access token is expired or not a valid access token, the endpoint returns an `UNAUTHORIZED`
     * error.
     *
     * @param string $authorization Client APPLICATION_SECRET
     *
     * @return ApiResponse Response from the API call
     */
    public function retrieveTokenStatus(string $authorization): ApiResponse
    {
        $_reqBuilder = $this->requestBuilder(RequestMethod::POST, '/oauth2/token/status')
            ->parameters(HeaderParam::init('Authorization', $authorization));

        $_resHandler = $this->responseHandler()->type(RetrieveTokenStatusResponse::class)->returnApiResponse();

        return $this->execute($_reqBuilder, $_resHandler);
    }
}
