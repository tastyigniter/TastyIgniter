<?php

namespace Core\Tests;

use Core\ApiCall;
use Core\Authentication\Auth;
use Core\Request\Parameters\FormParam;
use Core\Request\Parameters\HeaderParam;
use Core\Request\Parameters\QueryParam;
use Core\Request\Parameters\TemplateParam;
use Core\Request\RequestBuilder;
use Core\Response\ResponseHandler;
use Core\Response\Types\ErrorType;
use Core\TestCase\BodyMatchers\NativeBodyMatcher;
use Core\TestCase\CoreTestCase;
use Core\TestCase\TestParam;
use Core\Tests\Mocking\MockHelper;
use Core\Tests\Mocking\Other\MockClass;
use Core\Tests\Mocking\Other\MockException;
use Core\Tests\Mocking\Other\MockException3;
use Core\Tests\Mocking\Types\MockFileWrapper;
use Core\Utils\DateHelper;
use CoreInterfaces\Http\RetryOption;
use DateTime;
use PHPUnit\Framework\TestCase;

class EndToEndTest extends TestCase
{
    public function newApiCall(): ApiCall
    {
        return new ApiCall(MockHelper::getClient());
    }

    public function globalResponseHandler(): ResponseHandler
    {
        return MockHelper::getClient()->getGlobalResponseHandler();
    }

    /**
     * @param string|int      $template
     * @param DateTime[]|null $query
     * @param int             $header
     * @param MockFileWrapper $form1
     * @param array           $form2
     *
     * @return MockClass Returning some mock class
     * @throws MockException
     */
    public function callEndpoint($template, ?array $query, int $header, MockFileWrapper $form1, array $form2): MockClass
    {
        return $this->newApiCall()
            ->requestBuilder((new RequestBuilder('POST', '/api/path/{sub-path}'))
                ->server('Server2')
                ->parameters(
                    TemplateParam::init('sub-path', $template)->required()->strictType('oneof(string,int)'),
                    QueryParam::init('date array', $query)
                        ->commaSeparated()
                        ->serializeBy([DateHelper::class, 'toRfc1123DateTimeArray']),
                    HeaderParam::init('header', $header),
                    FormParam::init('form 1', $form1)
                        ->encodingHeader('content-type', 'text/plain')
                        ->unIndexed()
                        ->required(),
                    FormParam::init('form 2', $form2)->unIndexed()
                )
                ->auth(Auth::and('query', 'header'))
                ->retryOption(RetryOption::ENABLE_RETRY))
            ->responseHandler($this->globalResponseHandler()
                ->type(MockClass::class)
                ->throwErrorOn("405", ErrorType::init('Wrong payload 405', MockException3::class))
                ->nullOn404())
            ->execute();
    }

    private function newTestCase($result): CoreTestCase
    {
        return new CoreTestCase($this, MockHelper::getCallbackCatcher(), $result);
    }

    public function testEndpoint()
    {
        $template = TestParam::typeGroup('poster', 'oneof(string,int)');
        $query = TestParam::custom(
            '["Fri, 01 Oct 2021 00:00:00 GMT","Thu, 30 Sep 2021 00:00:00 GMT"]',
            [DateHelper::class, 'fromRfc1123DateTimeArray']
        );
        $header = 1234;
        $form1 = TestParam::file('https://gist.githubusercontent.com/asadali214/' .
            '0a64efec5353d351818475f928c50767/raw/8ad3533799ecb4e01a753aaf04d248e6702d4947/testFile.txt');
        $form2 = TestParam::object('{"key1":"value 1","key2":false,"key3":2.3}');

        $result = null;
        try {
            $result = $this->callEndpoint($template, $query, $header, $form1, $form2);
        } catch (MockException $e) {
            var_dump($e->getMessage());
        }
        $this->newTestCase($result)
            ->expectStatusRange(200, 208)
            ->expectHeaders(['content-type' => ['application/json', true]])
            ->allowExtraHeaders()
            ->bodyMatcher(NativeBodyMatcher::init(TestParam::object('{"body":{"httpMethod":"POST","queryUrl":' .
                '"https:\/\/my\/path\/v2\/api\/path\/poster?&date+array=Fri%2C+01+Oct+2021+00%3A00%3A00+GMT%2CThu' .
                '%2C+30+Sep+2021+00%3A00%3A00+GMT&token=someAuthToken&authorization=accessToken","headers":{' .
                '"additionalHead1":"headVal1","additionalHead2":"headVal2","header":1234,"token":"someAuthToken",' .
                '"authorization":"accessToken","Accept":"application\/json"},"parameters":{"form 2":{"key1":' .
                '"value 1","key2":"false","key3":2.3}},"parametersEncoded":{' .
                '"form 2":"form+2%5Bkey1%5D=value+1&form+2%5Bkey2%5D=false&form+2%5Bkey3%5D=2.3"},' .
                '"retryOption":"enableRetries"}}', MockClass::class), true))
            ->assert();
    }
}
