<?php

namespace Clue\React\Redis;

use Clue\Redis\Protocol\Factory as ProtocolFactory;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\Promise\Deferred;
use React\Promise\Timer\TimeoutException;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use React\Socket\ConnectorInterface;

class Factory
{
    /** @var LoopInterface */
    private $loop;

    /** @var ConnectorInterface */
    private $connector;

    /** @var ProtocolFactory */
    private $protocol;

    /**
     * @param ?LoopInterface $loop
     * @param ?ConnectorInterface $connector
     * @param ?ProtocolFactory $protocol (internal, should not usually be passed)
     */
    public function __construct($loop = null, $connector = null, $protocol = null)
    {
        if ($loop !== null && !$loop instanceof LoopInterface) { // manual type check to support legacy PHP < 7.1
            throw new \InvalidArgumentException('Argument #1 ($loop) expected null|React\EventLoop\LoopInterface');
        }
        if ($connector !== null && !$connector instanceof ConnectorInterface) { // manual type check to support legacy PHP < 7.1
            throw new \InvalidArgumentException('Argument #2 ($connector) expected null|React\Socket\ConnectorInterface');
        }
        if ($protocol !== null && !$protocol instanceof ProtocolFactory) { // manual type check to support legacy PHP < 7.1
            throw new \InvalidArgumentException('Argument #3 ($protocol) expected null|Clue\Redis\Protocol\Factory');
        }

        $this->loop = $loop ?: Loop::get();
        $this->connector = $connector ?: new Connector(array(), $this->loop);
        $this->protocol = $protocol ?: new ProtocolFactory();
    }

