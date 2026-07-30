<?php

namespace Core\Tests;

use Core\Client;
use Core\Request\Request;
use Core\Response\Context;
use Core\TestCase\BodyMatchers\BodyComparator;
use Core\TestCase\BodyMatchers\KeysAndValuesBodyMatcher;
use Core\TestCase\BodyMatchers\KeysBodyMatcher;
use Core\TestCase\BodyMatchers\NativeBodyMatcher;
use Core\TestCase\BodyMatchers\RawBodyMatcher;
use Core\TestCase\CoreTestCase;
use Core\TestCase\TestParam;
use Core\Tests\Mocking\MockHelper;
use Core\Tests\Mocking\Other\MockClass;
use Core\Tests\Mocking\Response\MockResponse;
use Core\Utils\CoreHelper;
use Core\Utils\DateHelper;
use PHPUnit\Framework\TestCase;

class CoreTestCaseTest extends TestCase
{
    /**
     * @var Client
     */
    private static $coreClient;

    public static function setUpBeforeClass(): void
    {
        self::$coreClient = MockHelper::getClient();
    }

    private static function getResponse(int $status, array $headers, $body): void
    {
        $response = new MockResponse();
        $response->setStatusCode($status);
        $response->setHeaders($headers);
        $response->setBody($body);
        $context = new Context(new Request('http://my/path'), $response, self::$coreClient);
        self::$coreClient->afterResponse($context);
    }

    private function newTestCase($result): CoreTestCase
    {
        return new CoreTestCase($this, MockHelper::getCallbackCatcher(), $result);
    }

    public function testScalarParam()
    {
        $param1 = 'This is string';

        self::getResponse(202, ['key1' => 'res/header', 'key2' => 'res/2nd'], $param1);

        $this->newTestCase($param1)->assert();

        $this->newTestCase($param1)
            ->expectHeaders(['key1' => ['differentValue', false], 'key2' => ['differentValue', 'not bool']])
            ->assert();

        $this->newTestCase($param1)
            ->expectStatus(202)
            ->expectHeaders(['key1' => ['res/header', true]])
            ->allowExtraHeaders()
            ->assert();

        $this->newTestCase($param1)
            ->expectStatusRange(200, 208)
            ->expectHeaders(['key1' => ['res/header', true], 'key2' => ['res/2nd', true]])
            ->bodyMatcher(RawBodyMatcher::init('This is string'))
            ->assert();

        $this->newTestCase($param1)
            ->expectStatusRange(200, 208)
            ->expectHeaders(['key1' => ['res/header', true], 'key2' => ['res/2nd', true]])
            ->bodyMatcher(NativeBodyMatcher::init('This is string'))
            ->assert();
    }

    public function testFileParam()
    {
        $file = TestParam::file('https://gist.githubusercontent.com/asadali214/0a64efec5353d351818475f928c50767/' .
            'raw/8ad3533799ecb4e01a753aaf04d248e6702d4947/testFile.txt');

        self::getResponse(200, [], $file);

        $this->newTestCase($file)
            ->expectStatus(200)
            ->bodyMatcher(RawBodyMatcher::init(TestParam::file('https://gist.githubusercontent.com/asadali214/' .
                '0a64efec5353d351818475f928c50767/raw/8ad3533799ecb4e01a753aaf04d248e6702d4947/testFile.txt')))
            ->assert();
    }

