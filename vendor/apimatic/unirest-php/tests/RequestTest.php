<?php

namespace Unirest\Test;

use CoreInterfaces\Core\Request\RequestMethod;
use Exception;
use PHPUnit\Framework\TestCase;
use Unirest\Configuration;
use Unirest\HttpClient;
use Unirest\Request\Body;
use Unirest\Request\Request;
use Unirest\Test\Mocking\HttpClientChild;

class RequestTest extends TestCase
{
    // Generic
    public function testCurlOpts()
    {
        $httpClient = new HttpClient(Configuration::init()->curlOpt(CURLOPT_COOKIE, 'foo=bar'));

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertTrue(property_exists($response->getBody()->cookies, 'foo'));
    }

    public function testTimeoutFail()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Operation timed out');
        $httpClient = new HttpClient(Configuration::init()->timeout(1));
        $httpClient->execute(new Request('http://mockbin.com/delay/2000'));
    }

    public function testDefaultHeaders()
    {
        $httpClient = new HttpClient(Configuration::init()
            ->defaultHeaders([
                'header1' => 'Hello',
                'header2' => 'world'
            ]));

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Hello', $response->getBody()->headers->header1);
        $this->assertEquals('world', $response->getBody()->headers->header2);

        $response = $httpClient->execute(new Request(
            'http://mockbin.com/request',
            RequestMethod::GET,
            ['header1' => 'Custom value']
        ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Custom value', $response->getBody()->headers->header1);

        $httpClient = new HttpClient();

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertFalse(isset($response->getBody()->headers->header1));
        $this->assertFalse(isset($response->getBody()->headers->header2));
    }

    public function testDefaultHeader()
    {
        $httpClient = new HttpClient(Configuration::init()
            ->defaultHeader('Hello', 'custom'));

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(property_exists($response->getBody()->headers, 'hello'));
        $this->assertEquals('custom', $response->getBody()->headers->hello);

        $httpClient = new HttpClient();

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertFalse(property_exists($response->getBody()->headers, 'hello'));
    }

    public function testConnectionReuse()
    {
        $httpClientChild = new HttpClientChild();
        $url = "http://httpbin.org/get";

        // test client sending keep-alive automatically
        $res = $httpClientChild->execute(new Request($url));
        $this->assertEquals("keep-alive", $res->getHeaders()['Connection']);
        $this->assertEquals(1, $httpClientChild->getTotalNumberOfConnections());

        // test closing connection after response is received
        $res = $httpClientChild->execute(new Request($url, RequestMethod::GET, [ 'Connection' => 'close' ]));
        $this->assertEquals("close", $res->getHeaders()['Connection']);
        $this->assertEquals(1, $httpClientChild->getTotalNumberOfConnections());

        // test creating a new connection after closing previous one
        $res = $httpClientChild->execute(new Request($url));
        $this->assertEquals("keep-alive", $res->getHeaders()['Connection']);
        $this->assertEquals(2, $httpClientChild->getTotalNumberOfConnections());

        // test persisting the new connection
        $res = $httpClientChild->execute(new Request($url));
        $this->assertEquals("keep-alive", $res->getHeaders()['Connection']);
        $this->assertEquals(2, $httpClientChild->getTotalNumberOfConnections());
    }

    public function testConnectionReuseForMultipleDomains()
    {
        $httpClientChild = new HttpClientChild();
        $url1 = "http://httpbin.org/get";
        $url2 = "http://ptsv2.com/t/cedqp-1655183385";
        $url3 = "http://en2hoq5smpha9.x.pipedream.net";
        $url4 = "http://mockbin.com/request";

        $httpClientChild->execute(new Request($url1));
        $httpClientChild->execute(new Request($url2));
        $httpClientChild->execute(new Request($url3));
        // test creating 3 connections by calling 3 domains
        $this->assertEquals(3, $httpClientChild->getTotalNumberOfConnections());

        $httpClientChild->execute(new Request($url1));
        $httpClientChild->execute(new Request($url2));
        $httpClientChild->execute(new Request($url3));
        // test persisting previous 3 connections
        $this->assertEquals(3, $httpClientChild->getTotalNumberOfConnections());

        $httpClientChild->execute(new Request($url1));
        $httpClientChild->execute(new Request($url2));
        $httpClientChild->execute(new Request($url3));
        $httpClientChild->execute(new Request($url4));
        // test adding a new connection by persisting previous ones using a call to another domain
        $this->assertEquals(4, $httpClientChild->getTotalNumberOfConnections());
    }

    public function testSetMashapeKey()
    {
        $httpClient = new HttpClient(Configuration::init()->defaultHeader('x-mashape-key', 'abcd'));

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(property_exists($response->getBody()->headers, 'x-mashape-key'));
        $this->assertEquals('abcd', $response->getBody()->headers->{'x-mashape-key'});

        // send another request
        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue(property_exists($response->getBody()->headers, 'x-mashape-key'));
        $this->assertEquals('abcd', $response->getBody()->headers->{'x-mashape-key'});

        $httpClient = new HttpClient();

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertFalse(property_exists($response->getBody()->headers, 'x-mashape-key'));
    }

    public function testGzip()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/gzip', RequestMethod::POST));

        $this->assertEquals('gzip', $response->getHeaders()['Content-Encoding']);
    }

    public function testBasicAuthentication()
    {
        $httpClient = new HttpClient(Configuration::init()
            ->auth('user', 'password'));

        $response = $httpClient->execute(new Request('http://mockbin.com/request'));

        $this->assertEquals('Basic dXNlcjpwYXNzd29yZA==', $response->getBody()->headers->authorization);
    }

    public function testCustomHeaders()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::GET, [
            'user-agent' => 'unirest-php',
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('unirest-php', $response->getBody()->headers->{'user-agent'});
    }

    // GET
    public function testGet()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request?name=Mark', RequestMethod::GET, [
            'Accept' => 'application/json'
        ], [
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->queryString->name);
        $this->assertEquals('thefosk', $response->getBody()->queryString->nick);
    }

    public function testGetMultidimensionalArray()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::GET, [
            'Accept' => 'application/json'
        ], [
            'key' => 'value',
            'items' => [
                'item1',
                'item2'
            ]
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('value', $response->getBody()->queryString->key);
        $this->assertEquals('item1', $response->getBody()->queryString->items[0]);
        $this->assertEquals('item2', $response->getBody()->queryString->items[1]);
    }

    public function testGetWithDots()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::GET, [
            'Accept' => 'application/json'
        ], [
            'user.name' => 'Mark',
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->queryString->{'user.name'});
        $this->assertEquals('thefosk', $response->getBody()->queryString->nick);
    }

    public function testGetWithDotsAlt()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::GET, [
            'Accept' => 'application/json'
        ], [
            'user.name' => 'Mark Bond',
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('Mark Bond', $response->getBody()->queryString->{'user.name'});
        $this->assertEquals('thefosk', $response->getBody()->queryString->nick);
    }
    public function testGetWithEqualSign()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::GET, [
            'Accept' => 'application/json'
        ], [
            'name' => 'Mark=Hello'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('Mark=Hello', $response->getBody()->queryString->name);
    }

    public function testGetWithEqualSignAlt()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::GET, [
            'Accept' => 'application/json'
        ], [
            'name' => 'Mark=Hello=John'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('Mark=Hello=John', $response->getBody()->queryString->name);
    }

    public function testGetWithComplexQuery()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request(
            'http://mockbin.com/request?query=[{"type":"/music/album","name":null,"artist":' .
            '{"id":"/en/bob_dylan"},"limit":3}]&cursor'
        ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('', $response->getBody()->queryString->cursor);
        $this->assertEquals(
            '[{"type":"/music/album","name":null,"artist":{"id":"/en/bob_dylan"},"limit":3}]',
            $response->getBody()->queryString->query
        );
    }

    public function testGetArray()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::GET, [], [
            'name[0]' => 'Mark',
            'name[1]' => 'John'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('GET', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->queryString->name[0]);
        $this->assertEquals('John', $response->getBody()->queryString->name[1]);
    }

    // HEAD
    public function testHead()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request?name=Mark', RequestMethod::HEAD, [
          'Accept' => 'application/json'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
    }

    // POST
    public function testPost()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], [
            'name' => 'Mark',
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->postData->params->name);
        $this->assertEquals('thefosk', $response->getBody()->postData->params->nick);
    }

    public function testPostForm()
    {
        $httpClient = new HttpClient();
        $body = Body::Form([
            'name' => 'Mark',
            'nick' => 'thefosk'
        ]);

        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], $body));

        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('application/x-www-form-urlencoded', $response->getBody()->headers->{'content-type'});
        $this->assertEquals('application/x-www-form-urlencoded', $response->getBody()->postData->mimeType);
        $this->assertEquals('Mark', $response->getBody()->postData->params->name);
        $this->assertEquals('thefosk', $response->getBody()->postData->params->nick);
    }

    public function testPostMultipart()
    {
        $httpClient = new HttpClient();
        $body = Body::Multipart([
            'name' => 'Mark',
            'nick' => 'thefosk'
        ]);

        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json',
        ], $body));

        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('multipart/form-data', explode(';', $response->getBody()->headers->{'content-type'})[0]);
        $this->assertEquals('multipart/form-data', $response->getBody()->postData->mimeType);
        $this->assertEquals('Mark', $response->getBody()->postData->params->name);
        $this->assertEquals('thefosk', $response->getBody()->postData->params->nick);
    }

    public function testPostWithEqualSign()
    {
        $httpClient = new HttpClient();
        $body = Body::Form([
            'name' => 'Mark=Hello'
        ]);

        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], $body));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('Mark=Hello', $response->getBody()->postData->params->name);
    }

    public function testPostArray()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], [
            'name[0]' => 'Mark',
            'name[1]' => 'John'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->postData->params->{'name[0]'});
        $this->assertEquals('John', $response->getBody()->postData->params->{'name[1]'});
    }

    public function testPostWithDots()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], [
            'user.name' => 'Mark',
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->postData->params->{'user.name'});
        $this->assertEquals('thefosk', $response->getBody()->postData->params->nick);
    }

    public function testRawPost()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ], json_encode([
            'author' => 'Sam Sullivan'
        ])));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('Sam Sullivan', json_decode($response->getBody()->postData->text)->author);
    }

    public function testPostMultidimensionalArray()
    {
        $httpClient = new HttpClient();
        $body = Body::Form([
            'key' => 'value',
            'items' => [
                'item1',
                'item2'
            ]
        ]);

        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], $body));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('value', $response->getBody()->postData->params->key);
        $this->assertEquals('item1', $response->getBody()->postData->params->{'items[0]'});
        $this->assertEquals('item2', $response->getBody()->postData->params->{'items[1]'});
    }

    // PUT
    public function testPut()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::PUT, [
            'Accept' => 'application/json'
        ], [
            'name' => 'Mark',
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('PUT', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->postData->params->name);
        $this->assertEquals('thefosk', $response->getBody()->postData->params->nick);
    }

    // PATCH
    public function testPatch()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::PATCH, [
            'Accept' => 'application/json'
        ], [
            'name' => 'Mark',
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('PATCH', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->postData->params->name);
        $this->assertEquals('thefosk', $response->getBody()->postData->params->nick);
    }

    // DELETE
    public function testDelete()
    {
        $httpClient = new HttpClient();
        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::DELETE, [
            'Accept' => 'application/json',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ], [
            'name' => 'Mark',
            'nick' => 'thefosk'
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('DELETE', $response->getBody()->method);
    }

    // Upload
    public function testUpload()
    {
        $httpClient = new HttpClient();
        $fixture = __DIR__ . '/Mocking/upload.txt';

        $headers = ['Accept' => 'application/json'];
        $files = ['file' => $fixture];
        $data = ['name' => 'ahmad'];

        $body = Body::multipart($data, $files);

        $response = $httpClient->execute(new Request(
            'http://mockbin.com/request',
            RequestMethod::POST,
            $headers,
            $body
        ));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('ahmad', $response->getBody()->postData->params->name);
        $this->assertEquals('This is a test', $response->getBody()->postData->params->file);
    }

    public function testUploadWithoutHelper()
    {
        $httpClient = new HttpClient();
        $fixture = __DIR__ . '/Mocking/upload.txt';

        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], [
            'name' => 'Mark',
            'file' => Body::File($fixture)
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->postData->params->name);
        $this->assertEquals('This is a test', $response->getBody()->postData->params->file);
    }

    public function testUploadIfFilePartOfData()
    {
        $httpClient = new HttpClient();
        $fixture = __DIR__ . '/Mocking/upload.txt';

        $response = $httpClient->execute(new Request('http://mockbin.com/request', RequestMethod::POST, [
            'Accept' => 'application/json'
        ], [
            'name' => 'Mark',
            'files[owl.gif]' => Body::File($fixture)
        ]));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('POST', $response->getBody()->method);
        $this->assertEquals('Mark', $response->getBody()->postData->params->name);
        $this->assertEquals('This is a test', $response->getBody()->postData->params->{'files[owl.gif]'});
    }
}