    /**
     * Create Redis client connected to address of given redis instance
     *
     * @param string $uri Redis server URI to connect to
     * @return \React\Promise\PromiseInterface<Client,\Exception> Promise that will
     *     be fulfilled with `Client` on success or rejects with `\Exception` on error.
     */
    public function createClient($uri)
    {
        // support `redis+unix://` scheme for Unix domain socket (UDS) paths
        if (preg_match('/^(redis\+unix:\/\/(?:[^:]*:[^@]*@)?)(.+?)?$/', $uri, $match)) {
            $parts = parse_url($match[1] . 'localhost/' . $match[2]);
        } else {
            if (strpos($uri, '://') === false) {
                $uri = 'redis://' . $uri;
            }

            $parts = parse_url($uri);
        }

        $uri = preg_replace(array('/(:)[^:\/]*(@)/', '/([?&]password=).*?($|&)/'), '$1***$2', $uri);
        if ($parts === false || !isset($parts['scheme'], $parts['host']) || !in_array($parts['scheme'], array('redis', 'rediss', 'redis+unix'))) {
            return \React\Promise\reject(new \InvalidArgumentException(
                'Invalid Redis URI given (EINVAL)',
                defined('SOCKET_EINVAL') ? SOCKET_EINVAL : 22
            ));
        }

        $args = array();
        parse_str(isset($parts['query']) ? $parts['query'] : '', $args);

        $authority = $parts['host'] . ':' . (isset($parts['port']) ? $parts['port'] : 6379);
        if ($parts['scheme'] === 'rediss') {
            $authority = 'tls://' . $authority;
        } elseif ($parts['scheme'] === 'redis+unix') {
            $authority = 'unix://' . substr($parts['path'], 1);
            unset($parts['path']);
        }
        $connecting = $this->connector->connect($authority);

        $deferred = new Deferred(function ($_, $reject) use ($connecting, $uri) {
            // connection cancelled, start with rejecting attempt, then clean up
            $reject(new \RuntimeException(
                'Connection to ' . $uri . ' cancelled (ECONNABORTED)',
                defined('SOCKET_ECONNABORTED') ? SOCKET_ECONNABORTED : 103
            ));

            // either close successful connection or cancel pending connection attempt
            $connecting->then(function (ConnectionInterface $connection) {
                $connection->close();
            }, function () {
                // ignore to avoid reporting unhandled rejection
            });
            $connecting->cancel();
        });

        $protocol = $this->protocol;
        $promise = $connecting->then(function (ConnectionInterface $stream) use ($protocol) {
            return new StreamingClient($stream, $protocol->createResponseParser(), $protocol->createSerializer());
        }, function (\Exception $e) use ($uri) {
            throw new \RuntimeException(
                'Connection to ' . $uri . ' failed: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        });

        // use `?password=secret` query or `user:secret@host` password form URL
        $pass = isset($args['password']) ? $args['password'] : (isset($parts['pass']) ? rawurldecode($parts['pass']) : null);
        if (isset($args['password']) || isset($parts['pass'])) {
            $pass = isset($args['password']) ? $args['password'] : rawurldecode($parts['pass']);
            $promise = $promise->then(function (StreamingClient $redis) use ($pass, $uri) {
                return $redis->auth($pass)->then(
                    function () use ($redis) {
                        return $redis;
                    },
                    function (\Exception $e) use ($redis, $uri) {
                        $redis->close();

                        $const = '';
                        $errno = $e->getCode();
                        if ($errno === 0) {
                            $const = ' (EACCES)';
                            $errno = $e->getCode() ?: (defined('SOCKET_EACCES') ? SOCKET_EACCES : 13);
                        }

                        throw new \RuntimeException(
                            'Connection to ' . $uri . ' failed during AUTH command: ' . $e->getMessage() . $const,
                            $errno,
                            $e
                        );
                    }
                );
            });
        }

        // use `?db=1` query or `/1` path (skip first slash)
        if (isset($args['db']) || (isset($parts['path']) && $parts['path'] !== '/')) {
            $db = isset($args['db']) ? $args['db'] : substr($parts['path'], 1);
            $promise = $promise->then(function (StreamingClient $redis) use ($db, $uri) {
                return $redis->select($db)->then(
                    function () use ($redis) {
                        return $redis;
                    },
                    function (\Exception $e) use ($redis, $uri) {
                        $redis->close();

                        $const = '';
                        $errno = $e->getCode();
                        if ($errno === 0 && strpos($e->getMessage(), 'NOAUTH ') === 0) {
                            $const = ' (EACCES)';
                            $errno = defined('SOCKET_EACCES') ? SOCKET_EACCES : 13;
                        } elseif ($errno === 0) {
                            $const = ' (ENOENT)';
                            $errno = defined('SOCKET_ENOENT') ? SOCKET_ENOENT : 2;
                        }

                        throw new \RuntimeException(
                            'Connection to ' . $uri . ' failed during SELECT command: ' . $e->getMessage() . $const,
                            $errno,
                            $e
                        );
                    }
                );
            });
        }

        $promise->then(array($deferred, 'resolve'), array($deferred, 'reject'));

        // use timeout from explicit ?timeout=x parameter or default to PHP's default_socket_timeout (60)
        $timeout = isset($args['timeout']) ? (float) $args['timeout'] : (int) ini_get("default_socket_timeout");
        if ($timeout < 0) {
            return $deferred->promise();
        }

        return \React\Promise\Timer\timeout($deferred->promise(), $timeout, $this->loop)->then(null, function ($e) use ($uri) {
            if ($e instanceof TimeoutException) {
                throw new \RuntimeException(
                    'Connection to ' . $uri . ' timed out after ' . $e->getTimeout() . ' seconds (ETIMEDOUT)',
                    defined('SOCKET_ETIMEDOUT') ? SOCKET_ETIMEDOUT : 110
                );
            }
            throw $e;
        });
    }

    /**
     * Create Redis client connected to address of given redis instance
     *
     * @param string $target
     * @return Client
     */
    public function createLazyClient($target)
    {
        return new LazyClient($target, $this, $this->loop);
    }
}
