<?php

declare(strict_types=1);

namespace Igniter\System\Health\Concerns;

use Igniter\System\Health\Result;
use Illuminate\Support\Facades\Http;

trait InteractsWithHttpProbes
{
    protected function baseUrl(): ?string
    {
        $baseUrl = (string) config('app.url');

        return blank($baseUrl) ? null : rtrim($baseUrl, '/');
    }

    protected function httpClient()
    {
        $client = Http::timeout(10);

        if (app()->environment('local', 'testing')) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function secured(string $summary): array
    {
        return ['status' => 'secured', 'summary' => $summary];
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function vulnerable(string $summary): array
    {
        return ['status' => 'vulnerable', 'summary' => $summary];
    }

    /**
     * @return array{status: 'secured'|'vulnerable'|'unverified', summary: string}
     */
    protected function unverified(string $summary): array
    {
        return ['status' => 'unverified', 'summary' => $summary];
    }

    protected function probeResultStatus(string $probeStatus): ?string
    {
        return match ($probeStatus) {
            'vulnerable' => Result::STATUS_FAILED,
            'unverified' => Result::STATUS_WARNING,
            default => null,
        };
    }

    protected function responseBlocksAccess(int $status): bool
    {
        return in_array($status, [403, 404, 410], true);
    }

    protected function bodyContainsAny(string $body, array $needles): bool
    {
        foreach ($needles as $needle) {
            if (str_contains($body, (string) $needle)) {
                return true;
            }
        }

        return false;
    }
}
