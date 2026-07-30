<?php
namespace Ratchet\RFC6455\Handshake;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * The latest version of the WebSocket protocol
 * @todo Unicode: return mb_convert_encoding(pack("N",$u), mb_internal_encoding(), 'UCS-4BE');
 */
class ServerNegotiator implements NegotiatorInterface {
    private RequestVerifier $verifier;

    private ResponseFactoryInterface $responseFactory;

    private array $_supportedSubProtocols = [];

    private bool $_strictSubProtocols = false;

    private bool $enablePerMessageDeflate = false;

    public function __construct(
        RequestVerifier $requestVerifier,
        ResponseFactoryInterface $responseFactory,
        $enablePerMessageDeflate = false
    ) {
        $this->verifier = $requestVerifier;
        $this->responseFactory = $responseFactory;

        // https://bugs.php.net/bug.php?id=73373
        // https://bugs.php.net/bug.php?id=74240 - need >=7.1.4 or >=7.0.18
        $supported = PermessageDeflateOptions::permessageDeflateSupported();
        if ($enablePerMessageDeflate && !$supported) {
            throw new \Exception('permessage-deflate is not supported by your PHP version (need >=7.1.4 or >=7.0.18).');
        }
        if ($enablePerMessageDeflate && !function_exists('deflate_add')) {
            throw new \Exception('permessage-deflate is not supported because you do not have the zlib extension.');
        }

        $this->enablePerMessageDeflate = $enablePerMessageDeflate;
    }

    /**
     * {@inheritdoc}
     */
    public function isProtocol(RequestInterface $request): bool {
        return $this->verifier->verifyVersion($request->getHeader('Sec-WebSocket-Version'));
    }

    /**
     * {@inheritdoc}
     */
    public function getVersionNumber(): int {
        return RequestVerifier::VERSION;
    }

    /**
     * {@inheritdoc}
     */
    public function handshake(RequestInterface $request): ResponseInterface {
        $response = $this->responseFactory->createResponse();
        if (true !== $this->verifier->verifyMethod($request->getMethod())) {
            return $response->withHeader('Allow', 'GET')->withStatus(405);
        }

        if (true !== $this->verifier->verifyHTTPVersion($request->getProtocolVersion())) {
            return $response->withStatus(505);
        }

        if (true !== $this->verifier->verifyRequestURI($request->getUri()->getPath())) {
            return $response->withStatus(400);
        }

        if (true !== $this->verifier->verifyHost($request->getHeader('Host'))) {
            return $response->withStatus(400);
        }

        $upgradeResponse = $response
            ->withHeader('Connection'           , 'Upgrade')
            ->withHeader('Upgrade'              , 'websocket')
            ->withHeader('Sec-WebSocket-Version', $this->getVersionNumber());

        if (count($this->_supportedSubProtocols) > 0) {
            $upgradeResponse = $upgradeResponse->withHeader(
                'Sec-WebSocket-Protocol', implode(', ', array_keys($this->_supportedSubProtocols))
            );
        }
        if (true !== $this->verifier->verifyUpgradeRequest($request->getHeader('Upgrade'))) {
            return $upgradeResponse->withStatus(426, 'Upgrade header MUST be provided');
        }

        if (true !== $this->verifier->verifyConnection($request->getHeader('Connection'))) {
            return $response->withStatus(400, 'Connection Upgrade MUST be requested');
        }

        if (true !== $this->verifier->verifyKey($request->getHeader('Sec-WebSocket-Key'))) {
            return $response->withStatus(400, 'Invalid Sec-WebSocket-Key');
        }

        if (true !== $this->verifier->verifyVersion($request->getHeader('Sec-WebSocket-Version'))) {
            return $upgradeResponse->withStatus(426);
        }

        $subProtocols = $request->getHeader('Sec-WebSocket-Protocol');
        if (count($subProtocols) > 0 || (count($this->_supportedSubProtocols) > 0 && $this->_strictSubProtocols)) {
            $subProtocols = array_map('trim', explode(',', implode(',', $subProtocols)));

            $match = array_reduce($subProtocols, fn ($accumulator, $protocol) => $accumulator ?: (isset($this->_supportedSubProtocols[$protocol]) ? $protocol : null), null);

            if ($this->_strictSubProtocols && null === $match) {
                return $upgradeResponse->withStatus(426, 'No Sec-WebSocket-Protocols requested supported');
            }

            if (null !== $match) {
                $response = $response->withHeader('Sec-WebSocket-Protocol', $match);
            }
        }

        $response = $response
            ->withStatus(101)
            ->withHeader('Upgrade'             , 'websocket')
            ->withHeader('Connection'          , 'Upgrade')
            ->withHeader('Sec-WebSocket-Accept', $this->sign((string)$request->getHeader('Sec-WebSocket-Key')[0]))
            ->withHeader('X-Powered-By'        , 'Ratchet');

        try {
            $perMessageDeflateRequest = PermessageDeflateOptions::fromRequestOrResponse($request)[0];
        } catch (InvalidPermessageDeflateOptionsException $e) {
            return new Response(400, [], null, '1.1', $e->getMessage());
        }

        if ($this->enablePerMessageDeflate && $perMessageDeflateRequest->isEnabled()) {
            $response = $perMessageDeflateRequest->addHeaderToResponse($response);
        }

        return $response;
    }

    /**
     * Used when doing the handshake to encode the key, verifying client/server are speaking the same language
     * @param  string $key
     * @return string
     * @internal
     */
    public function sign(string $key): string {
        return base64_encode(sha1($key . static::GUID, true));
    }

    /**
     * @param array $protocols
     */
    public function setSupportedSubProtocols(array $protocols): void {
        $this->_supportedSubProtocols = array_flip($protocols);
    }

    /**
     * If enabled and support for a subprotocol has been added handshake
     *  will not upgrade if a match between request and supported subprotocols
     * @param boolean $enable
     * @todo Consider extending this interface and moving this there.
     *       The spec does say the server can fail for this reason, but
     *       it is not a requirement. This is an implementation detail.
     */
    public function setStrictSubProtocolCheck(bool $enable): void {
        $this->_strictSubProtocols = $enable;
    }
}
