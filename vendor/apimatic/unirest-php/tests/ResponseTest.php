<?php

namespace Unirest\Test;

use PHPUnit\Framework\TestCase;
use Unirest\Response as Response;

class ResponseTest extends TestCase
{
    public function testJSONAssociativeArrays()
    {
        $response = new Response(200, '{"a":1,"b":2,"c":3,"d":4,"e":5}', [], [true]);
        $this->assertEquals($response->getBody()['a'], 1);
    }

    public function testJSONAObjects()
    {
        $response = new Response(200, '{"a":1,"b":2,"c":3,"d":4,"e":5}', [], [false]);
        $this->assertEquals($response->getBody()->a, 1);
    }

    public function testJSONOpts()
    {
        $response = new Response(200, '{"number": 1234567890}', [], [false, 512, JSON_NUMERIC_CHECK]);
        $this->assertSame($response->getBody()->number, 1234567890);
    }
}
