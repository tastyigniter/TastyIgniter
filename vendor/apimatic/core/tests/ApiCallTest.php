<?php

namespace Core\Tests;

use Core\Request\Parameters\AdditionalFormParams;
use Core\Request\Parameters\AdditionalQueryParams;
use Core\Request\Parameters\BodyParam;
use Core\Request\Parameters\FormParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use Core\Request\RequestBuilder;
use Core\Response\Context;
use Core\Response\Types\ErrorType;
use Core\Tests\Mocking\MockHelper;
use Core\Tests\Mocking\Other\MockChild3;
use Core\Tests\Mocking\Other\MockClass;
use Core\Tests\Mocking\Other\MockException;
use Core\Tests\Mocking\Other\MockException1;
use Core\Tests\Mocking\Other\MockException3;
use Core\Tests\Mocking\Response\MockResponse;
use Core\Tests\Mocking\Types\MockApiResponse;
use Core\Tests\Mocking\Types\MockRequest;
use Core\Utils\CoreHelper;
use CoreInterfaces\Core\Format;
use CoreInterfaces\Core\Request\RequestMethod;
use CoreInterfaces\Http\RetryOption;
use CURLFile;
use Exception;
use PHPUnit\Framework\TestCase;

class ApiCallTest extends TestCase
{
    /**
     * @param string $query Just the query path of the url
     * @return array<string,string>
     */
    private static function convertQueryIntoArray(string $query): array
    {
        $array = [];
        foreach (explode('&', $query) as $item) {
            if (empty($item)) {
                continue;
            }
            $keyVal = explode('=', $item);
            $key = self::updateKeyForArray(urldecode($keyVal[0]), $array);
            $array[$key] = urldecode($keyVal[1]);
        }
        return $array;
    }

    private static function updateKeyForArray(string $key, array $array): string
    {
        if (key_exists($key, $array)) {
            return self::updateKeyForArray("$key*", $array);
        }
        return $key;
    }

    public function testCollectedBodyParams()
    {
        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(BodyParam::init(null)->extract('key1'))
            ->build(MockHelper::getClient());
        $this->assertNull($request->getBody());

        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(BodyParam::init('some string')->extract('key1', 'new string'))
            ->build(MockHelper::getClient());
        $this->assertEquals('some string', $request->getBody());

        $options = ['key1' => true, 'key2' => 'some string', 'key3' => 23];
        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(BodyParam::init((object)$options)->extract('key1'))
            ->build(MockHelper::getClient());
        $this->assertEquals(true, $request->getBody());

        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(BodyParam::init($options)->extract('key1'))
            ->build(MockHelper::getClient());
        $this->assertEquals('true', $request->getBody());

        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(
                BodyParam::initWrapped('key1', $options)->extract('key1'),
                BodyParam::initWrapped('key3', $options)->extract('key3')
            )
            ->build(MockHelper::getClient());
        $this->assertEquals('{"key1":true,"key3":23}', $request->getBody());

        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(BodyParam::init($options)->extract('key4', 'MyConstant'))
            ->build(MockHelper::getClient());
        $this->assertEquals('MyConstant', $request->getBody());
    }

    public function testCollectedFormParams()
    {
        $options = ['key1' => true, 'key2' => 'some string', 'key3' => 23];

        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(
                FormParam::init('key1', $options)->extract('key1'),
                FormParam::init('key3', $options)->extract('key3'),
                FormParam::init('key4', $options)->extract('key4', 'MyConstant'),
                FormParam::init('key2', $options)->extract('key2', 'new string')
            )
            ->build(MockHelper::getClient());
        $this->assertNull($request->getBody());
        $this->assertEquals([
            'key1' => 'true',
            'key2' => 'some string',
            'key3' => 23,
            'key4' => 'MyConstant'
        ], $request->getParameters());
        $this->assertEquals([
            'key1' => 'key1=true',
            'key2' => 'key2=some+string',
            'key3' => 'key3=23',
            'key4' => 'key4=MyConstant'
        ], $request->getEncodedParameters());
        $this->assertEquals([], $request->getMultipartParameters());
    }

    public function testCollectedHeaderParams()
    {
        $options = ['key1' => true, 'key2' => 'some string', 'key3' => 23];

        $request = (new RequestBuilder(RequestMethod::POST, '/some/path'))
            ->parameters(
                HeaderParam::init('key1', $options)->extract('key1'),
                HeaderParam::init('key3', $options)->extract('key3'),
                HeaderParam::init('key4', $options)->extract('key4', 'MyConstant'),
                HeaderParam::init('key2', $options)->extract('key2', 'new string')
            )
            ->build(MockHelper::getClient());
        $this->assertEquals(true, $request->getHeaders()['key1']);
        $this->assertEquals('some string', $request->getHeaders()['key2']);
        $this->assertEquals(23, $request->getHeaders()['key3']);
        $this->assertEquals('MyConstant', $request->getHeaders()['key4']);
        $this->assertEquals(890.098, $request->getHeaders()['key5']);
    }

