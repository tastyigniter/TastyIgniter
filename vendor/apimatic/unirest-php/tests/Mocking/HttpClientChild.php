<?php

namespace Unirest\Test\Mocking;

use Unirest\HttpClient;

class HttpClientChild extends HttpClient
{
    public function getTotalNumberOfConnections()
    {
        return $this->totalNumberOfConnections;
    }

    public function resetHandle()
    {
        $this->initializeHandle();
    }
}