    public function testObjectParamForKeysAndValues()
    {
        $obj = TestParam::object('{"key1":"value 1","key2":false,"key3":2.3}');

        self::getResponse(200, [], $obj);

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(RawBodyMatcher::init('{"key1":"value 1","key2":false,"key3":2.3}'))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysAndValuesBodyMatcher::init(
                TestParam::object('{"key1":"value 1","key2":false,"key3":2.3}'),
                true,
                true
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysAndValuesBodyMatcher::init(
                TestParam::object('{"key1":"value 1","key2":false}'),
                true,
                false
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysAndValuesBodyMatcher::init(
                TestParam::object('{"key2":false,"key3":2.3,"key1":"value 1"}'),
                false,
                true
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysAndValuesBodyMatcher::init(
                TestParam::object('{"key2":false,"key3":2.3}'),
                false,
                false
            ))
            ->assert();
    }

    public function testObjectParamForKeys()
    {
        $obj = TestParam::object('{"key1":"value 1","key2":false,"key3":2.3}');

        self::getResponse(200, [], $obj);

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysBodyMatcher::init(
                TestParam::object('{"key1":"valueB","key2":true,"key3":"myString"}'),
                true,
                true
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysBodyMatcher::init(
                TestParam::object('{"key1":"value 1","key3":false}'),
                true,
                false
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysBodyMatcher::init(
                TestParam::object('{"key2":false,"key3":2.3,"key1":"value 1"}'),
                false,
                true
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(KeysBodyMatcher::init(
                TestParam::object('{"key2":{"key":"val"}}'),
                false,
                false
            ))
            ->assert();
    }

    public function testNativeBodyMatcherMessage()
    {
        $object = CoreHelper::deserialize('{"key":"somevalue"}', false);
        $array = ["key" => "somevalue"];
        $scalar = "somevalue";

        $message = NativeBodyMatcher::init($scalar)->getDefaultMessage();
        $this->assertEquals('Response values does not match', $message);

        $message = NativeBodyMatcher::init($object, true, true)->getDefaultMessage();
        $this->assertEquals('Response object values does not match in order or size', $message);

        $message = NativeBodyMatcher::init($array, true, true)->getDefaultMessage();
        $this->assertEquals('Response array values does not match in order or size', $message);

        $message = NativeBodyMatcher::init($object, false, true)->getDefaultMessage();
        $this->assertEquals('Response object values does not match in size', $message);

        $message = NativeBodyMatcher::init($array, false, true)->getDefaultMessage();
        $this->assertEquals('Response array values does not match in size', $message);

        $message = NativeBodyMatcher::init($object, true)->getDefaultMessage();
        $this->assertEquals('Response object values does not match in order', $message);

        $message = NativeBodyMatcher::init($array, true)->getDefaultMessage();
        $this->assertEquals('Response array values does not match in order', $message);

        $message = NativeBodyMatcher::init($object)->getDefaultMessage();
        $this->assertEquals('Response object values does not match', $message);

        $message = NativeBodyMatcher::init($array)->getDefaultMessage();
        $this->assertEquals('Response array values does not match', $message);
    }

    public function testClassParamForNative()
    {
        $obj = TestParam::object('{"body":{"asad":"item1","ali":"item2"}}', MockClass::class);
        self::getResponse(200, [], $obj);
        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::object('{"body":{"asad":"item1","ali":"item2"}}', MockClass::class)
            ))
            ->assert();

        $obj = TestParam::object('{"key1":{"body":{"asad":"item1","ali":"item2"}},' .
            '"key2":{"body":{"asad":"item1","ali":"item2"}}}', MockClass::class, 1);
        self::getResponse(200, [], $obj);
        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::object('{"key1":{"body":{"asad":"item1","ali":"item2"}},' .
                    '"key2":{"body":{"asad":"item1","ali":"item2"}}}', MockClass::class, 1),
                true,
                true
            ))
            ->assert();
    }

    public function testDateParamForNative()
    {
        $obj = TestParam::custom('2021-10-01', [DateHelper::class, 'fromSimpleDate']);
        self::getResponse(200, [], $obj);
        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init($obj))
            ->assert();

        $obj = TestParam::custom(
            '{"key1":"2021-10-01","key2":"2021-10-02"}',
            [DateHelper::class, 'fromSimpleDateMap']
        );
        self::getResponse(200, [], $obj);
        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init($obj, true, true))
            ->assert();