    public function testCollectedQueryParams()
    {
        $options = ['key1' => true, 'key2' => 'some string', 'key3' => 23];

        $request = (new RequestBuilder(RequestMethod::POST, '/path'))
            ->parameters(
                QueryParam::init('key1', $options)->extract('key1'),
                QueryParam::init('key3', $options)->extract('key3'),
                QueryParam::init('key4', $options)->extract('key4', 'MyConstant'),
                QueryParam::init('key2', $options)->extract('key2', 'new string')
            )
            ->build(MockHelper::getClient());
        $this->assertEquals(
            'http://my/path:3000/v1/path?key1=true&key3=23&key4=MyConstant&key2=some+string',
            $request->getQueryUrl()
        );
    }

    public function testCollectedTemplateParams()
    {
        $options = ['key1' => true, 'key2' => 'some string', 'key3' => 23];

        $request = (new RequestBuilder(RequestMethod::POST, '/{key1}/{key2}/{key3}/{key4}'))
            ->parameters(
                TemplateParam::init('key1', $options)->extract('key1'),
                TemplateParam::init('key3', $options)->extract('key3'),
                TemplateParam::init('key4', $options)->extract('key4', 'MyConstant'),
                TemplateParam::init('key2', $options)->extract('key2', 'new string')
            )
            ->build(MockHelper::getClient());
        $this->assertEquals('http://my/path:3000/v1/true/some+string/23/MyConstant', $request->getQueryUrl());
    }

