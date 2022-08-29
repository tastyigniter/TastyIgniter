<?php

namespace System\Traits;

use Illuminate\Support\Facades\Mail;

trait SendsMailTemplate
{
    public function mailGetReplyTo()
    {
        return [];
    }

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
        $vars = $this->mailGetData();

        $result = $this->fireEvent('model.mailGetData', [$view, $recipientType]);
        if ($result && is_array($result))
            $vars = array_merge(...$result) + $vars;

        Mail::queue($view, $vars, $this->mailBuildMessage($recipientType));
    }

    protected function mailBuildMessage($recipientType = null)
    {
        if (is_callable($recipientType))
            return $recipientType;

        $replyTo = $this->mailGetReplyTo($recipientType);
        $recipients = $this->mailGetRecipients($recipientType);

        return function ($message) use ($recipients, $replyTo) {
            foreach ($recipients as $recipient) {
                $message->to(...$recipient);
                if ($replyTo) $message->replyTo(...$replyTo);
            }
        };
    }
}
