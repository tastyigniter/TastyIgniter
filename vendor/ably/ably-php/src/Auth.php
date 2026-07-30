<?php
namespace Ably;

use Ably\Exceptions\AblyException;
use Ably\Models\AuthOptions;
use Ably\Models\ClientOptions;
use Ably\Models\TokenDetails;
use Ably\Models\TokenParams;
use Ably\Models\TokenRequest;

/**
 * Provides authentification methods for AblyRest instances
 * @property-read string|null $clientId ClientId currently in use. Null if not
 * authenticated yet or when using anonymous auth.
 */
class Auth {
    protected $defaultAuthOptions;
    protected $defaultTokenParams;
    protected $defaultAuthorizeAuthOptions = [];
    protected $defaultAuthorizeTokenParams = [];
    protected $basicAuth;
    protected $tokenDetails;
    protected $ably;
    const TOKEN_EXPIRY_MARGIN = 15000; // a token is considered expired a bit earlier to prevent race conditions

    public function __construct( AblyRest $ably, ClientOptions $options ) {
        $this->defaultAuthOptions = new AuthOptions($options);
        $this->defaultTokenParams = $options->defaultTokenParams;
        $this->ably = $ably;

        $this->basicAuth = empty( $this->defaultAuthOptions->useTokenAuth ) && $this->defaultAuthOptions->key;

        if ( $this->defaultAuthOptions->key && $this->defaultAuthOptions->clientId == '*' ) {
            throw new AblyException ('Instantiating AblyRest with a wildcard clientId (`*`) not allowed.', 40012, 400);
        }

        // Basic authentication
        if ( $this->basicAuth ) {
            $this->basicAuth = true;
            Log::d( 'Auth: anonymous, using basic auth' );

            if ( !$options->tls ) {
                log::e( 'Auth: trying to use basic key auth over insecure connection' );
                throw new AblyException ( 'Trying to use basic key auth over insecure connection', 40103, 401 );
            }
            return;
        }

        // Token authentication
        if (!empty( $this->defaultAuthOptions->authCallback )) {
            Log::d( 'Auth: using token auth with authCallback' );
        } else if(!empty( $this->defaultAuthOptions->authUrl )) {
            Log::d( 'Auth: using token auth with authUrl' );
        } else if(!empty( $this->defaultAuthOptions->key )) {
            Log::d( 'Auth: using token auth with client-side signing' );
        } else if(!empty( $this->defaultAuthOptions->tokenDetails )) {
            Log::d( 'Auth: using token auth with supplied token only' );
        } else {
            Log::e( 'Auth: no authentication parameters supplied' );
            throw new AblyException ( 'No authentication parameters supplied', 40103, 401 );
        }

        $this->tokenDetails = $this->defaultAuthOptions->tokenDetails;
    }

    /**
     * Magic getter for the $clientId property
     */
    public function __get( $name ) {
        if ($name == 'clientId') {
            if ( empty( $this->tokenDetails ) ) {
                if ( !empty( $this->defaultAuthOptions->clientId ) ) {
                    return $this->defaultAuthOptions->clientId;
                }
            } else {
                return $this->tokenDetails->clientId;
            }

            return null;
        }

        throw new AblyException( 'Undefined property: '.__CLASS__.'::'.$name );
    }

    public function isUsingBasicAuth() {
        return $this->basicAuth;
    }


    public function authorizeInternal( $tokenParams = [], $authOptions = [], $force = true ) {

        if ( !empty( $tokenParams ) ) {
            $tokenParamsCopy = $tokenParams;
            if ( isset( $tokenParamsCopy['timestamp'] ) ) unset( $tokenParamsCopy['timestamp'] );

            $this->defaultAuthorizeTokenParams = array_merge( $this->defaultAuthorizeTokenParams, $tokenParamsCopy );
        }
        if ( !empty( $authOptions ) ) {
            $authOptionsCopy = $authOptions;

            $this->defaultAuthorizeAuthOptions = array_merge( $this->defaultAuthorizeAuthOptions, $authOptionsCopy );
        }

        if ( !$force && !empty( $this->tokenDetails ) ) {
            if ( empty( $this->tokenDetails->expires ) ) {
                // using cached token
                Log::d( 'Auth::authorize: using cached token, unknown expiration time' );
                return $this->tokenDetails;
            } else if ( $this->tokenDetails->expires - self::TOKEN_EXPIRY_MARGIN > Utils\Miscellaneous::systemTime()) {
                // using cached token
                Log::d( 'Auth::authorize: using cached token, expires on ' . date( 'Y-m-d H:i:s', intval($this->tokenDetails->expires / 1000) ) );
                return $this->tokenDetails;
            }
        }

        $tokenParamsWithDefaults = array_merge( $this->defaultAuthorizeTokenParams, $tokenParams );
        $authOptionsWithDefaults = array_merge( $this->defaultAuthorizeAuthOptions, $authOptions );

        Log::d( 'Auth::authorize: requesting new token' );
        $this->tokenDetails = $this->requestToken( $tokenParamsWithDefaults, $authOptionsWithDefaults );
        $this->basicAuth = false;

        return $this->tokenDetails;
    }

