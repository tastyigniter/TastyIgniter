<?php

declare(strict_types=1);

namespace Igniter\System\Models\Concerns;

use Facades\Igniter\System\Helpers\MailHelper;
use Symfony\Component\Mime\Address;

trait SendsMailTemplate
{
    public function mailGetReplyTo(?string $type = null): array
    {
        return [];
    }

    public function mailGetRecipients(string $type): array
    {
        return [];
    }

    public function mailGetData(): array
    {
        return [];
    }

    public function mailSend(string $view, ?string $recipientType = null, array $vars = []): void
    {
        $vars += $this->mailGetData();

        if ($recipients = $this->mailBuildMessageTo($recipientType)) {
            MailHelper::queueTemplate($view, $vars, $recipients);
        }
    }

    protected function mailBuildMessageTo(?string $recipientType = null): array
    {
        $recipients = [];
        foreach ($this->mailGetRecipients($recipientType) as $recipient) {
            if (array_filter($recipient)) {
                $recipients[] = new Address(...$recipient);
            }
        }

        return $recipients;
    }
}
