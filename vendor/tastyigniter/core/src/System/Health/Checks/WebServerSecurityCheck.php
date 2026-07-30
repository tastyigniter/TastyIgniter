<?php

declare(strict_types=1);

namespace Igniter\System\Health\Checks;

use Igniter\System\Health\Check;
use Igniter\System\Health\Result;
use Igniter\System\Health\WebServerSecurityProbes;
use Override;

class WebServerSecurityCheck extends Check
{
    public const string DOCS_WEB_SERVER_CONFIG_URL = 'https://tastyigniter.com/docs/installation#apachenginx-configuration';

    /** @var array<string, string> */
    protected array $probeLabels = [
        'media_php' => 'igniter::system.system.checks.web_server_security_probe',
        'storage_php' => 'igniter::system.system.checks.web_server_security_storage_php',
        'env_exposure' => 'igniter::system.system.checks.web_server_security_env',
        'sensitive_files' => 'igniter::system.system.checks.web_server_security_sensitive_files',
        'directory_listing' => 'igniter::system.system.checks.web_server_security_directory_listing',
        'https' => 'igniter::system.system.checks.web_server_security_https',
    ];

    public function label(): string
    {
        return lang('igniter::system.system.checks.web_server_security');
    }

    #[Override]
    public function icon(): string
    {
        return 'fa fa-shield-halved';
    }

    #[Override]
    public function sortOrder(): int
    {
        return 50;
    }

    public function run(): Result
    {
        $context = $this->context();
        $meta = $this->meta($context);
        $issues = $this->issues($context);

        return $this->resultFromIssues(
            $issues,
            $meta,
            lang('igniter::system.system.checks.web_server_security_ok'),
        );
    }

    /**
     * @return array<string, array{status: 'secured'|'vulnerable'|'unverified', summary: string}>
     */
    protected function context(): array
    {
        return resolve(WebServerSecurityProbes::class)->run();
    }

    /**
     * @param  array<string, array{status: 'secured'|'vulnerable'|'unverified', summary: string}>  $context
     * @return array<string, array{value: string, status: string}|string>
     */
    protected function meta(array $context): array
    {
        $meta = [
            lang('igniter::system.system.checks.web_server') => $_SERVER['SERVER_SOFTWARE'] ?? lang('igniter::system.system.checks.unknown'),
        ];

        foreach ($context as $key => $probe) {
            $label = lang($this->probeLabels[$key] ?? $key);

            $meta[$label] = Result::metaValue(
                $probe['summary'],
                $this->probeResultStatus($probe['status']),
            );
        }

        return $meta;
    }

    /**
     * @param  array<string, array{status: 'secured'|'vulnerable'|'unverified', summary: string}>  $context
     * @return array<int, array{status: string, summary: string, action: string, actionUrl?: string, actionUrlLabel?: string}>
     */
    protected function issues(array $context): array
    {
        $issues = [];

        foreach ($context as $probe) {
            if ($probe['status'] === 'secured') {
                continue;
            }

            $issue = [
                'status' => $probe['status'] === 'vulnerable'
                    ? Result::STATUS_FAILED
                    : Result::STATUS_WARNING,
                'summary' => $probe['summary'],
                'action' => lang('igniter::system.system.checks.web_server_security_action'),
            ];

            if ($probe['status'] === 'vulnerable') {
                $issue['actionUrl'] = self::DOCS_WEB_SERVER_CONFIG_URL;
                $issue['actionUrlLabel'] = lang('igniter::system.system.checks.view_docs');
            }

            $issues[] = $issue;
        }

        return $issues;
    }

    protected function probeResultStatus(string $probeStatus): ?string
    {
        return match ($probeStatus) {
            'vulnerable' => Result::STATUS_FAILED,
            'unverified' => Result::STATUS_WARNING,
            default => null,
        };
    }
}
