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

    public function mailSend($view, $recipientType = null)
    {
        Mail::send(
            $view,
            $this->mailGetData(),
            is_callable($recipientType)
                ? $recipientType
                : $this->mailBuildMessage($recipientType)
        );
    }

    protected function mailBuildMessage($recipientType = null)
    {
        $recipients = $this->mailGetRecipients($recipientType);

        return function ($message) use ($recipients) {
            foreach ($recipients as $recipient) {
                list($email, $name) = $recipient;
                $message->to($email, $name);
            }
        };
    }
}