    /**
     * Ensures that a valid token is present for the library instance. This will always request a new token.
     * In the event that a new token request is made, the specified options are used.
     * If not already using token based auth, this will enable it.
     * Stores the AuthOptions and TokenParams arguments as defaults for subsequent authorisations.
     * @param array|null $tokenParams Requested token parameters
     * @param array|null $authOptions Overridable auth options, if you don't wish to use the default ones
     * @return \Ably\Models\TokenDetails The new token
     */
    public function authorize( $tokenParams = [], $authOptions = [] ) {
        return $this->authorizeInternal( $tokenParams, $authOptions );
    }

    /**
     * @deprecated 1.0 Please use `authorize` instead
     */
    public function authorise( $tokenParams = [], $authOptions = [] ) {
        Log::w( 'Auth::authorise is deprecated, please use Auth::authorize instead');

        return $this->authorizeInternal( $tokenParams, $authOptions );
    }

    /**
     * Get HTTP headers with authentication data
     * Automatically attempts to authorize token requests
     * @return Array Array of HTTP headers containing an `Authorization` header
     */
    public function getAuthHeaders() {
        $headers = [];
        if ( $this->isUsingBasicAuth() ) {
            $headers[] = 'Authorization: Basic ' . base64_encode( $this->defaultAuthOptions->key );
        } else {
            $this->authorizeInternal( [], [], $force = false ); // authorize only if necessary
            $headers[] = 'Authorization: Bearer ' . base64_encode( $this->tokenDetails->token );
        }

        // RSA7e2
        if ( ! empty( $this->defaultAuthOptions->clientId ) ) {
            $headers[] = 'X-Ably-ClientId: ' . base64_encode( $this->defaultAuthOptions->clientId );
        }

        return $headers;
    }

    /**
     * @return \Ably\Models\TokenDetails Token currently in use
    */
    public function getTokenDetails() {
        return $this->tokenDetails;
    }

    /**
     * Request a new token.
     * @param array|null $tokenParams Requested token parameters
     * @param array|null $authOptions Overridable auth options, if you don't wish to use the default ones
     * @param \Ably\Models\ClientOptions|array $options
     * @throws \Ably\Exceptions\AblyException
     * @return \Ably\Models\TokenDetails The new token
     */
    public function requestToken( $tokenParams = [], $authOptions = [] ) {
        // token clientId priority:
        // $tokenParams->clientId overrides $authOptions->tokenId overrides $this->defaultAuthOptions->clientId overrides $this->defaultTokenParams->clientId
        $tokenClientId = $this->defaultTokenParams->clientId;
        if ( !empty( $this->defaultAuthOptions->clientId ) ) $tokenClientId = $this->defaultAuthOptions->clientId;
        // provided authOptions may override clientId, even with a null value
        if ( array_key_exists( 'clientId', $authOptions ) ) $tokenClientId = $authOptions['clientId'];
        // provided tokenParams may override clientId, even with a null value
        if ( array_key_exists( 'clientId', $tokenParams ) ) $tokenClientId = $tokenParams['clientId'];

        // merge provided auth options with defaults
        $authOptionsMerged = new AuthOptions( array_merge( $this->defaultAuthOptions->toArray(), $authOptions ) );
        $tokenParamsMerged = new TokenParams( array_merge( $this->defaultTokenParams->toArray(), $tokenParams ) );

        $tokenParamsMerged->clientId = $tokenClientId;

        // get a signed token request
        $signedTokenRequest = null;
        if ( !empty( $authOptionsMerged->authCallback ) ) {
            Log::d( 'Auth::requestToken:', 'using token auth with auth_callback' );

            $callback = $authOptionsMerged->authCallback;
            $data = $callback($tokenParamsMerged);

            // returned data can be either a signed TokenRequest or TokenDetails or just a token string
            if ( is_a( $data, '\Ably\Models\TokenRequest' ) ) {
                $signedTokenRequest = $data;
            } else if ( is_a( $data, '\Ably\Models\TokenDetails' ) ) {
                return $data;
            } else if ( is_string( $data ) ) {
                return new TokenDetails( $data );
            } else {
                Log::e( 'Auth::requestToken:', 'Invalid response from authCallback, expecting signed TokenRequest or TokenDetails or a token string' );
                throw new AblyException( 'Invalid response from authCallback' );
            }
        } elseif ( !empty( $authOptionsMerged->authUrl ) ) {
            Log::d( 'Auth::requestToken:', 'using token auth with auth_url' );

            $data = $this->ably->http->request(
                $authOptionsMerged->authMethod,
                $authOptionsMerged->authUrl,
                $authOptionsMerged->authHeaders ? : [],
                array_merge( $authOptionsMerged->authParams ? : [], $tokenParamsMerged->toArray() )
            );

            $data = $data['body'];

            if ( is_string( $data ) ) {
                return new TokenDetails( $data ); // assuming it's a token string
            } else if ( is_object( $data ) ) {
                if ( !empty( $data->issued ) ) { // assuming it's a token
                    return new TokenDetails( $data );
                } else if ( !empty( $data->mac ) ) { // assuming it's a signed token request
                    $signedTokenRequest = new TokenRequest( $data );
                } else {
                    Log::e( 'Auth::requestToken:', 'Invalid response from authURL, expecting JSON representation of signed TokenRequest or TokenDetails' );
                    throw new AblyException( 'Invalid response from authURL' );
                }
            } else {
                Log::e( 'Auth::requestToken:', 'Invalid response from authURL, expecting token string or JSON representation of signed TokenRequest or TokenDetails' );
                throw new AblyException( 'Invalid response from authURL' );
            }
        } elseif ( !empty( $authOptionsMerged->key ) ) {
            Log::d( 'Auth::requestToken:', 'using token auth with client-side signing' );
            $signedTokenRequest = $this->createTokenRequest( $tokenParams, $authOptions );
        } else {
            Log::e( 'Auth::requestToken:', 'Unable to request a Token, auth options don\'t provide means to do so' );
            throw new AblyException( 'Unable to request a Token, auth options don\'t provide means to do so', 40101, 401 );
        }

        // do the request

        $keyName = $signedTokenRequest->keyName;

        if ( empty( $keyName ) ) {
            throw new AblyException( 'No keyName specified in the TokenRequest' );
        }

        $res = $this->ably->post(
            "/keys/{$keyName}/requestToken",
            $headers = [],
            $params = $signedTokenRequest->toArray(),
            $returnHeaders = false,
            $authHeaders = false
        );

        // just in case.. an AblyRequestException should be thrown on the
        // previous step with a 4XX error code on failure
        if ( empty( $res->token ) ) {
            throw new AblyException( 'Failed to get a token', 40100, 401 );
        }

        return new TokenDetails( $res );
    }

