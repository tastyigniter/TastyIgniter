<?php

namespace Ratchet\RFC6455\Handshake;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class PermessageDeflateOptions
{
    public const MAX_WINDOW_BITS = 15;

    private const VALID_BITS = [8, 9, 10, 11, 12, 13, 14, 15];

    private bool $deflateEnabled = false;

    private ?bool $server_no_context_takeover = null;
    private ?bool $client_no_context_takeover = null;
    private ?int $server_max_window_bits = null;
    private ?int $client_max_window_bits = null;

    private function __construct() { }

    public static function createEnabled() {
        $new                             = new self();
        $new->deflateEnabled             = true;
        $new->client_max_window_bits     = self::MAX_WINDOW_BITS;
        $new->client_no_context_takeover = false;
        $new->server_max_window_bits     = self::MAX_WINDOW_BITS;
        $new->server_no_context_takeover = false;

        return $new;
    }

    public static function createDisabled() {
        return new self();
    }

    public function withClientNoContextTakeover(): self {
        $new = clone $this;
        $new->client_no_context_takeover = true;
        return $new;
    }

    public function withoutClientNoContextTakeover(): self {
        $new = clone $this;
        $new->client_no_context_takeover = false;
        return $new;
    }

    public function withServerNoContextTakeover(): self {
        $new = clone $this;
        $new->server_no_context_takeover = true;
        return $new;
    }

    public function withoutServerNoContextTakeover(): self {
        $new = clone $this;
        $new->server_no_context_takeover = false;
        return $new;
    }

    public function withServerMaxWindowBits(int $bits = self::MAX_WINDOW_BITS): self {
        if (!in_array($bits, self::VALID_BITS)) {
            throw new \Exception('server_max_window_bits must have a value between 8 and 15.');
        }
        $new = clone $this;
        $new->server_max_window_bits = $bits;
        return $new;
    }

    public function withClientMaxWindowBits(int $bits = self::MAX_WINDOW_BITS): self {
        if (!in_array($bits, self::VALID_BITS)) {
            throw new \Exception('client_max_window_bits must have a value between 8 and 15.');
        }
        $new = clone $this;
        $new->client_max_window_bits = $bits;
        return $new;
    }

    /**
     * https://tools.ietf.org/html/rfc6455#section-9.1
     * https://tools.ietf.org/html/rfc7692#section-7
     *
     * @param MessageInterface $requestOrResponse
     * @return PermessageDeflateOptions[]
     * @throws \Exception
     */
    public static function fromRequestOrResponse(MessageInterface $requestOrResponse): array {
        $optionSets = [];

        $extHeader = preg_replace('/\s+/', '', join(', ', $requestOrResponse->getHeader('Sec-Websocket-Extensions')));

        $configurationRequests = explode(',', $extHeader);
        foreach ($configurationRequests as $configurationRequest) {
            $parts = explode(';', $configurationRequest);
            if (count($parts) == 0) {
                continue;
            }

            if ($parts[0] !== 'permessage-deflate') {
                continue;
            }

            array_shift($parts);
            $options                 = new self();
            $options->deflateEnabled = true;
            foreach ($parts as $part) {
                $kv = explode('=', $part);
                $key = $kv[0];
                $value = count($kv) > 1 ? $kv[1] : null;

                switch ($key) {
                    case "server_no_context_takeover":
                    case "client_no_context_takeover":
                        if ($value !== null) {
                            throw new InvalidPermessageDeflateOptionsException($key . ' must not have a value.');
                        }
                        $value = true;
                        break;
                    case "server_max_window_bits":
                        $value = (int) $value;
                        if (!in_array($value, self::VALID_BITS)) {
                            throw new InvalidPermessageDeflateOptionsException($key . ' must have a value between 8 and 15.');
                        }
                        break;
                    case "client_max_window_bits":
                        if ($value === null) {
                            $value = 15;
                        } else {
                            $value = (int) $value;
                        }
                        if (!in_array($value, self::VALID_BITS)) {
                            throw new InvalidPermessageDeflateOptionsException($key . ' must have no value or a value between 8 and 15.');
                        }
                        break;
                    default:
                        throw new InvalidPermessageDeflateOptionsException('Option "' . $key . '"is not valid for permessage deflate');
                }

                if ($options->$key !== null) {
                    throw new InvalidPermessageDeflateOptionsException($key . ' specified more than once. Connection must be declined.');
                }

                $options->$key = $value;
            }

            if ($options->getClientMaxWindowBits() === null) {
                $options->client_max_window_bits = 15;
            }

            if ($options->getServerMaxWindowBits() === null) {
                $options->server_max_window_bits = 15;
            }

            $optionSets[] = $options;
        }

        // always put a disabled on the end
        $optionSets[] = new self();

        return $optionSets;
    }

    /**
     * @return bool|null
     */
    public function getServerNoContextTakeover(): ?bool
    {
        return $this->server_no_context_takeover;
    }

    /**
     * @return bool|null
     */
    public function getClientNoContextTakeover(): ?bool
    {
        return $this->client_no_context_takeover;
    }

    /**
     * @return int|null
     */
    public function getServerMaxWindowBits(): ?int
    {
        return $this->server_max_window_bits;
    }

    /**
     * @return int|null
     */
    public function getClientMaxWindowBits(): ?int
    {
        return $this->client_max_window_bits;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->deflateEnabled;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function addHeaderToResponse(ResponseInterface $response): ResponseInterface
    {
        if (!$this->deflateEnabled) {
            return $response;
        }

        $header = 'permessage-deflate';
        if ($this->client_max_window_bits != 15) {
            $header .= '; client_max_window_bits='. $this->client_max_window_bits;
        }
        if ($this->client_no_context_takeover) {
            $header .= '; client_no_context_takeover';
        }
        if ($this->server_max_window_bits != 15) {
            $header .= '; server_max_window_bits=' . $this->server_max_window_bits;
        }
        if ($this->server_no_context_takeover) {
            $header .= '; server_no_context_takeover';
        }

        return $response->withAddedHeader('Sec-Websocket-Extensions', $header);
    }

    public function addHeaderToRequest(RequestInterface $request): RequestInterface {
        if (!$this->deflateEnabled) {
            return $request;
        }

        $header = 'permessage-deflate';
        if ($this->server_no_context_takeover) {
            $header .= '; server_no_context_takeover';
        }
        if ($this->client_no_context_takeover) {
            $header .= '; client_no_context_takeover';
        }
        if ($this->server_max_window_bits != 15) {
            $header .= '; server_max_window_bits=' . $this->server_max_window_bits;
        }
        $header .= '; client_max_window_bits';
        if ($this->client_max_window_bits != 15) {
            $header .= '='. $this->client_max_window_bits;
        }

        return $request->withAddedHeader('Sec-Websocket-Extensions', $header);
    }

    public static function permessageDeflateSupported(string $version = PHP_VERSION): bool {
        if (!function_exists('deflate_init')) {
            return false;
        }
        if (version_compare($version, '7.1.3', '>')) {
            return true;
        }
        if (version_compare($version, '7.0.18', '>=')
            && version_compare($version, '7.1.0', '<')) {
            return true;
        }

        return false;
    }
}
