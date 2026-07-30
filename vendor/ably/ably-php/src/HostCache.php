<?php

namespace Ably;

// TODO - Add SyncMutex support to the class to avoid data corruption due to concurrent READ/WRITE (e.g. Apache multithreading environment)
use Ably\Utils\Miscellaneous;

class HostCache
{
    private $timeoutDuration;
    private $expireTime;
    private $host = "";

    public function __construct($timeoutDurationInMs)
    {
        $this->timeoutDuration = $timeoutDurationInMs;
    }

    public function put($host)
    {
        $this->host = $host;
        $this->expireTime = Miscellaneous::systemTime() + $this->timeoutDuration;
    }

    public function get()
    {
        if (empty($this->host) || Miscellaneous::systemTime() > $this->expireTime) {
            return "";
        }
        return $this->host;
    }
}
