<?php

namespace System\Traits;

use Mail;

trait SendsMailTemplate
{
    public function mailGetRecipients($type)
    {
        return [];
    }

    public function mailGetData()
    {
        return [];
    }

    public function mailSend($view, $recipientType)
    {
        if (!$recipient = $this->mailGetRecipients($recipientType))
            return FALSE;

        Mail::send(
            $view,
            $this->mailGetData(),
            $this->mailBuildMessage($recipient)
        );
    }

    protected function mailBuildMessage($recipients)
    {
        return function ($message) use ($recipients) {
            foreach ($recipients as $recipient) {
                list($email, $name) = $recipient;
                $message->to($email, $name);
            }
        };
    }
}