<?php

declare(strict_types=1);

namespace Igniter\System\Helpers;

use Igniter\System\Mail\AnonymousTemplateMailable;
use Illuminate\Support\Facades\Mail;

class MailHelper
{
    public function sendTemplate(string $view, array $vars, $callback = null)
    {
        return Mail::send(AnonymousTemplateMailable::create($view)->applyCallback($callback)->withSerializedData($vars));
    }

    public function queueTemplate(string $view, array $vars, $callback = null)
    {
        return Mail::queue(AnonymousTemplateMailable::create($view)->applyCallback($callback)->withSerializedData($vars));
    }
}
