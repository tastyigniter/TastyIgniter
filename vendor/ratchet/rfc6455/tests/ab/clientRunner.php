<?php

use GuzzleHttp\Psr7\Message;
use GuzzleHttp\Psr7\Uri;
use Ratchet\RFC6455\Handshake\InvalidPermessageDeflateOptionsException;
use Ratchet\RFC6455\Handshake\PermessageDeflateOptions;
use Ratchet\RFC6455\Messaging\FrameInterface;
use Ratchet\RFC6455\Messaging\MessageBuffer;
use Ratchet\RFC6455\Handshake\ClientNegotiator;
use Ratchet\RFC6455\Messaging\CloseFrameChecker;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\Promise\Deferred;
use Ratchet\RFC6455\Messaging\Frame;
use React\Promise\PromiseInterface;
use GuzzleHttp\Psr7\HttpFactory;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;

require __DIR__ . '/../bootstrap.php';

define('AGENT', 'RatchetRFC/0.4');

$testServer = $argc > 1 ? $argv[1] : "127.0.0.1";

$loop = React\EventLoop\Factory::create();

$connector = new Connector($loop);

function echoStreamerFactory(ConnectionInterface $conn, ?PermessageDeflateOptions $permessageDeflateOptions = null): MessageBuffer
{
    $permessageDeflateOptions = $permessageDeflateOptions ?: PermessageDeflateOptions::createDisabled();

    return new MessageBuffer(
        new CloseFrameChecker,
        static function (MessageInterface $msg, MessageBuffer $messageBuffer) use ($conn): void {
            $messageBuffer->sendMessage($msg->getPayload(), true, $msg->isBinary());
        },
        static function (FrameInterface $frame, MessageBuffer $messageBuffer) use ($conn) {
            switch ($frame->getOpcode()) {
                case Frame::OP_PING:
                    return $conn->write((new Frame($frame->getPayload(), true, Frame::OP_PONG))->maskPayload()->getContents());
                case Frame::OP_CLOSE:
                    return $conn->end((new Frame($frame->getPayload(), true, Frame::OP_CLOSE))->maskPayload()->getContents());
            }
        },
        false,
        null,
        null,
        null,
        [$conn, 'write'],
        $permessageDeflateOptions
    );
}

function getTestCases(): PromiseInterface {
    global $testServer;
    global $connector;

    $deferred = new Deferred();

    $connector->connect($testServer . ':9002')->then(static function (ConnectionInterface $connection) use ($deferred, $testServer): void {
        $cn = new ClientNegotiator(new HttpFactory());
        $cnRequest = $cn->generateRequest(new Uri('ws://' . $testServer . ':9002/getCaseCount'));

        $rawResponse = "";
        $response = null;

        /** @var MessageBuffer $ms */
        $ms = null;

        $connection->on('data', static function ($data) use ($connection, &$rawResponse, &$response, &$ms, $cn, $deferred, &$context, $cnRequest): void {
            if ($response === null) {
                $rawResponse .= $data;
                $pos = strpos($rawResponse, "\r\n\r\n");
                if ($pos) {
                    $data = substr($rawResponse, $pos + 4);
                    $rawResponse = substr($rawResponse, 0, $pos + 4);
                    $response = Message::parseResponse($rawResponse);

                    if (!$cn->validateResponse($cnRequest, $response)) {
                        $connection->end();
                        $deferred->reject();
                    } else {
                        $ms = new MessageBuffer(
                            new CloseFrameChecker,
                            static function (MessageInterface $msg) use ($deferred, $connection): void {
                                $deferred->resolve($msg->getPayload());
                                $connection->close();
                            },
                            null,
                            false,
                            null,
                            null,
                            null,
                            static function (): void {}
                        );
                    }
                }
            }

            // feed the message streamer
            if ($ms) {
                $ms->onData($data);
            }
        });

        $connection->write(Message::toString($cnRequest));
    });

    return $deferred->promise();
}

$cn = new ClientNegotiator(
    new HttpFactory(),
    PermessageDeflateOptions::permessageDeflateSupported() ? PermessageDeflateOptions::createEnabled() : null);

