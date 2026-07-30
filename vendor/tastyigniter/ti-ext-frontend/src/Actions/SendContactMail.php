<?php

declare(strict_types=1);

namespace Igniter\Frontend\Actions;

use Facades\Igniter\System\Helpers\MailHelper;

class SendContactMail
{
    public function __invoke(array $data): void
    {
        MailHelper::queueTemplate('igniter.frontend::mail.contact', $data, [
            setting('site_email'), setting('site_name'),
        ]);
    }
}