    /**
     * Create a signed token request based on known credentials
     * and the given token params. This would typically be used if creating
     * signed requests for submission by another client.
     * @param \Ably\Models\TokenParams $tokenParams
     * @param \Ably\Models\AuthOptions $authOptions
     * @return \Ably\Models\TokenRequest A signed token request
     */
    public function createTokenRequest( $tokenParams = [], $authOptions = [] ) {
        $tokenClientId = $this->defaultTokenParams->clientId;
        if ( !empty( $this->defaultAuthOptions->clientId ) ) $tokenClientId = $this->defaultAuthOptions->clientId;
        if ( array_key_exists( 'clientId', $authOptions ) ) $tokenClientId = $authOptions['clientId'];
        if ( array_key_exists( 'clientId', $tokenParams ) ) $tokenClientId = $tokenParams['clientId'];

        $authOptions = new AuthOptions( array_merge( $this->defaultAuthOptions->toArray(), $authOptions ) );
        $tokenParams = new TokenParams( array_merge( $this->defaultTokenParams->toArray(), $tokenParams ) );
        $tokenParams->clientId = $tokenClientId;

        $keyParts = explode( ':', $authOptions->key );

        if ( count( $keyParts ) != 2 ) {
            Log::e( 'Auth::createTokenRequest', "Can't create signed token request, invalid key specified" );
            throw new AblyException( 'Invalid key specified', 40101, 401 );
        }

        $keyName   = $keyParts[0];
        $keySecret = $keyParts[1];

        $tokenRequest = new TokenRequest( $tokenParams );

        if ( !empty( $tokenRequest->keyName ) && $tokenRequest->keyName != $keyName ) {
            throw new AblyException( 'Incompatible keys specified', 40102, 401 );
        } else {
            $tokenRequest->keyName = $keyName;
        }

        if ( $authOptions->queryTime ) {
            $tokenRequest->timestamp = $this->ably->time();
        } else if ( empty( $tokenRequest->timestamp ) ) {
            $tokenRequest->timestamp = Utils\Miscellaneous::systemTime();
        }

        if ( empty( $tokenRequest->clientId ) ) {
            $tokenRequest->clientId = $authOptions->clientId;
        }

        if ( empty( $tokenRequest->nonce ) ) {
            $tokenRequest->nonce = md5( microtime( true ) . mt_rand() );
        }

        $signText = implode( "\n", [
            empty( $tokenRequest->keyName )    ? '' : $tokenRequest->keyName,
            empty( $tokenRequest->ttl )        ? '' : $tokenRequest->ttl,
            empty( $tokenRequest->capability ) ? '' : $tokenRequest->capability,
            empty( $tokenRequest->clientId )   ? '' : $tokenRequest->clientId,
            empty( $tokenRequest->timestamp )  ? '' : $tokenRequest->timestamp,
            empty( $tokenRequest->nonce )      ? '' : $tokenRequest->nonce,
        ] ) . "\n";


        if ( empty( $tokenRequest->mac ) ) {
            $tokenRequest->mac = base64_encode( hash_hmac( 'sha256', $signText, $keySecret, true ) );
        }

        return $tokenRequest;
    }
}
