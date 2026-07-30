<?php


use Ably\Models\Message;
use Ably\Utils\Miscellaneous;

require_once __DIR__ . '/factories/TestApp.php';


class MiscellaneousTest extends \PHPUnit\Framework\TestCase
{

    public function testDeepConvertObjectToArrayFromObject(){
        $msg = new Message();
        $msg_nested = new Message();
        $msg_nested->data = $msg;
        Miscellaneous::deepConvertObjectToArray($msg_nested);

        //Test if message_nested is an array
        $this->AssertIsArray($msg_nested, "Expected msg_nested to be an array");

        //Test if message_nested contains all keys
        $this->AssertArrayHasKey("name", $msg_nested, "Expected msg_nested to be an array containing key `name`");
        $this->AssertArrayHasKey("connectionKey", $msg_nested, "Expected msg_nested to be an array containing key `connectionKey`");
        $this->AssertArrayHasKey("clientId", $msg_nested, "Expected msg_nested to be an array containing key `clientId`");
        $this->AssertArrayHasKey("connectionId", $msg_nested, "Expected msg_nested to be an array containing key `connectionId`");
        $this->AssertArrayHasKey("data", $msg_nested, "Expected msg_nested to be an array containing key `data`");
        $this->AssertArrayHasKey("encoding", $msg_nested, "Expected msg_nested to be an array containing key `data`");
        $this->AssertArrayHasKey("extras", $msg_nested, "Expected msg_nested to be an array containing key `data`");
        $this->AssertArrayHasKey("id", $msg_nested, "Expected msg_nested to be an array containing key `data`");
        $this->AssertArrayHasKey("timestamp", $msg_nested, "Expected msg_nested to be an array containing key `data`");
        $this->AssertArrayHasKey("originalData", $msg_nested, "Expected msg_nested to be an array containing key `data`");
        $this->AssertArrayHasKey("originalEncoding", $msg_nested, "Expected msg_nested to be an array containing key `data`");


        //Test if message_nested["data"] is an array
        $this->AssertIsArray($msg_nested, "Expected msg_nested to be an array");

        //Test if message_nested["data"] contains all keys
        $this->AssertArrayHasKey("name", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `name`");
        $this->AssertArrayHasKey("connectionKey", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `connectionKey`");
        $this->AssertArrayHasKey("clientId", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `clientId`");
        $this->AssertArrayHasKey("connectionId", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `connectionId`");
        $this->AssertArrayHasKey("data", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("encoding", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("extras", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("id", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("timestamp", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("originalData", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("originalEncoding", $msg_nested["data"], "Expected msg_nested['data'] to be an array containing key `data`");


    }

    public function testDeepConvertObjectToArrayFromArray(){
        $object = new Message();
        $array_test = [
            "name" => "test",
            "foo" => "bar",
            "object" => $object
        ];
        Miscellaneous::deepConvertObjectToArray($array_test);
        //Test if $array_test is an array
        $this->AssertIsArray($array_test, "Expected msg_nested to be an array");

        //Test if $array_test contains all keys
        $this->AssertArrayHasKey("name", $array_test, "Expected msg_nested to be an array containing key `name`");
        $this->AssertArrayHasKey("foo", $array_test, "Expected msg_nested to be an array containing key `connectionKey`");
        $this->AssertArrayHasKey("object", $array_test, "Expected msg_nested to be an array containing key `clientId`");

        //Test if $array_test["object"] is an array
        $this->AssertIsArray($array_test["object"], "Expected array_test['object'] to be an array");

        //Test if $array_test["object"] contains all keys
        $this->AssertArrayHasKey("name", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `name`");
        $this->AssertArrayHasKey("connectionKey", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `connectionKey`");
        $this->AssertArrayHasKey("clientId", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `clientId`");
        $this->AssertArrayHasKey("connectionId", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `connectionId`");
        $this->AssertArrayHasKey("data", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("encoding", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("extras", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("id", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("timestamp", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("originalData", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `data`");
        $this->AssertArrayHasKey("originalEncoding", $array_test["object"], "Expected msg_nested['data'] to be an array containing key `data`");


    }

}