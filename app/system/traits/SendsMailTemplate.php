<?php

namespace System\Traits;

use Illuminate\Support\Facades\Mail;

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
        $vars = $this->mailGetData();

        $result = $this->fireEvent('model.mailGetData', [$view, $recipientType]);
        if ($result AND is_array($result))
            $vars = array_merge(...$result) + $vars;

        Mail::queue($view, $vars, $this->mailBuildMessage($recipientType));
    }

    protected function mailBuildMessage($recipientType = null)
    {
        if (is_callable($recipientType))
            return $recipientType;

        $recipients = $this->mailGetRecipients($recipientType);

        return function ($message) use ($recipients) {
            foreach ($recipients as $recipient) {
                [$email, $name] = $recipient;
                $message->to($email, $name);
            }
        };
    }
}