    public function testSendWithConfig()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::PUT, '/2ndServer'))
                ->server('Server2')
                ->auth('header')
                ->retryOption(RetryOption::ENABLE_RETRY))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(RequestMethod::PUT, $result->body['httpMethod']);
        $this->assertEquals('https://my/path/v2/2ndServer', $result->body['queryUrl']);
        $this->assertEquals('application/json', $result->body['headers']['Accept']);
        $this->assertEquals('headVal1', $result->body['headers']['additionalHead1']);
        $this->assertEquals('headVal2', $result->body['headers']['additionalHead2']);
        $this->assertEquals('someAuthToken', $result->body['headers']['token']);
        $this->assertEquals('accessToken', $result->body['headers']['authorization']);
        $this->assertStringStartsWith('my lang|1.*.*|', $result->body['headers']['user-agent']);
        $this->assertStringNotContainsString('{', $result->body['headers']['user-agent']);
    }

    public function testSendWithoutContentType()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->disableContentType())
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertArrayNotHasKey('content-type', $result->body['headers']);
        $this->assertArrayNotHasKey('Accept', $result->body['headers']);

        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->execute();
        $this->assertArrayNotHasKey('Accept', $result['body']['headers']);
    }

    public function testSendWithContentTypeWithBody()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init(123))
                ->parameters(HeaderParam::init('content-type', 'MyContentType')))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals('MyContentType', $result->body['headers']['content-type']);
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->execute();
        $this->assertArrayNotHasKey('Accept', $result['body']['headers']);
    }

    public function testSendDisableContentTypeWithBody()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init(123))
                ->disableContentType())
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertArrayNotHasKey('content-type', $result->body['headers']);
        $this->assertArrayNotHasKey('Accept', $result->body['headers']);

        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->execute();
        $this->assertArrayNotHasKey('Accept', $result['body']['headers']);
    }

    public function testSendWithCustomContentType()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(HeaderParam::init('content-type', 'MyContentType')))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals('MyContentType', $result->body['headers']['content-type']);
    }

    public function testSendNoParams()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(RequestMethod::POST, $result->body['httpMethod']);
        $this->assertEquals('http://my/path:3000/v1/simple/{tyu}', $result->body['queryUrl']);
        $this->assertEquals('application/json', $result->body['headers']['Accept']);
        $this->assertEquals('headVal1', $result->body['headers']['additionalHead1']);
        $this->assertEquals('headVal2', $result->body['headers']['additionalHead2']);
        $this->assertEquals(
            'my lang|1.*.*|PHP|' . phpversion() . '|' . CoreHelper::getOsInfo(),
            $result->body['headers']['user-agent']
        );
    }

    public function testSendTemplate()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(TemplateParam::init('tyu', 'val 01')))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals('http://my/path:3000/v1/simple/val+01', $result->body['queryUrl']);
    }

    public function testSendTemplateArray()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(TemplateParam::init('tyu', ['val 01', '**sad&?N', 'v4'])))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals('http://my/path:3000/v1/simple/val+01/%2A%2Asad%26%3FN/v4', $result->body['queryUrl']);
    }

    public function testSendTemplateObject()
    {
        $mockObj = new MockClass([]);
        $mockObj->addAdditionalProperty('key', 'val 01');
        $mockObj->addAdditionalProperty('key2', 'v4');
        $mockObj2 = new MockClass([null, null]);
        $mockObj2->addAdditionalProperty('key3', '**sad&?N');
        $mockObj2->addAdditionalProperty('key4', 'v^^');
        $mockObj->addAdditionalProperty('key5', $mockObj2);
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(TemplateParam::init('tyu', $mockObj)))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(
            'http://my/path:3000/v1/simple//val+01/v4///%2A%2Asad%26%3FN/v%5E%5E',
            $result->body['queryUrl']
        );
    }

    public function testSendSingleQuery()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    QueryParam::init('key', 'val 01'),
                    AdditionalQueryParams::init(null)
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $query = self::convertQueryIntoArray(explode('?', $result->body['queryUrl'])[1]);
        $this->assertEquals(['key' => 'val 01'], $query);
    }

    public function testSendSingleForm()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    FormParam::init('key', 'val 01'),
                    HeaderParam::init('content-type', 'myContentTypeHeader'),
                    AdditionalFormParams::init(null)
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals('myContentTypeHeader', $result->body['headers']['content-type']);
        $this->assertNull($result->body['body']);
        $this->assertEquals(['key' => 'val 01'], $result->body['parameters']);
        $this->assertEquals(['key' => 'key=val+01'], $result->body['parametersEncoded']);
        $this->assertEquals([], $result->body['parametersMultipart']);
    }

    public function testSendMultipartFormParameters()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    FormParam::init('myFile', MockHelper::getFileWrapper())
                        ->encodingHeader('content-type', 'image/png'),
                    FormParam::init('object', new MockClass(["key" => 234]))
                        ->encodingHeader('content-type', 'application/json')
                ))
            ->responseHandler(MockHelper::responseHandler()->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals([], $result->body['parametersEncoded']);
        $file = $result->body['parametersMultipart']['myFile'];
        $this->assertInstanceOf(CURLFile::class, $file);
        $this->assertStringEndsWith('testFile.txt', $file->getFilename());
        $this->assertEquals('text/plain', $file->getMimeType());
        $this->assertEquals('My Text', $file->getPostFilename());
        $this->assertEquals($file, $result->body['parameters']['myFile']);
        $object = $result->body['parametersMultipart']['object'];
        $this->assertEquals('{"body":{"key":234}}', $object);
    }

    public function testSendFileFormWithEncodingHeader()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    FormParam::init('myFile', MockHelper::getFileWrapper())->encodingHeader('content-type', 'image/png')
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals([], $result->body['parametersEncoded']);
        $file = $result->body['parametersMultipart']['myFile'];
        $this->assertInstanceOf(CURLFile::class, $file);
        $this->assertStringEndsWith('testFile.txt', $file->getFilename());
        $this->assertEquals('text/plain', $file->getMimeType());
        $this->assertEquals('My Text', $file->getPostFilename());
        $this->assertEquals($file, $result->body['parameters']['myFile']);
    }

    public function testSendFileFormWithOtherTypes()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    FormParam::init('myFile', MockHelper::getFileWrapper()),
                    FormParam::init('key', 'val 01'),
                    FormParam::init('special', ['%^&&*^?.. + @214', true])
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals([
            'key' => 'key=val+01',
            'special' => 'special%5B0%5D=%25%5E%26%26%2A%5E%3F..+%2B+%40214&special%5B1%5D=true'
        ], $result->body['parametersEncoded']);
        $this->assertEquals(1, count($result->body['parametersMultipart']));
        $file = $result->body['parametersMultipart']['myFile'];
        $this->assertInstanceOf(CURLFile::class, $file);
        $this->assertStringEndsWith('testFile.txt', $file->getFilename());
        $this->assertEquals('text/plain', $file->getMimeType());
        $this->assertEquals('My Text', $file->getPostFilename());
        $this->assertEquals([
            'myFile' => $file,
            'key' => 'val 01',
            'special' => ['%^&&*^?.. + @214', 'true']
        ], $result->body['parameters']);
    }

    public function testAdditionalQuery()
    {
        $additionalQueryParamsUI = ['key0' => [2, 4], 'key5' => 'a'];
        $additionalQueryParamsPL = ['key1' => [2, 4], 'key6' => 'b'];
        $additionalQueryParamsC = ['key2' => [2, 4], 'key7' => 'c'];
        $additionalQueryParamsT = ['key3' => [2, 4], 'key8' => 'd'];
        $additionalQueryParamsP = ['key4' => [2, 4], 'key9' => 'e'];
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    AdditionalQueryParams::init($additionalQueryParamsUI)->unIndexed(),
                    AdditionalQueryParams::init($additionalQueryParamsPL)->plain(),
                    AdditionalQueryParams::init($additionalQueryParamsC)->commaSeparated(),
                    AdditionalQueryParams::init($additionalQueryParamsT)->tabSeparated(),
                    AdditionalQueryParams::init($additionalQueryParamsP)->pipeSeparated()
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $query = self::convertQueryIntoArray(explode('?', $result->body['queryUrl'])[1]);
        $this->assertEquals([
            'key0[]' => '2',
            'key0[]*' => '4',
            'key1' => '2',
            'key1*' => '4',
            'key2' => '2,4',
            'key3' => "2\t4",
            'key4' => '2|4',
            'key5' => 'a',
            'key6' => 'b',
            'key7' => 'c',
            'key8' => 'd',
            'key9' => 'e',
        ], $query);
    }

    public function testSendMultipleQuery()
    {
        $additionalQueryParams = [
            'keyH' => [2, 4],
            'newKey' => 'asad'
        ];
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    QueryParam::init('key A', 'val 1'),
                    QueryParam::init('keyB', new MockClass([])),
                    QueryParam::init('keyB2', [2, 4]),
                    QueryParam::init('keyC', new MockClass([23, 24, 'asad'])),
                    QueryParam::init('keyD', new MockClass([23, 24]))->unIndexed(),
                    QueryParam::init('keyE', new MockClass([true, false, null]))->plain(),
                    QueryParam::init('keyF', new MockClass(['A', 'B', 'C']))->commaSeparated(),
                    QueryParam::init('keyG', new MockClass(['A', 'B', 'C']))->tabSeparated(),
                    QueryParam::init('keyH', new MockClass(['A', 'B', 'C']))->pipeSeparated(),
                    QueryParam::init('keyI', new MockClass(['A', 'B', new MockClass([1])]))->pipeSeparated(),
                    QueryParam::init('keyJ', new MockClass(['innerKey1' => 'A', 'innerKey2' => 'B']))->pipeSeparated(),
                    QueryParam::init('keyK', new MockChild3("body", ['innerKey1' => 'A']))
                        ->commaSeparated(),
                    AdditionalQueryParams::init($additionalQueryParams)
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $query = self::convertQueryIntoArray(explode('?', $result->body['queryUrl'])[1]);
        $this->assertEquals([
            'key A' => 'val 1',
            'keyB2[0]' => '2',
            'keyB2[1]' => '4',
            'keyC[body][0]' => '23',
            'keyC[body][1]' => '24',
            'keyC[body][2]' => 'asad',
            'keyD[body][]' => '23',
            'keyD[body][]*' => '24',
            'keyE[body]' => 'true',
            'keyE[body]*' => 'false',
            'keyF[body]' => 'A,B,C',
            'keyG[body]' => "A\tB\tC",
            'keyH[body]' => 'A|B|C',
            'keyI[body]' => 'A|B',
            'keyI[body][2][body]' => '1',
            'keyJ[body][innerKey1]' => 'A',
            'keyJ[body][innerKey2]' => 'B',
            'keyH[0]' => '2',
            'keyH[1]' => '4',
            'newKey' => 'asad'
        ], $query);
    }

    public function testAdditionalForm()
    {
        $additionalFormParamsUI = ['key0' => [2, 4], 'key2' => 'a'];
        $additionalFormParamsPL = ['key1' => [2, 4], 'key3' => 'b'];
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    AdditionalFormParams::init($additionalFormParamsUI)->unIndexed(),
                    AdditionalFormParams::init($additionalFormParamsPL)->plain()
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals([
            'key0' => 'key0%5B%5D=2&key0%5B%5D=4',
            'key1' => 'key1=2&key1=4',
            'key2' => 'key2=a',
            'key3' => 'key3=b',
        ], $result->body['parametersEncoded']);
        $this->assertEquals([
            'key0' => [2, 4],
            'key1' => [2, 4],
            'key2' => 'a',
            'key3' => 'b',
        ], $result->body['parameters']);
    }

    public function testSendMultipleForm()
    {
        $additionalFormParams = [
            'keyH' => [2, 4],
            'newKey' => 'asad'
        ];
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    FormParam::init('key A', 'val 1'),
                    FormParam::init('keyB', new MockClass([])),
                    FormParam::init('keyB2', [2, 4]),
                    FormParam::init('keyB3', ['key1' => 2, 'key2' => 4]),
                    FormParam::init('keyC', new MockClass([23, 24, 'asad'])),
                    FormParam::init('keyD', new MockClass([23, 24]))->unIndexed(),
                    FormParam::init('keyE', new MockClass([23, 24, new MockClass([1])]))->unIndexed(),
                    FormParam::init('keyF', new MockClass([true, false, null]))->plain(),
                    FormParam::init('keyG', new MockClass(['innerKey1' => 'A', 'innerKey2' => 'B']))->plain(),
                    AdditionalFormParams::init($additionalFormParams)->unIndexed()
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals([
            'key A' => 'key+A=val+1',
            'keyB2' => 'keyB2%5B0%5D=2&keyB2%5B1%5D=4',
            'keyB3' => 'keyB3%5Bkey1%5D=2&keyB3%5Bkey2%5D=4',
            'keyC' => 'keyC%5Bbody%5D%5B0%5D=23&keyC%5Bbody%5D%5B1%5D=24&keyC%5Bbody%5D%5B2%5D=asad',
            'keyD' => 'keyD%5Bbody%5D%5B%5D=23&keyD%5Bbody%5D%5B%5D=24',
            'keyE' => 'keyE%5Bbody%5D%5B%5D=23&keyE%5Bbody%5D%5B%5D=24&keyE%5Bbody%5D%5B2%5D%5Bbody%5D%5B%5D=1',
            'keyF' => 'keyF%5Bbody%5D=true&keyF%5Bbody%5D=false',
            'keyG' => 'keyG%5Bbody%5D%5BinnerKey1%5D=A&keyG%5Bbody%5D%5BinnerKey2%5D=B',
            'keyH' => 'keyH%5B%5D=2&keyH%5B%5D=4',
            'newKey' => 'newKey=asad'
        ], $result->body['parametersEncoded']);
        $this->assertEquals([
            'key A' => 'val 1',
            'keyB2' => [2, 4],
            'keyB3' => ['key1' => 2, 'key2' => 4],
            'keyC' => ['body' => [23, 24, 'asad']],
            'keyD' => ['body' => [23, 24]],
            'keyE' => ['body' => [23, 24, ['body' => [1]]]],
            'keyF' => ['body' => ['true', 'false', null]],
            'keyG' => ['body' => ['innerKey1' => 'A', 'innerKey2' => 'B']],
            'keyH' => [2, 4],
            'newKey' => 'asad'
        ], $result->body['parameters']);
    }

    public function testSendBodyParam()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init('this is string')))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(Format::SCALAR, $result->body['headers']['content-type']);
        $this->assertEquals('this is string', $result->body['body']);
    }

    public function testSendBodyParamObject()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init(new MockClass([]))))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(Format::JSON, $result->body['headers']['content-type']);
        $this->assertEquals('{"body":[]}', $result->body['body']);
    }

    public function testSendBodyParamFile()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init(MockHelper::getFileWrapper())))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals('application/octet-stream', $result->body['headers']['content-type']);
        $this->assertEquals('This test file is created to test CoreFileWrapper functionality', $result->body['body']);
    }

    public function testSendMultipleBodyParams()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    BodyParam::initWrapped('key1', 'this is string'),
                    BodyParam::initWrapped('key2', new MockClass(['asad' => 'item1', 'ali' => 'item2']))
                ))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(Format::JSON, $result->body['headers']['content-type']);
        $this->assertEquals(
            '{"key1":"this is string","key2":{"body":{"asad":"item1","ali":"item2"}}}',
            $result->body['body']
        );
    }

    public function testSendXMLBodyParam()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init('this is string'))
                ->bodyXml('myRoot'))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(Format::XML, $result->body['headers']['content-type']);
        $this->assertEquals(
            '<?xml version="1.0"?>' . "\n" . '<myRoot>this is string</myRoot>' . "\n",
            $result->body['body']
        );
    }

    public function testSendXMLBodyParamModel()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init(new MockClass([34, 'asad'])))
                ->bodyXml('mockClass'))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(Format::XML, $result->body['headers']['content-type']);
        $this->assertEquals("<?xml version=\"1.0\"?>\n" .
            "<mockClass attr=\"this is attribute\">" .
            "<body>34</body><body>asad</body><new1>this is new</new1><new2><entry key=\"key1\">val1</entry>" .
            "<entry key=\"key2\">val2</entry></new2></mockClass>\n", $result->body['body']);
    }

    public function testSendXMLNullBodyParam()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init(null))
                ->bodyXml('myRoot'))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertNull($result->body['body']);
    }

    public function testSendXMLArrayBodyParam()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(BodyParam::init(['this is string', 345, false, null]))
                ->bodyXmlArray('myRoot', 'innerItem'))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(Format::XML, $result->body['headers']['content-type']);
        $this->assertEquals(
            '<?xml version="1.0"?>' . "\n" . '<myRoot><innerItem>this is string</innerItem>' .
            '<innerItem>345</innerItem><innerItem>false</innerItem></myRoot>' . "\n",
            $result->body['body']
        );
    }

    public function testSendMultipleXMLBodyParams()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}'))
                ->parameters(
                    BodyParam::initWrapped('key1', 'this is string'),
                    BodyParam::initWrapped('key2', 'this is item 2'),
                    BodyParam::initWrapped('key3', null)
                )
                ->bodyXmlMap('bodyRoot'))
            ->responseHandler(MockHelper::responseHandler()
                ->type(MockClass::class))
            ->execute();
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(Format::XML, $result->body['headers']['content-type']);
        $this->assertEquals(
            '<?xml version="1.0"?>' . "\n" . '<bodyRoot><entry key="key1">this is string</entry>' .
            '<entry key="key2">this is item 2</entry></bodyRoot>' . "\n",
            $result->body['body']
        );
    }

    public function testReceiveByWrongType()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('JsonMapper::mapClass() requires second argument to be a class name, ' .
            'MockClass given.');
        MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->responseHandler(MockHelper::responseHandler()
                ->type('MockClass'))
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function fakeSerializeBy($argument)
    {
        throw new Exception('Invalid argument found');
    }

    public function testReceiveByWrongDeserializerMethod()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('Invalid argument found');
        MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->responseHandler(MockHelper::responseHandler()
                ->deserializerMethod([$this, 'fakeSerializeBy']))
            ->execute();
    }

    public function testReceiveByWrongTypeGroup()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('Unable to map AnyOf (MockCla,string) on: ');
        MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->responseHandler(MockHelper::responseHandler()
                ->typeGroup('oneof(MockCla,string)'))
            ->execute();
    }

    public function testReceiveByAccurateTypeGroup()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->responseHandler(MockHelper::responseHandler()
                ->typeGroup('oneof(MockClass,string)'))
            ->execute();

        $this->assertInstanceOf(MockClass::class, $result);
    }

    public function testReceiveApiResponse()
    {
        $result = MockHelper::newApiCall()
            ->requestBuilder((new RequestBuilder(RequestMethod::POST, '/simple/{tyu}')))
            ->responseHandler(MockHelper::responseHandler()
                ->typeGroup('oneof(MockClass,string)')
                ->returnApiResponse())
            ->execute();
        $this->assertInstanceOf(MockApiResponse::class, $result);
        $this->assertInstanceOf(MockRequest::class, $result->getRequest());
        $this->assertInstanceOf(MockClass::class, $result->getResult());
        $this->assertStringContainsString('{"body":{"httpMethod":"Post","queryUrl":"http:\/\/my\/path:3000\/v1' .
            '\/simple\/{tyu}","headers":{"additionalHead1":"headVal1","additionalHead2":"headVal2","user-agent":' .
            '"my lang|1.*.*|', $result->getBody());
        $this->assertStringContainsString(',"Accept":"application\/json"' .
            '},"parameters":[],"parametersEncoded":[],"parametersMultipart":[],"body":null,' .
            '"retryOption":"useGlobalSettings"},"additionalProperties":[]}', $result->getBody());
        $this->assertEquals(200, $result->getStatusCode());
        $this->assertTrue($result->isSuccess());
        $this->assertNull($result->getReasonPhrase());
    }

    public function testResponseMissingInApiResponse()
    {
        $mockRequest = MockHelper::getClient()->getGlobalRequest()->convert();
        $response = new MockApiResponse($mockRequest, null, null, null, null, null);
        $this->assertInstanceOf(MockRequest::class, $response->getRequest());
        $this->assertTrue($response->isError());
    }

    public function testApiResponseWith400()
    {
        $response = new MockResponse();
        $response->setStatusCode(400);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()->type(MockClass::class)->returnApiResponse()->getResult($context);
        $this->assertInstanceOf(MockApiResponse::class, $result);
        $this->assertEquals(['res' => 'This is raw body'], $result->getResult());
        $this->assertTrue($result->isError());
    }

    public function testApiResponseWith100()
    {
        $response = new MockResponse();
        $response->setStatusCode(100);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()->type(MockClass::class)->returnApiResponse()->getResult($context);
        $this->assertInstanceOf(MockApiResponse::class, $result);
        $this->assertEquals(['res' => 'This is raw body'], $result->getResult());
        $this->assertTrue($result->isError());
    }

    public function testApiResponseWithNullOn404()
    {
        $response = new MockResponse();
        $response->setStatusCode(404);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()->nullOn404()->returnApiResponse()->getResult($context);
        $this->assertInstanceOf(MockApiResponse::class, $result);
        $this->assertNull($result->getResult());
    }

    public function testNullOn404()
    {
        $response = new MockResponse();
        $response->setStatusCode(404);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()->nullOn404()->getResult($context);
        $this->assertNull($result);
    }

    public function testStatus404WithoutNullOn404()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('HTTP Response Not OK');
        $response = new MockResponse();
        $response->setStatusCode(404);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()->getResult($context);
    }

    public function testNullOn404WithStatus400()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('Exception num 1');
        $response = new MockResponse();
        $response->setStatusCode(400);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()->nullOn404()->getResult($context);
    }

    public function testGlobalMockException()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('HTTP Response Not OK');
        $response = new MockResponse();
        $response->setStatusCode(500);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()->getResult($context);
    }

    public function testJsonPointersWithJsonArrayTypePointer()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409-headerValue, 409 - Failed to make the request 409 status code'
        );
        $response = new MockResponse();
        $response->setHeaders(["header key" => "headerValue"]);
        $response->setStatusCode(409);
        $response->setBody('{"OtherJsonField":2,"AnotherJsonField":{"Name":"name","Value":3},' .
            '"Error":[{"Code":409,"Detail":"Failed to make the request 409 status code"},' .
            '{"Code":410,"Detail":"Failed to make the request 410 status code"}]}');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}-{$response.header.header Key}, {$response.body#/Error/0/Code}' .
                ' - {$response.body#/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithJsonArray()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409-headerValue, 409 - Failed to make the request 409 status code'
        );
        $response = new MockResponse();
        $response->setHeaders(["header key" => "headerValue"]);
        $response->setStatusCode(409);
        $response->setBody('[{"OtherJsonField":2,"AnotherJsonField":{"Name":"name","Value":3},' .
            '"Error":[{"Code":409,"Detail":"Failed to make the request 409 status code"},' .
            '{"Code":410,"Detail":"Failed to make the request 410 status code"}]}]');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}-{$response.header.header Key},' .
                ' {$response.body#/0/Error/0/Code}' .
                ' - {$response.body#/0/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithNullJson()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409-headerValue,  - '
        );
        $response = new MockResponse();
        $response->setHeaders(["header key" => "headerValue"]);
        $response->setStatusCode(409);
        $response->setBody(null);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}-{$response.header.header Key},' .
                ' {$response.body#/0/Error/0/Code}' .
                ' - {$response.body#/0/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithInvalidJson()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409-headerValue,  - '
        );
        $response = new MockResponse();
        $response->setHeaders(["header key" => "headerValue"]);
        $response->setStatusCode(409);
        $response->setBody('{"invalidJson"}');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}-{$response.header.header Key},' .
                ' {$response.body#/0/Error/0/Code}' .
                ' - {$response.body#/0/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithInvalidJsonAndEmptyPointer()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409-headerValue,  - '
        );
        $response = new MockResponse();
        $response->setHeaders(["header key" => "headerValue"]);
        $response->setStatusCode(409);
        $response->setBody('{"invalidJson"}');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}-{$response.header.header Key},' .
                ' {$response.body#}' .
                ' - {$response.body#/0/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithInvalidPointer()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409-headerValue,  - '
        );
        $response = new MockResponse();
        $response->setHeaders(["header key" => "headerValue"]);
        $response->setStatusCode(409);
        $response->setBody('{"key":"value"}');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}-{$response.header.header Key},' .
                ' {$response.body#/0/Error/0/Code}' .
                ' - {$response.body#////0/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithNativeResponse()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409-headerValue,  - '
        );
        $response = new MockResponse();
        $response->setHeaders(["header key" => "headerValue"]);
        $response->setStatusCode(409);
        $response->setBody(10);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}-{$response.header.header Key},' .
                ' {$response.body#/0/Error/0/Code}' .
                ' - {$response.body#/0/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithJsonMapTypePointer()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 410, 410 - Failed to make the request 410 status code - false'
        );
        $response = new MockResponse();
        $response->setStatusCode(410);
        $response->setBody(
            '{"OtherJsonField":2,"AnotherJsonField":{"Name":"name","Value":3},' .
            '"Error":{"409":{"Code":409,"Detail":"Failed to make the request 409 status code"},' .
            '"410":{"Code":410,"Detail":"Failed to make the request 410 status code","IsSuccess":false}}}'
        );
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("410", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}, ' .
                '{$response.body#/Error/410/Code} - {$response.body#/Error/410/Detail} - ' .
                '{$response.body#/Error/410/IsSuccess}'
            ))
            ->getResult($context);
    }

    public function testErrorTypeNoJsonPointer()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 410, {"OtherJsonField":2,"AnotherJsonField":' .
            '{"Name":"name","Value":3},"Error":{"409":{"Code":409,"Detail":"Failed' .
            ' to make the request 409 status code"},"410":{"Code":410,"Detail":"Failed' .
            ' to make the request 410 status code"}}}'
        );
        $response = new MockResponse();
        $response->setStatusCode(410);
        $response->setBody(CoreHelper::deserialize('{"OtherJsonField":2,"AnotherJsonField":{"Name":"name","Value":3},' .
            '"Error":{"409":{"Code":409,"Detail":"Failed to make the request 409 status code"}' .
            ',"410":{"Code":410,"Detail":"Failed to make the request 410 status code"}}}'));
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("410", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}, {$response.body}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithValueObject()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409, 409 - {"Value":"Failed to make the request 409 status code"}'
        );
        $response = new MockResponse();
        $response->setStatusCode(409);
        $response->setBody('{"OtherJsonField":2,"AnotherJsonField":{"Name":"name","Value":3},' .
            '"Error":[{"Code":409,"Detail":{"Value":"Failed to make the request 409 status code"}},' .
            '{"Code":410,"Detail":"Failed to make the request 410 status code"}]}');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}, {$response.body#/Error/0/Code}' .
                ' - {$response.body#/Error/0/Detail}'
            ))
            ->getResult($context);
    }

    public function testJsonPointersWithNonExistentValuePointer()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 409, 409 - '
        );
        $response = new MockResponse();
        $response->setStatusCode(409);
        $response->setBody('{"OtherJsonField":2,"AnotherJsonField":{"Name":"name","Value":3},' .
            '"Error":[{"Code":409,"Detail":{"Value":"Failed to make the request 409 status code"}},' .
            '{"Code":410,"Detail":"Failed to make the request 410 status code"}]}');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("409", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}, {$response.body#/Error/0/Code}' .
                ' - {$response.body#/Error/0/NonExistentPointer}'
            ))
            ->getResult($context);
    }

    public function testErrorTypeNoJsonPointerScalarType()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 410, 10'
        );
        $response = new MockResponse();
        $response->setStatusCode(410);
        $response->setBody(10);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("410", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}, {$response.body}'
            ))
            ->getResult($context);
    }

    public function testErrorTypeNoJsonPointerBooleanType()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 410, false'
        );
        $response = new MockResponse();
        $response->setStatusCode(410);
        $response->setBody(false);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("410", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}, {$response.body}'
            ))
            ->getResult($context);
    }

    public function testErrorTypeTemplateWithEmptyJsonPoint()
    {
        $this->expectExceptionMessage(
            'Failed to make request: 410, '
        );
        $response = new MockResponse();
        $response->setStatusCode(410);
        $response->setBody('{"SomeKey":"value"}');
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("410", ErrorType::initWithErrorTemplate(
                'Failed to make request: {$statusCode}, {$response.body#}'
            ))
            ->getResult($context);
    }

    public function testGlobalMockException1()
    {
        $this->expectException(MockException1::class);
        $this->expectExceptionMessage('Exception num 1');
        $response = new MockResponse();
        $response->setStatusCode(400);
        $response->setBody([]);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()->getResult($context);
    }

    public function testGlobalMockException3()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('Exception num 3');
        $response = new MockResponse();
        $response->setStatusCode(403);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()->getResult($context);
    }

    public function testLocalMockException3()
    {
        $this->expectException(MockException3::class);
        $this->expectExceptionMessage('Local exception num 3');
        $response = new MockResponse();
        $response->setStatusCode(403);
        $response->setBody([]);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("403", ErrorType::init('Local exception num 3', MockException3::class))
            ->getResult($context);
    }

    public function testLocalMockException3WhenBodyNotObject()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('Local exception num 3');
        $response = new MockResponse();
        $response->setStatusCode(403);
        $response->setBody("some erroneous response");
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("403", ErrorType::init('Local exception num 3', MockException3::class))
            ->getResult($context);
    }

    public function testDefaultMockException1()
    {
        $this->expectException(MockException1::class);
        $this->expectExceptionMessage('Default exception');
        $response = new MockResponse();
        $response->setStatusCode(500);
        $response->setBody([]);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("403", ErrorType::init('local exception num 3', MockException3::class))
            ->throwErrorOn("0", ErrorType::init('Default exception', MockException1::class))
            ->getResult($context);
    }

    public function testDefaultExceptionMessage()
    {
        $this->expectException(MockException::class);
        $this->expectExceptionMessage('Default exception');
        $response = new MockResponse();
        $response->setStatusCode(500);
        $response->setBody([]);
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        MockHelper::responseHandler()
            ->throwErrorOn("403", ErrorType::init('local exception num 3', MockException3::class))
            ->throwErrorOn("0", ErrorType::init('Default exception'))
            ->getResult($context);
    }

    public function testScalarResponse()
    {
        $response = new MockResponse();
        $response->setBody("This is string");
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()
            ->getResult($context);
        $this->assertEquals('This is string', $result);
    }

    public function testObjectResponse()
    {
        $response = new MockResponse();
        $response->setBody(CoreHelper::deserialize('{"key":"value"}', false));
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()
            ->getResult($context);
        $this->assertEquals(['key' => 'value'], $result);
    }

    public function testTypeXmlSimple()
    {
        $response = new MockResponse();
        $response->setRawBody("<?xml version=\"1.0\"?>\n<root>This is string</root>\n");
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()
            ->typeXml('string', 'root')
            ->getResult($context);
        $this->assertEquals('This is string', $result);
    }

    public function testTypeXml()
    {
        $response = new MockResponse();
        $response->setRawBody("<?xml version=\"1.0\"?>\n" .
            "<mockClass attr=\"this is attribute\">\n" .
            "  <body>34</body>\n" .
            "  <body>asad</body>\n" .
            "  <new1>this is new</new1>\n" .
            "  <new2>\n" .
            "    <entry key=\"key1\">val1</entry>\n" .
            "    <entry key=\"key2\">val2</entry>\n" .
            "  </new2>\n" .
            "</mockClass>\n");
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()
            ->typeXml(MockClass::class, 'mockClass')
            ->getResult($context);
        $this->assertInstanceOf(MockClass::class, $result);
        $this->assertEquals(
            ["34", "asad", "this is new", ["key1" => "val1", "key2" => "val2"], "this is attribute", null],
            $result->body
        );
    }

    public function testTypeXmlArray()
    {
        $response = new MockResponse();
        $response->setRawBody("<?xml version=\"1.0\"?>\n" .
            "<mockClassArray>\n" .
            "<mockClass attr=\"this is attribute\">\n" .
            "  <body>34</body>\n" .
            "  <body>asad</body>\n" .
            "  <new1>this is new</new1>\n" .
            "  <new2>\n" .
            "    <entry key=\"key1\">val1</entry>\n" .
            "    <entry key=\"key2\">val2</entry>\n" .
            "  </new2>\n" .
            "</mockClass>\n" .
            "</mockClassArray>\n");
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()
            ->typeXmlArray(MockClass::class, 'mockClassArray', 'mockClass')
            ->getResult($context);
        $this->assertIsArray($result);
        $this->assertInstanceOf(MockClass::class, $result[0]);
        $this->assertEquals(
            ["34", "asad", "this is new", ["key1" => "val1", "key2" => "val2"], "this is attribute", null],
            $result[0]->body
        );
    }

    public function testTypeXmlMap()
    {
        $response = new MockResponse();
        $response->setRawBody("<?xml version=\"1.0\"?>\n" .
            "<mockClassMap>\n" .
            "<entry key=\"mockClass\" attr=\"this is attribute\">\n" .
            "  <body>34</body>\n" .
            "  <body>asad</body>\n" .
            "  <new1>this is new</new1>\n" .
            "  <new2>\n" .
            "    <entry key=\"key1\">val1</entry>\n" .
            "    <entry key=\"key2\">val2</entry>\n" .
            "  </new2>\n" .
            "</entry>\n" .
            "</mockClassMap>\n");
        $context = new Context(MockHelper::getClient()->getGlobalRequest(), $response, MockHelper::getClient());
        $result = MockHelper::responseHandler()
            ->typeXmlMap(MockClass::class, 'mockClassMap')
            ->getResult($context);
        $this->assertIsArray($result);
        $this->assertInstanceOf(MockClass::class, $result['mockClass']);
        $this->assertEquals(
            ["34", "asad", "this is new", ["key1" => "val1", "key2" => "val2"], "this is attribute", null],
            $result['mockClass']->body
        );
    }
}