function runTest(int $case)
{
    global $connector;
    global $testServer;
    global $cn;

    $casePath = "/runCase?case={$case}&agent=" . AGENT;

    $deferred = new Deferred();

    $connector->connect($testServer . ':9002')->then(static function (ConnectionInterface $connection) use ($deferred, $casePath, $case, $testServer): void {
        $cn = new ClientNegotiator(
            new HttpFactory(),
            PermessageDeflateOptions::permessageDeflateSupported() ? PermessageDeflateOptions::createEnabled() : null);
        $cnRequest = $cn->generateRequest(new Uri('ws://' . $testServer . ':9002' . $casePath));

        $rawResponse = "";
        $response = null;

        $ms = null;

        $connection->on('data', static function ($data) use ($connection, &$rawResponse, &$response, &$ms, $cn, $deferred, &$context, $cnRequest): void {
            if ($response === null) {
                $rawResponse .= $data;
                $pos = strpos($rawResponse, "\r\n\r\n");
                if ($pos) {
                    $data = substr($rawResponse, $pos + 4);
                    $rawResponse = substr($rawResponse, 0, $pos + 4);
                    $response = Message::parseResponse($rawResponse);

                    if (!$cn->validateResponse($cnRequest, $response)) {
                        echo "Invalid response.\n";
                        $connection->end();
                        $deferred->reject();
                    } else {
                        try {
                            $permessageDeflateOptions = PermessageDeflateOptions::fromRequestOrResponse($response)[0];
                            $ms = echoStreamerFactory(
                                $connection,
                                $permessageDeflateOptions
                            );
                        } catch (InvalidPermessageDeflateOptionsException $e) {
                            $connection->end();
                        }
                    }
                }
            }

            // feed the message streamer
            if ($ms) {
                $ms->onData($data);
            }
        });

        $connection->on('close', static function () use ($deferred): void {
            $deferred->resolve(null);
        });

        $connection->write(Message::toString($cnRequest));
    });

    return $deferred->promise();
}

function createReport(): PromiseInterface {
    global $connector;
    global $testServer;

    $deferred = new Deferred();

    $connector->connect($testServer . ':9002')->then(static function (ConnectionInterface $connection) use ($deferred, $testServer): void {
        // $reportPath = "/updateReports?agent=" . AGENT . "&shutdownOnComplete=true";
        // we will stop it using docker now instead of just shutting down
        $reportPath = "/updateReports?agent=" . AGENT;
        $cn = new ClientNegotiator(new HttpFactory());
        $cnRequest = $cn->generateRequest(new Uri('ws://' . $testServer . ':9002' . $reportPath));

        $rawResponse = "";
        $response = null;

        /** @var MessageBuffer $ms */
        $ms = null;

        $connection->on('data', static function ($data) use ($connection, &$rawResponse, &$response, &$ms, $cn, $deferred, &$context, $cnRequest): void {
            if ($response === null) {
                $rawResponse .= $data;
                $pos = strpos($rawResponse, "\r\n\r\n");
                if ($pos) {
                    $data = substr($rawResponse, $pos + 4);
                    $rawResponse = substr($rawResponse, 0, $pos + 4);
                    $response = Message::parseResponse($rawResponse);

                    if (!$cn->validateResponse($cnRequest, $response)) {
                        $connection->end();
                        $deferred->reject();
                    } else {
                        $ms = new MessageBuffer(
                            new CloseFrameChecker,
                            static function (MessageInterface $msg) use ($deferred, $connection): void {
                                $deferred->resolve($msg->getPayload());
                                $connection->close();
                            },
                            null,
                            false,
                            null,
                            null,
                            null,
                            static function (): void {}
                        );
                    }
                }
            }

            // feed the message streamer
            if ($ms) {
                $ms->onData($data);
            }
        });

        $connection->write(Message::toString($cnRequest));
    });

    return $deferred->promise();
}


$testPromises = [];

getTestCases()->then(function ($count) use ($loop) {
    $allDeferred = new Deferred();

    $runNextCase = static function () use (&$i, &$runNextCase, $count, $allDeferred): void {
        $i++;
        if ($i > $count) {
            $allDeferred->resolve(null);
            return;
        }
        echo "Running test $i/$count...";
        $startTime = microtime(true);
        runTest($i)
            ->then(static function () use ($startTime): void {
                echo " completed " . round((microtime(true) - $startTime) * 1000) . " ms\n";
            })
            ->then($runNextCase);
    };

    $i = 0;
    $runNextCase();

    $allDeferred->promise()->then(static function (): void {
        createReport();
    });
});

$loop->run();
