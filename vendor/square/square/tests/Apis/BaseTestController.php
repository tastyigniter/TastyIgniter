<?php

declare(strict_types=1);

namespace Square\Tests\Apis;

use Core\TestCase\CoreTestCase;
use Core\Types\CallbackCatcher;
use PHPUnit\Framework\TestCase;
use Square\SquareClient;
use Square\Tests\ClientFactory;

class BaseTestController extends TestCase
{
    /**
     * @var CallbackCatcher Callback
     */
    protected static $callbackCatcher;

    protected function newTestCase($result): CoreTestCase
    {
        return new CoreTestCase($this, self::$callbackCatcher, $result);
    }

    protected static function getClient(): SquareClient
    {
        self::$callbackCatcher = new CallbackCatcher();
        return ClientFactory::create(self::$callbackCatcher);
    }
}
