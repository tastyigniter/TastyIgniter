<?php

namespace Laravel\Reverb\Protocols\Pusher\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Reverb\Application;
use Laravel\Reverb\Contracts\ApplicationProvider;
use Laravel\Reverb\Exceptions\InvalidApplication;
use Laravel\Reverb\Protocols\Pusher\Contracts\ChannelManager;
use Laravel\Reverb\Servers\Reverb\Concerns\ClosesConnections;
use Laravel\Reverb\Servers\Reverb\Http\Connection;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class Controller
{
    use ClosesConnections;

    /**
     * Current application instance.
     */
    protected ?Application $application = null;

    /**
     * Active channels for the application.
     */
    protected ?ChannelManager $channels = null;

    /**
     * The incoming request's body.
     */
    protected ?string $body;

    /**
     * The incoming request's query parameters.
     */
    protected array $query = [];

    /**
     * Verify that the incoming request is valid.
     */
    public function verify(RequestInterface $request, Connection $connection, $appId): void
    {
        parse_str($request->getUri()->getQuery(), $query);

        $this->body = $request->getBody()->getContents();
        $this->query = $query;

        $this->setApplication($appId);
        $this->setChannels();
        $this->verifySignature($request);
    }

    /**
     * Set the Reverb application instance for the incoming request's application ID.
     *
     * @throws HttpException
     */
    protected function setApplication(?string $appId): Application
    {
        if (! $appId) {
            throw new HttpException(400, 'Application ID not provided.');
        }

        try {
            return $this->application = app(ApplicationProvider::class)->findById($appId);
        } catch (InvalidApplication $e) {
            throw new HttpException(404, 'No matching application for ID ['.$appId.'].');
        }
    }

    /**
     * Set the Reverb channel manager instance for the application.
     */
    protected function setChannels(): void
    {
        $this->channels = app(ChannelManager::class)->for($this->application);
    }

    /**
     * Verify the Pusher authentication signature.
     *
     * @throws HttpException
     */
    protected function verifySignature(RequestInterface $request): void
    {
        $params = Arr::except($this->query, [
            'auth_signature', 'body_md5', 'appId', 'appKey', 'channelName',
        ]);

        if ($this->body !== '') {
            $params['body_md5'] = md5($this->body);
        }

        ksort($params);

        $path = $request->getUri()->getPath();

        if ($prefix = config('reverb.servers.reverb.path')) {
            $path = '/'.ltrim(Str::after($path, rtrim($prefix, '/')), '/');
        }

        $signature = implode("\n", [
            $request->getMethod(),
            $path,
            $this->formatQueryParametersForVerification($params),
        ]);

        $signature = hash_hmac('sha256', $signature, $this->application->secret());
        $authSignature = $this->query['auth_signature'] ?? '';

        if (! is_string($authSignature) || ! hash_equals($signature, $authSignature)) {
            throw new HttpException(401, 'Authentication signature invalid.');
        }
    }

    /**
     * Format the given parameters into the correct format for signature verification.
     */
    protected static function formatQueryParametersForVerification(array $params): string
    {
        if (! is_array($params)) {
            return $params;
        }

        return collect($params)->map(function ($value, $key) {
            if (is_array($value)) {
                $value = implode(',', $value);
            }

            return "{$key}={$value}";
        })->implode('&');
    }
}
