<?php
namespace namespacetest;
require_once __DIR__ . '/Unit.php';
require_once __DIR__ . '/UnitData.php';
require_once __DIR__ . '/model/User.php';
require_once __DIR__ . '/model/Group.php';
require_once __DIR__ . '/model/UserList.php';
require_once __DIR__ . '/../othernamespace/Programmers.php';
require_once __DIR__ . '/../othernamespace/Foo.php';

use apimatic\jsonmapper\JsonMapper;
use apimatic\jsonmapper\JsonMapperException;
use namespacetest\model\User;
use othernamespace\Programmers;

/**
 * @covers \apimatic\jsonmapper\JsonMapper
 * @covers \apimatic\jsonmapper\TypeCombination
 * @covers \apimatic\jsonmapper\JsonMapperException
 */
class NamespaceTest extends \PHPUnit\Framework\TestCase
{
    public function testMapArrayNamespace()
    {
        $mapper = new JsonMapper();
        $json = '{"data":[{"value":"1.2"}]}';
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertInstanceOf('\namespacetest\UnitData', $res);
        $this->assertInstanceOf('\namespacetest\Unit', $res->data[0]);
    }

    public function testMapSimpleArrayNamespace()
    {
        $mapper = new JsonMapper();
        $json = '{"units":[{"value":"1.2"}]}';
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertInstanceOf('\namespacetest\UnitData', $res);
        $this->assertInstanceOf('\namespacetest\Unit', $res->units[0]);
    }

    public function testMapSimpleStringArrayNamespace()
    {
        $mapper = new JsonMapper();
        $json = '{"messages":["message 1", "message 2"]}';
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertInstanceOf('\namespacetest\UnitData', $res);
        $this->assertNotNull($res->messages);
        $this->assertCount(2, $res->messages);
    }

    public function testMapChildClassNamespace()
    {
        $mapper = new JsonMapper();
        $json = '{"user":{"name": "John Smith"}}';
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertInstanceOf('\namespacetest\UnitData', $res);
        $this->assertInstanceOf('\namespacetest\model\User', $res->user);
    }

    public function testMapChildClassConstructorNamespace()
    {
        $mapper = new JsonMapper();
        $json = '{"user":"John Smith"}';
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertInstanceOf('\namespacetest\UnitData', $res);
        $this->assertInstanceOf('\namespacetest\model\User', $res->user);
    }

    public function testMapChildObjectArrayNamespace()
    {
        $mapper = new JsonMapper();
        $json = '{"data":null,"user":{"name": "John Smith"}}';
        /* @var \namespacetest\UnitData $res */
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertNull($res->data);
        $this->assertInstanceOf('\namespacetest\model\User', $res->user);
    }

    public function testMapEmpty()
    {
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage("Empty type at property 'namespacetest\UnitData::\$empty'");
        $mapper = new JsonMapper();
        $json = '{"empty":{}}';
        /* @var \namespacetest\UnitData $res */
        $res = $mapper->map(json_decode($json), new UnitData());
    }

    public function testMapCustomArraObjectWithChildType()
    {
        $mapper = new JsonMapper();
        $json = '{"users":[{"user":"John Smith"}]}';
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertInstanceOf('\namespacetest\UnitData', $res);
        $this->assertInstanceOf('\namespacetest\model\UserList', $res->users);
        $this->assertInstanceOf('\namespacetest\model\User', $res->users[0]);
    }

    /**
     * Test a setter method with a namespaced type hint that
     * is within another namespace than the object itself.
     */
    public function testSetterNamespacedTypeHint()
    {
        $mapper = new JsonMapper();
        $json = '{"namespacedTypeHint":"Foo"}';
        $res = $mapper->map(json_decode($json), new UnitData());
        $this->assertInstanceOf('\namespacetest\UnitData', $res);
        $this->assertInstanceOf(
            '\othernamespace\Foo', $res->internalData['namespacedTypeHint']
        );
        $this->assertEquals(
            'Foo', $res->internalData['namespacedTypeHint']->name
        );
    }

    /**
     * Test a setter method with a namespaced type hint that
     * is within another namespace than the object itself.
     */
    public function testParentInDifferentNamespace()
    {
        $mapper = new JsonMapper();
        $json = '{"language":"PHP","languageUser":{"name":"phpUser"},"lead":{"name":"phpLead"},"users":[{"name":"member1"},{"name":"member2"}]}';
        $res = $mapper->mapClass(json_decode($json), Programmers::class);
        $this->assertInstanceOf(Programmers::class, $res);
        $this->assertEquals('PHP', $res->language);
        $this->assertInstanceOf(User::class, $res->languageUser);
        $this->assertEquals('phpUser', $res->languageUser->name);
        $this->assertInstanceOf(User::class, $res->lead);
        $this->assertEquals('phpLead', $res->lead->name);
        $this->assertTrue(is_array($res->getUsers()));
        $this->assertEquals('member1', $res->getUsers()[0]->name);
        $this->assertEquals('member2', $res->getUsers()[1]->name);
    }
}