        $obj = TestParam::custom('["2021-10-01","2021-10-02"]', [DateHelper::class, 'fromSimpleDateArray']);
        self::getResponse(200, [], $obj);
        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init($obj, true, true))
            ->assert();
    }

    public function testTypeGroupParamForNative()
    {
        $obj = TestParam::typeGroup('This is string', 'oneof(string,int)');
        self::getResponse(200, [], $obj);
        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::typeGroup('This is string', 'oneof(string,int)')
            ))
            ->assert();
    }

    public function testClassArrayParamForNative()
    {
        $obj = TestParam::object('[{"body":{"asad":"item1","ali":"item2"},"0":"other value"},' .
            '{"body":{"key1":"item1","key2":"item2","key3":"item3"}}]', MockClass::class, 1);
        self::getResponse(200, [], $obj);

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::object('[{"0":"other value","body":{"ali":"item2","asad":"item1"}}' .
                    ',{"body":{"key1":"item1","key3":"item3","key2":"item2"}},{"body":{"key1":"item1"' .
                    ',"key3":"item3"}}]', MockClass::class, 1),
                false,
                false
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::object('[{"body":{"asad":"item1","ali":"item2"},"0":"other value"},' .
                    '{"body":{"key1":"item1","key2":"item2","key3":"item3"}}]', MockClass::class, 1),
                true,
                true
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::object(
                    '[{"body":{"asad":"item1","ali":"item2"},"0":"other value"}]',
                    MockClass::class,
                    1
                ),
                true,
                false
            ))
            ->assert();

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::object('[{"0":"other value","body":{"ali":"item2","asad":"item1"}},' .
                    '{"body":{"key1":"item1","key3":"item3","key2":"item2"}}]', MockClass::class, 1),
                false,
                true
            ))
            ->assert();
    }

    public function testPrimitiveArrayParamForNative()
    {
        $obj = TestParam::object('["string1","string2"]');
        self::getResponse(200, [], $obj);

        $this->newTestCase($obj)
            ->expectStatus(200)
            ->bodyMatcher(NativeBodyMatcher::init(
                TestParam::object('["string1","string2","string10","string20"]'),
                false,
                false
            ))
            ->assert();
    }

    public function testBodyComparator()
    {
        $obj1 = CoreHelper::deserialize('{"key1":23,"key2":true,"key3":"my string"}', false);
        $obj1Copy = CoreHelper::deserialize('{"key1":32,"key2":true,"key3":"my string"}', false);
        $obj2 = CoreHelper::deserialize('{"key1":23,"key3":"my string","key2":true,"key4":23.56}', false);
        $obj3 = [23, "my string"];
        $obj4 = [$obj3, "my string"];

        $this->assertFalse((new BodyComparator(false))->compare($obj1, $obj2)); // not allowing extra
        $this->assertTrue((new BodyComparator())->compare(null, null)); // both are null
        $this->assertFalse((new BodyComparator())->compare(null, $obj2)); // expected is null but actual is not.
        $this->assertFalse((new BodyComparator())->compare($obj1, null)); // actual is null but expected is not.
        // not equal but not checking for values
        $this->assertTrue((new BodyComparator(true, false, false))->compare($obj1, null));
        $this->assertFalse((new BodyComparator())->compare($obj1, 234)); // matching object with primitive
        $this->assertFalse((new BodyComparator())->compare($obj2, $obj1)); // actual obj missing a key
        // actual obj does not follow same order
        $this->assertFalse((new BodyComparator(true, true))->compare($obj1, $obj2));
        // inner actual is not array like inner expected value
        $this->assertFalse((new BodyComparator())->compare($obj4, $obj3));
        // inner expected is not array like inner actual value
        $this->assertFalse((new BodyComparator())->compare($obj3, $obj4));
        // inner expected value doesn't match actual expected value
        $this->assertFalse((new BodyComparator())->compare($obj1, $obj1Copy));
        // left associative array but right not associative
        $this->assertFalse((new BodyComparator())->compare($obj1, $obj3));
        // left indexed array but right not indexed
        $this->assertFalse((new BodyComparator())->compare($obj3, $obj1));
    }
}
