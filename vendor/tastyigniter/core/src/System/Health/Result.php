<?php

declare(strict_types=1);

namespace Igniter\System\Health;

class Result
{
    public const string STATUS_OK = 'ok';

    public const string STATUS_WARNING = 'warning';

    public const string STATUS_FAILED = 'failed';

    public function __construct(
        public string $status = self::STATUS_OK,
        public string $shortSummary = '',
        public array $meta = [],
        public string $actionMessage = '',
        public ?string $actionUrl = null,
        public ?string $actionUrlLabel = null,
        public array $issues = [],
    ) {}

    public static function ok(string $shortSummary = ''): self
    {
        return new self(self::STATUS_OK, $shortSummary);
    }

    public static function warning(string $shortSummary = ''): self
    {
        return new self(self::STATUS_WARNING, $shortSummary);
    }

    public static function fail(string $shortSummary = ''): self
    {
        return new self(self::STATUS_FAILED, $shortSummary);
    }

    public function shortSummary(string $shortSummary): self
    {
        $this->shortSummary = $shortSummary;

        return $this;
    }

    public function meta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    public function actionMessage(string $actionMessage): self
    {
        $this->actionMessage = $actionMessage;

        return $this;
    }

    public function actionUrl(string $url, string $label): self
    {
        $this->actionUrl = $url;
        $this->actionUrlLabel = $label;

        return $this;
    }

    /**
     * @param  array<int, array{status: string, summary: string, action: string, actionUrl?: string, actionUrlLabel?: string}>  $issues
     */
    public function issues(array $issues): self
    {
        $this->issues = $issues;

        return $this;
    }

    /**
     * @return array<int, array{status: string, summary: string, actionMessage: string, actionUrl: ?string, actionUrlLabel: ?string}>
     */
    public function alerts(): array
    {
        if ($this->issues !== []) {
            return array_map(fn(array $issue): array => [
                'status' => $issue['status'],
                'summary' => $issue['summary'] ?? '',
                'actionMessage' => $issue['action'] ?? '',
                'actionUrl' => $issue['actionUrl'] ?? null,
                'actionUrlLabel' => $issue['actionUrlLabel'] ?? null,
            ], $this->issues);
        }

        if (!$this->isIssue()) {
            return [];
        }

        return [[
            'status' => $this->status,
            'summary' => $this->shortSummary,
            'actionMessage' => $this->actionMessage,
            'actionUrl' => $this->actionUrl,
            'actionUrlLabel' => $this->actionUrlLabel,
        ]];
    }

    public function isIssue(): bool
    {
        return in_array($this->status, [self::STATUS_WARNING, self::STATUS_FAILED], true);
    }

    /**
     * @return array{value: string, status: string}|string
     */
    public static function metaValue(string $value, ?string $status = null): array|string
    {
        if ($status === null || $status === self::STATUS_OK) {
            return $value;
        }

        return [
            'value' => $value,
            'status' => $status,
        ];
    }
}
