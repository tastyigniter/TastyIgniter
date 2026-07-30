<?php
namespace multitypetest;
require_once __DIR__ . '/MultiTypeJsonMapper.php';
require_once __DIR__ . '/model/SimpleCaseA.php'; // have field value with anyOf("int[]","float[]","bool")
require_once __DIR__ . '/model/SimpleCaseB.php'; // have field value with oneOf("bool","int[]","array")
require_once __DIR__ . '/model/ComplexCaseA.php';
    // have field value with oneOf("DateTime[]",anyOf("DateTime","string"),"ComplexCaseA")
    // have field optional with oneOf("ComplexCaseA","ComplexCaseB","SimpleCaseA")
require_once __DIR__ . '/model/ComplexCaseB.php';
    // have field value with anyOf("Evening[]","Morning[]","Employee","Person[]",oneOf("Vehicle","Car"))
    // have field optional with anyOf("ComplexCaseA","SimpleCaseB[]","array")
require_once __DIR__ . '/model/SimpleCase.php';
require_once __DIR__ . '/model/Person.php';
require_once __DIR__ . '/model/Employee.php';
require_once __DIR__ . '/model/Postman.php';
require_once __DIR__ . '/model/Morning.php';
require_once __DIR__ . '/model/Evening.php';
require_once __DIR__ . '/model/Vehicle.php';
require_once __DIR__ . '/model/Vehicle2.php';
require_once __DIR__ . '/model/Car.php';
require_once __DIR__ . '/model/Atom.php';
require_once __DIR__ . '/model/Orbit.php';
require_once __DIR__ . '/model/OuterArrayCase.php';
require_once __DIR__ . '/model/DaysEnum.php';
require_once __DIR__ . '/model/MonthNameEnum.php';
require_once __DIR__ . '/model/MonthNumberEnum.php';
require_once __DIR__ . '/model/Lion.php';
require_once __DIR__ . '/model/Deer.php';

use apimatic\jsonmapper\JsonMapper;
use apimatic\jsonmapper\JsonMapperException;
use apimatic\jsonmapper\OneOfValidationException;
use apimatic\jsonmapper\AnyOfValidationException;
use multitypetest\model\Atom;
use multitypetest\model\Car;
use multitypetest\model\Vehicle;
use PHPUnit\Framework\TestCase;

/**
 * @covers \apimatic\jsonmapper\JsonMapper
 * @covers \apimatic\jsonmapper\TypeCombination
 * @covers \apimatic\jsonmapper\JsonMapperException
 * @covers \apimatic\jsonmapper\OneOfValidationException
 * @covers \apimatic\jsonmapper\AnyOfValidationException
 */
class MultiTypeTest extends TestCase
{
    public function testSimpleCaseAWithFieldFloatArray()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[1.2,3.4]}';
        $res = $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseA');
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseA', $res);
    }

    public function testSimpleCaseAWithFieldIntArray()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[1,2]}';
        $res = $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseA');
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseA', $res);
    }

    public function testSimpleCaseAWithFieldBoolean()
    {
        $mapper = new JsonMapper();
        $json = '{"value":true}';
        $res = $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseA');
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseA', $res);
    }

    public function testSimpleCaseAFailWithConstructorArgumentMissing()
    {
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage('Could not find required constructor arguments for multitypetest\model\SimpleCaseA: value');
        $mapper = new JsonMapper();
        $json = '{"key":true}';
        $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseA');
    }

    public function testSimpleCaseAFailWithFieldBoolArray()
    {
        $this->expectException(AnyOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (int[],float[],bool) on: [false,true]');
        $mapper = new JsonMapper();
        $json = '{"value":[false,true]}';
        $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseA');
    }

    public function testSimpleCaseAFailWithFieldString()
    {
        $this->expectException(AnyOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (int[],float[],bool) on: "some string"');
        $mapper = new JsonMapper();
        $json = '{"value":"some string"}';
        $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseA');
    }

    public function testSimpleCaseBWithFieldBoolean()
    {
        $mapper = new JsonMapper();
        $json = '{"value":true}';
        $res = $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseB');
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseB', $res);
    }

    public function testSimpleCaseBWithFieldArray()
    {
        $mapper = new JsonMapper();
        $json = '{"value":["some","value"]}';
        $res = $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseB');
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseB', $res);
    }

    public function testSimpleCaseBFailWithFieldIntArray()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { array and int[] } on: [2,3]');
        $mapper = new JsonMapper();
        $json = '{"value":[2,3]}';
        $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCaseB');
    }

    public function testStringOrStringList()
    {
        $mapper = new JsonMapper();
        $json = '"some value"';
        $res = $mapper->mapFor(json_decode($json), 'anyOf(string[],string)');
        $this->assertEquals('some value', $res);

        $json = '["some","value"]';
        $res = $mapper->mapFor(json_decode($json), 'anyOf(string[],string)');
        $this->assertEquals('value', $res[1]);
    }

    public function testNeitherStringNorStringList()
    {
        $this->expectException(AnyOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (string[],string) on: [false,"value"]');
        $mapper = new JsonMapper();
        $json = '[false,"value"]';
        $mapper->mapFor(json_decode($json), 'anyOf(string[],string)');
    }

    public function testAssociativeArray()
    {
        $mapper = new JsonMapper();
        $json = ["key0" => "myString","key1" => "otherString"]; // should be mapped only by array<string,string>
        $res = $mapper->mapFor($json, 'oneOf(string[],array<string,string>)');
        self::assertTrue(is_array($res));
        self::assertTrue(is_string($res['key0']));
        self::assertTrue(is_string($res['key1']));
    }

    public function testEmptyArrayAndMap()
    {
        $mapper = new JsonMapper();
        $json = '[]'; // should be mapped only by string[]
        $res = $mapper->mapFor(json_decode($json), 'oneOf(string[],array<string,string>,array<string,int>)');
        self::assertTrue(is_array($res));

        $json = '{}'; // should be mapped only by array<string,string>
        $res = $mapper->mapFor(json_decode($json), 'oneOf(string[],int[],array<string,string>)');
        self::assertTrue(is_array($res));
    }

    public function testEmptyArrayFail()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { int[] and string[] } on: []');
        $mapper = new JsonMapper();
        $json = '[]';
        $mapper->mapFor(json_decode($json), 'oneOf(string[],int[],array<string,int>)');
    }

    public function testEmptyMapFail()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { array<string,string> and array<string,int> } on: {}');
        $mapper = new JsonMapper();
        $json = '{}';
        $mapper->mapFor(json_decode($json), 'oneOf(array<string,int>,array<string,string>,string[])');
    }

    public function testNullableObjectOrBool()
    {
        $mapper = new JsonMapper();
        $json = '["some","value"]';
        $res = $mapper->mapFor(json_decode($json), 'oneOf(anyOf(array,null),bool)');
        $this->assertEquals('value', $res[1]);

        $json = '{"key":false}';
        $res = $mapper->mapFor(json_decode($json), 'oneOf(anyOf(array,null),bool)');
        $this->assertEquals('key', array_keys($res)[0]);
        $this->assertEquals(false, array_values($res)[0]);

        $res = $mapper->mapFor(false, 'oneOf(anyOf(array,null),bool)');
        $this->assertEquals(false, $res);

        $res = $mapper->mapFor(null, 'oneOf(anyOf(array,null),bool)');
        $this->assertEquals(null, $res);
    }

    public function testNullableOnNonNullable()
    {
        $mapper = new JsonMapper();
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (array,bool) on: null');
        $mapper->mapFor(null, 'oneOf(array,bool)');
    }

    public function testMixedOrInt()
    {
        $mapper = new JsonMapper();
        $json = '{"passed":false}';
        $res = $mapper->mapFor(json_decode($json), 'oneOf(mixed,int)');
        $this->assertEquals(false, $res->passed);

        $json = 'passed string';
        $res = $mapper->mapFor($json, 'oneOf(mixed,int)');
        $this->assertEquals('passed string', $res);
    }

    public function testMixedAndIntFail()
    {
        $mapper = new JsonMapper();
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { int and mixed } on: 502');
        $mapper->mapFor(502, 'oneOf(mixed,int)');
    }

    public function testOneOfModelsWithSameReqFieldNameAndDifferentType()
    {
        $mapper = new JsonMapper();
        $json = '{"numberOfTyres":"2"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Vehicle,Vehicle2)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Vehicle', $res);

        $json = '{"numberOfTyres":2}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Vehicle,Vehicle2)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Vehicle2', $res);

        $json = '{"value":[2,6]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(SimpleCase,SimpleCaseA)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseA', $res);

        $json = '{"value":["3","2"]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(SimpleCase,SimpleCaseA)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\SimpleCase', $res);
    }

    public function testMapClassWithoutStrictType()
    {
        $mapper = new JsonMapper();
        $json = '{"numberOfTyres":"2"}';
        $res = $mapper->mapClass(json_decode($json), '\multitypetest\model\Vehicle2');
        $this->assertInstanceOf('\multitypetest\model\Vehicle2', $res);
    }

    public function testMapClassWithStrictTypeFail()
    {
        $mapper = new JsonMapper();
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage("Could not set type 'int' on value: \"2\"");
        $json = '{"numberOfTyres":"2"}';
        $mapper->mapClass(json_decode($json), '\multitypetest\model\Vehicle2', true);
    }

    public function testMapClassContainingArrayWithoutStrictType()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[2,6]}';
        $res = $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCase');
        $this->assertInstanceOf('\multitypetest\model\SimpleCase', $res);
    }

    public function testMapClassContainingArrayWithStrictTypeFail()
    {
        $mapper = new JsonMapper();
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage("Could not set type 'string' on value: 2");
        $json = '{"value":[2,6]}';
        $mapper->mapClass(json_decode($json), '\multitypetest\model\SimpleCase', true);
    }

    public function testStringOrSimpleCaseA()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[1.2]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(string,SimpleCaseA)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseA', $res);

        $json = '{"value":[1.2]}';
        $res = $mapper->mapFor(
            $json,
            'oneOf(string,SimpleCaseA)',
            'multitypetest\model'
        );
        $this->assertEquals('{"value":[1.2]}', $res);
    }

    public function testOneOfSimpleCases()
    {
        $mapper = new JsonMapper();
        $json = '{"value":["aplha","beta","gamma"]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(SimpleCaseA,SimpleCaseB)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseB', $res);
    }

    public function testOneOfSimpleCasesWithFieldArrayAndFloatArrayFail()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { SimpleCaseB and SimpleCaseA } on: {"value":[2.2,3.3]}');
        $mapper = new JsonMapper();
        $json = '{"value":[2.2,3.3]}';
        $mapper->mapFor(
            json_decode($json),
            'oneOf(SimpleCaseA,SimpleCaseB)',
            'multitypetest\model'
        );
    }

    public function testAnyOfSimpleCases()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[2.2,3.3]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(SimpleCaseA,SimpleCaseB)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseA', $res);

        $json = '{"value":[2.2,3.3]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(SimpleCaseB,SimpleCaseA)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseB', $res);

        $json = '{"value":["string1","string2"]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(SimpleCaseA,SimpleCaseB)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseB', $res);
    }

    public function testAnyOfSimpleCasesFailWithFieldString()
    {
        $this->expectException(AnyOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (SimpleCaseA,SimpleCaseB) on: {"value":"some value"}');
        $mapper = new JsonMapper();
        $json = '{"value":"some value"}';
        $mapper->mapFor(
            json_decode($json),
            'anyOf(SimpleCaseA,SimpleCaseB)',
            'multitypetest\model'
        );
    }

    public function testArrayAndObject()
    {
        $mapper = new JsonMapper();
        $json = '{"numberOfElectrons":4}';
        // oneof array of int & Atom (having all int fields)
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Atom,int[])',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Atom', $res);
    }

    public function testMapAndObject()
    {
        $mapper = new JsonMapper();
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { array<string,int> and Atom } on: {"numberOfElectrons":4}');
        $json = '{"numberOfElectrons":4}';
        // oneof map of int & Atom (having all int fields)
        $mapper->mapFor(
            json_decode($json),
            'oneOf(Atom,array<string,int>)',
            'multitypetest\model'
        );
    }

    public function testArrayOfMapAndArrayOfObject()
    {
        $mapper = new JsonMapper();
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { array<string,int>[] and Atom[] } on: [{"numberOfElectrons":4,"numberOfProtons":2}]');
        $json = '[{"numberOfElectrons":4,"numberOfProtons":2}]';
        // oneof arrayOfmap of int & array of Atom (having all int fields)
        $mapper->mapFor(
            json_decode($json),
            'oneOf(Atom[],array<string,int>[])',
            'multitypetest\model'
        );
    }

    public function testArrayOfMapOrArrayOfObject()
    {
        $mapper = new JsonMapper();
        $json = '[{"numberOfElectrons":4,"numberOfProtons":2}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(Atom[],int[][])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0]);
    }

    public function testOneOfObjectsFailWithSameRequiredFields()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { Orbit and Atom } on: {"numberOfProtons":4,"numberOfElectrons":4}');
        $mapper = new JsonMapper();
        $json = '{"numberOfProtons":4,"numberOfElectrons":4}';
        // oneof Orbit (did not have # of protons) & Atom (have # of protons optional)
        $mapper->mapFor(
            json_decode($json),
            'oneOf(Atom,Orbit)',
            'multitypetest\model'
        );
    }

    public function testComplexCases()
    {
        $mapper = new JsonMapper();
        $mapper->arChildClasses['multitypetest\model\Vehicle'] = [
            'multitypetest\model\Car',
        ];

        $json = '{"value": "199402-19", "optional": {"value": [23,24]}}';
        $res = $mapper->mapClass(json_decode($json),'\multitypetest\model\ComplexCaseA');
        $this->assertInstanceOf('\multitypetest\model\ComplexCaseA', $res);
        $this->assertTrue(is_string($res->getValue()));
        $this->assertInstanceOf('\multitypetest\model\SimpleCaseA', $res->getOptional());
        $this->assertTrue(is_int($res->getOptional()->getValue()[0]));

        $json = '{"value": "1994-02-12", "optional": {"value": ["1994-02-13","1994-02-14"],
            "optional": {"value": {"numberOfTyres":"4"}, "optional":[234,567]}}}';
        $res = $mapper->mapClass(json_decode($json),'\multitypetest\model\ComplexCaseA');
        $this->assertInstanceOf('\multitypetest\model\ComplexCaseA', $res);
        $this->assertInstanceOf('\DateTime', $res->getValue());
        $this->assertInstanceOf('\multitypetest\model\ComplexCaseA', $res->getOptional());
        $this->assertInstanceOf('\DateTime', $res->getOptional()->getValue()[0]);
        $this->assertInstanceOf('\multitypetest\model\ComplexCaseB', $res->getOptional()->getOptional());
        $this->assertInstanceOf('\multitypetest\model\Vehicle', $res->getOptional()->getOptional()->getValue());
        $this->assertTrue(is_int($res->getOptional()->getOptional()->getOptional()[0]));
    }

    public function testComplexCasesWithDiscriminators()
    {
        $mapper = new JsonMapper();
        $mapper->arChildClasses['multitypetest\model\Person'] = [
            'multitypetest\model\Postman',
            'multitypetest\model\Employee',
        ];
        $json = '{"value":[{"name":"Shahid Khaliq","age":5147483645,"address":"H # 531, S # 20","uid":"123321",' .
            '"birthday":"1994-02-13","personType":"Per"},{"name":"Shahid Khaliq","age":5147483645,' .
            '"address":"H # 531, S # 20","uid":"123321","birthday":"1994-02-13","personType":"Per"},' .
            '{"name":"Shahid Khaliq","age":5147483645,"address":"H # 531, S # 20","uid":"123321",' .
            '"birthday":"1994-02-13","personType":"Per"}]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(ComplexCaseA,ComplexCaseB)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\ComplexCaseB', $res);
        $this->assertInstanceOf('\multitypetest\model\Person', $res->getValue()[0]);
        $this->assertInstanceOf('\multitypetest\model\Person', $res->getValue()[1]);
        $this->assertInstanceOf('\multitypetest\model\Person', $res->getValue()[2]);

        $json = '{"name":"Shahid Khaliq","age":5147483645,"address":"H # 531, S # 20","uid":"123321",' .
            '"birthday":"1994-02-13","personType":"Empl"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Employee,Person)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Employee', $res);

        $json = '{"name":"Shahid Khaliq","age":5147483645,"address":"H # 531, S # 20","uid":"123321",' .
            '"birthday":"1994-02-13","personType":"Empl"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(Person,Employee)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Employee', $res);

        $json = '{"startsAt":"15:00","endsAt":"21:00","sessionType":"Evening"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Evening,Morning)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Evening', $res);

        $json = '{"value": [{"startsAt":"15:00","endsAt":"21:00","sessionType":"Evening"},' .
            '{"startsAt":"15:00","endsAt":"21:00","sessionType":"Evening"}]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(ComplexCaseA,ComplexCaseB)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\ComplexCaseB', $res);
        $this->assertInstanceOf('\multitypetest\model\Evening', $res->getValue()[0]);
        $this->assertInstanceOf('\multitypetest\model\Evening', $res->getValue()[1]);

        $json = '{"value": [{"startsAt":"15:00","endsAt":"21:00","sessionType":"Morning"},' .
            '{"startsAt":"15:00","endsAt":"21:00","sessionType":"Morning"}]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(ComplexCaseA,ComplexCaseB)',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\ComplexCaseB', $res);
        $this->assertInstanceOf('\multitypetest\model\Morning', $res->getValue()[0]);
        $this->assertInstanceOf('\multitypetest\model\Morning', $res->getValue()[1]);
    }

    public function testDiscriminatorsFailWithDiscriminatorMatchesParent()
    {
        $mapper = new JsonMapper();
        $mapper->arChildClasses['multitypetest\model\Person'] = [
            'multitypetest\model\Postman',
            'multitypetest\model\Employee',
        ];
        $this->expectException(AnyOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (Postman,Employee) on: {"name":"Shahid Khaliq","age":5147483645,"address":"H # 531, S # 20","uid":"123321","birthday":"1994-02-13","personType":"Per"}');
        $json = '{"name":"Shahid Khaliq","age":5147483645,"address":"H # 531, S # 20","uid":"123321",' .
            '"birthday":"1994-02-13","personType":"Per"}';
        $mapper->mapFor(
            json_decode($json),
            'anyOf(Postman,Employee)',
            'multitypetest\model'
        );
    }

    public function testDiscriminatorsMatchedButFailedWithOneOf()
    {
        $mapper = new JsonMapper();
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { array and Morning } on: {"startsAt":"15:00","endsAt":"21:00","sessionType":"Morning"}');
        $json = '{"startsAt":"15:00","endsAt":"21:00","sessionType":"Morning"}';
        $mapper->mapFor(
            json_decode($json),
            'oneOf(Morning,Evening,array)',
            'multitypetest\model'
        );
    }

    public function testArrays()
    {
        $mapper = new JsonMapper();
        $json = '[true,false]';
        $res = $mapper->mapFor(json_decode($json),'oneOf(bool[],int[])');
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_bool($res[0]));
        $this->assertTrue(is_bool($res[1]));
    }

    public function testMaps()
    {
        $mapper = new JsonMapper();
        $json = '{"value1":31,"value2":32}';
        $res = $mapper->mapFor(json_decode($json),'oneOf(array<string,bool>,array<string,int>)');
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_int($res['value1']));
        $this->assertTrue(is_int($res['value2']));
    }

    public function testMapOfArrays()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[true,false]}';
        $res = $mapper->mapFor(json_decode($json),'oneOf(array<string,bool[]>,array<string,int[]>)');
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['value']));
        $this->assertTrue(is_bool($res['value'][0]));

        $json = '{"value":[{"numberOfElectrons":4},{"numberOfElectrons":9}]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(array<string,Atom[]>,array<string,Car[]>)',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['value']));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['value'][0]);
    }

    public function testArrayOfMaps()
    {
        $mapper = new JsonMapper();
        $json = '[{"value":true,"value2":false},{"someBool":false}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(array<string,bool>[],array<string,int>[])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertTrue(is_array($res[1]));
        $this->assertTrue(is_bool($res[0]['value']));
        $this->assertTrue(is_bool($res[0]['value2']));
        $this->assertTrue(is_bool($res[1]['someBool']));

        $json = '[{"atom1":{"numberOfElectrons":4},"atom2":{"numberOfElectrons":9}}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(array<string,Atom>[],array<string,Car>[])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0]['atom1']);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0]['atom2']);
    }

    public function testMultiDimensionalMaps()
    {
        $mapper = new JsonMapper();
        $json = '{"key0":{"value":true,"value2":false},"key1":{"someBool":false}}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(array<string,array<string,bool>>,array<string,array<string,int>>)',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['key0']));
        $this->assertTrue(is_array($res['key1']));
        $this->assertTrue(is_bool($res['key0']['value']));
        $this->assertTrue(is_bool($res['key0']['value2']));
        $this->assertTrue(is_bool($res['key1']['someBool']));

        $json = '{"key":{"atom1":{"numberOfElectrons":4},"atom2":{"numberOfElectrons":9}}}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(array<string,array<string,Atom>>,array<string,array<string,Car>>)',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['key']));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['key']['atom1']);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['key']['atom2']);
    }

    public function testMultiDimensionalArrays()
    {
        $mapper = new JsonMapper();
        $json = '[[true,false],[false,false]]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(bool[][],int[][])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertTrue(is_array($res[1]));
        $this->assertTrue(is_bool($res[0][0]));
        $this->assertTrue(is_bool($res[0][1]));

        $json = '[[{"numberOfElectrons":4},{"numberOfElectrons":9}],[{"numberOfElectrons":2}]]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Atom[][],Car[][])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertTrue(is_array($res[1]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0][0]);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[1][0]);
    }

    public function testOuterArrayInModelField()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[true,[1,2],"abc"]}';
        $res = $mapper->mapClass(
            json_decode($json),
            '\multitypetest\model\OuterArrayCase'
        );
        $this->assertInstanceOf('\multitypetest\model\OuterArrayCase', $res);
    }

    public function testOuterArray()
    {
        $mapper = new JsonMapper();
        $json = '[true,{"numberOfElectrons":4,"numberOfProtons":2},false]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(bool,Atom)[]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue($res[0] === true);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[1]);
        $this->assertTrue($res[2] === false);
    }

    public function testOuterMap()
    {
        $mapper = new JsonMapper();
        $json = '{"key1":true,"key2":{"numberOfElectrons":4,"numberOfProtons":2},"key3":false}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,oneOf(bool,Atom)>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue($res['key1'] === true);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['key2']);
        $this->assertTrue($res['key3'] === false);
    }

    public function testOuterMapOfArrays()
    {
        $mapper = new JsonMapper();
        $json = '{"value":[{"numberOfElectrons":4},{"haveTrunk":false,"numberOfTyres":"6"}]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,oneOf(Atom,Car)[]>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['value']));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['value'][0]);
        $this->assertInstanceOf('\multitypetest\model\Car', $res['value'][1]);

        $json = '{"value":[[[{"numberOfElectrons":4}]],[[true,true],[false,true]]]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,oneOf(Atom[][],bool[][])[]>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['value']));
        $this->assertTrue(is_array($res['value'][0]));
        $this->assertTrue(is_array($res['value'][0][0]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['value'][0][0][0]);
        $this->assertTrue(is_array($res['value'][1]));
        $this->assertTrue(is_array($res['value'][1][0]));
        $this->assertTrue(is_bool($res['value'][1][0][0]));
        $this->assertTrue(is_array($res['value'][1][1]));
        $this->assertTrue(is_bool($res['value'][1][1][0]));

        $json = '{"key0":["alpha",true],"key1":["beta",[12,{"numberOfElectrons":4}],[1,3]],"key2":[false,true]}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,anyOf(bool,oneOf(int,Atom)[],string)[]>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['key0']));
        $this->assertTrue($res['key0'][0] === 'alpha');
        $this->assertTrue(is_array($res['key1']));
        $this->assertTrue($res['key1'][0] === 'beta');
        $this->assertTrue(is_array($res['key1'][1]));
        $this->assertTrue($res['key1'][1][0] === 12);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['key1'][1][1]);
        $this->assertTrue(is_array($res['key2']));
        $this->assertTrue($res['key2'][0] === false);
    }

    public function testOuterArrayOfMaps()
    {
        $mapper = new JsonMapper();
        $json = '[{"key0":{"numberOfElectrons":4},"key1":{"haveTrunk":false,"numberOfTyres":"6"}}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,oneOf(Atom,Car)>[]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0]['key0']);
        $this->assertInstanceOf('\multitypetest\model\Car', $res[0]['key1']);

        $json = '[{"key0":[[{"numberOfElectrons":4}]],"key1":[[true,true],[false,true]]}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,oneOf(Atom[][],bool[][])>[]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertTrue(is_array($res[0]['key0']));
        $this->assertTrue(is_array($res[0]['key0'][0]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0]['key0'][0][0]);
        $this->assertTrue(is_array($res[0]['key1']));
        $this->assertTrue(is_array($res[0]['key1'][0]));
        $this->assertTrue(is_bool($res[0]['key1'][0][0]));
        $this->assertTrue(is_array($res[0]['key1'][1]));
        $this->assertTrue(is_bool($res[0]['key1'][1][0]));

        $json = '[{"key0":"alpha","key1":true},{"key0":"beta","key1":[12,{"numberOfElectrons":4}],"key2":[1,3]},{"key0":false,"key1":true}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,anyOf(bool,oneOf(int,Atom)[],string)>[]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertTrue($res[0]['key0'] === 'alpha');
        $this->assertTrue(is_bool($res[0]['key1']));
        $this->assertTrue(is_array($res[1]));
        $this->assertTrue($res[1]['key0'] === 'beta');
        $this->assertTrue(is_array($res[1]['key1']));
        $this->assertTrue($res[1]['key1'][0] === 12);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[1]['key1'][1]);
        $this->assertTrue(is_array($res[1]['key2']));
        $this->assertTrue($res[1]['key2'][0] === 1);
        $this->assertTrue(is_array($res[2]));
        $this->assertTrue($res[2]['key0'] === false);
        $this->assertTrue($res[2]['key1'] === true);
    }

    public function testOuterMultiDimensionalMaps()
    {
        $mapper = new JsonMapper();
        $json = '{"item":{"key0":{"numberOfElectrons":4},"key1":{"haveTrunk":false,"numberOfTyres":"6"}}}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,array<string,oneOf(Atom,Car)>>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['item']));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['item']['key0']);
        $this->assertInstanceOf('\multitypetest\model\Car', $res['item']['key1']);

        $json = '{"item":{"key0":[[{"numberOfElectrons":4}]],"key1":[[true,true],[false,true]]}}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,array<string,oneOf(Atom[][],bool[][])>>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['item']));
        $this->assertTrue(is_array($res['item']['key0']));
        $this->assertTrue(is_array($res['item']['key0'][0]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['item']['key0'][0][0]);
        $this->assertTrue(is_array($res['item']['key1']));
        $this->assertTrue(is_array($res['item']['key1'][0]));
        $this->assertTrue(is_bool($res['item']['key1'][0][0]));
        $this->assertTrue(is_array($res['item']['key1'][1]));
        $this->assertTrue(is_bool($res['item']['key1'][1][0]));

        $json = '{"item0":{"key0":"alpha","key1":true},"item1":{"key0":"beta","key1":[12,{"numberOfElectrons":4}],"key2":[1,3]},"item2":{"key0":false,"key1":true}}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,array<string,anyOf(bool,oneOf(int,Atom)[],string)>>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res['item0']));
        $this->assertTrue($res['item0']['key0'] === 'alpha');
        $this->assertTrue(is_bool($res['item0']['key1']));
        $this->assertTrue(is_array($res['item1']));
        $this->assertTrue($res['item1']['key0'] === 'beta');
        $this->assertTrue(is_array($res['item1']['key1']));
        $this->assertTrue($res['item1']['key1'][0] === 12);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res['item1']['key1'][1]);
        $this->assertTrue(is_array($res['item1']['key2']));
        $this->assertTrue($res['item1']['key2'][0] === 1);
        $this->assertTrue(is_array($res['item2']));
        $this->assertTrue($res['item2']['key0'] === false);
        $this->assertTrue($res['item2']['key1'] === true);
    }

    public function testOuterMultiDimensionalArray()
    {
        $mapper = new JsonMapper();
        $json = '[[{"numberOfElectrons":4},{"haveTrunk":false,"numberOfTyres":"6"}]]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Atom,Car)[][]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0][0]);
        $this->assertInstanceOf('\multitypetest\model\Car', $res[0][1]);

        $json = '[[[[{"numberOfElectrons":4}]],[[true,true],[false,true]]]]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf(Atom[][],bool[][])[][]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertTrue(is_array($res[0][0]));
        $this->assertTrue(is_array($res[0][0][0]));
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[0][0][0][0]);
        $this->assertTrue(is_array($res[0][1]));
        $this->assertTrue(is_array($res[0][1][0]));
        $this->assertTrue(is_bool($res[0][1][0][0]));
        $this->assertTrue(is_array($res[0][1][1]));
        $this->assertTrue(is_bool($res[0][1][1][0]));

        $json = '[["alpha",true],["beta",[12,{"numberOfElectrons":4}],[1,3]],[false,true]]';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(bool,oneOf(int,Atom)[],string)[][]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_array($res[0]));
        $this->assertTrue($res[0][0] === 'alpha');
        $this->assertTrue(is_array($res[1]));
        $this->assertTrue($res[1][0] === 'beta');
        $this->assertTrue(is_array($res[1][1]));
        $this->assertTrue($res[1][1][0] === 12);
        $this->assertInstanceOf('\multitypetest\model\Atom', $res[1][1][1]);
        $this->assertTrue(is_array($res[2]));
        $this->assertTrue($res[2][0] === false);
    }

    public function testOuterArrayFailWithAnyOf()
    {
        $mapper = new JsonMapper();
        $this->expectException(AnyOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (float[],anyOf(bool,oneOf(int,Atom)[],string)[][]) on: {"key0":["alpha",true],"key2":[false,true],"key3":[1.1,3.3],"key1":["beta",[12,{"numberOfElectrons":4}],[1,3]]}');
        $json = '{"key0":["alpha",true],"key2":[false,true],"key3":[1.1,3.3]' .
            ',"key1":["beta",[12,{"numberOfElectrons":4}],[1,3]]}';
        $mapper->mapFor(
            json_decode($json),
            'anyOf(float[],anyOf(bool,oneOf(int,Atom)[],string)[][])',
            'multitypetest\model'
        );
    }

    public function testOuterArrayFailWith2DMapOfAtomAnd2DMapOfIntArray()
    {
        $mapper = new JsonMapper();
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { array<string,array<string,anyOf(bool,array<string,oneOf(int,Atom)>,string)>> and array<string,array<string,array<string,int>>> } on: {"key":{"element":{"atom":1,"orbits":9},"compound":{"num1":4,"num2":8}}}');
        $json = '{"key":{"element":{"atom":1,"orbits":9},"compound":{"num1":4,"num2":8}}}';
        $mapper->mapFor(
            json_decode($json),
            'oneOf(array<string,array<string,array<string,int>>>,array<string,array<string,anyOf(bool,array<string,oneOf(int,Atom)>,string)>>)',
            'multitypetest\model'
        );
    }

    public function testOuterArrayFailWithStringInsteadOfArrayOfString()
    {
        $mapper = new JsonMapper();
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage('Unable to map Array: anyOf(bool,oneOf(int,Atom)[],string)[] on: "alpha"');
        $json = '{"key0":["beta",[12,{"numberOfElectrons":4}],[1,3]],"key1":"alpha"' .
            ',"key2":[false,true]}';
        $mapper->mapFor(
            json_decode($json),
            'array<string,anyOf(bool,oneOf(int,Atom)[],string)[]>',
            'multitypetest\model'
        );
    }

    public function testOuterArrayFailWithMapOfStringInsteadOfArrayOfString()
    {
        $mapper = new JsonMapper();
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage('Unable to map Array: anyOf(bool,oneOf(int,Atom)[],string)[] on: {"item":"alpha"}');
        $json = '{"key0":["beta",[12,{"numberOfElectrons":4}],[1,3]],"key1":{"item":"alpha"}' .
            ',"key2":[false,true]}';
        $mapper->mapFor(
            json_decode($json),
            'array<string,anyOf(bool,oneOf(int,Atom)[],string)[]>',
            'multitypetest\model'
        );
    }

    public function testOuterMapFailWithStringInsteadOfMapOfString()
    {
        $mapper = new JsonMapper();
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage('Unable to map Associative Array: array<string,anyOf(bool,oneOf(int,Atom)[],string)> on: "alpha"');
        $json = '{"key0":{"item0":"beta","item1":[12,{"numberOfElectrons":4}],"item2":[1,3]},"key1":"alpha"' .
            ',"key2":{"item0":false,"item1":true}}';
        $mapper->mapFor(
            json_decode($json),
            'array<string,array<string,anyOf(bool,oneOf(int,Atom)[],string)>>',
            'multitypetest\model'
        );
    }

    public function testOuterMapFailWithArrayOfStringInsteadOfMapOfString()
    {
        $mapper = new JsonMapper();
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage('Unable to map Associative Array: array<string,anyOf(bool,oneOf(int,Atom)[],string)> on: ["alpha"]');
        $json = '{"key0":{"item0":"beta","item1":[12,{"numberOfElectrons":4}],"item2":[1,3]},"key1":["alpha"]' .
            ',"key2":{"item0":false,"item1":true}}';
        $mapper->mapFor(
            json_decode($json),
            'array<string,array<string,anyOf(bool,oneOf(int,Atom)[],string)>>',
            'multitypetest\model'
        );
    }

    public function testCheckTypeGroupFor()
    {
        $mapper = new JsonMapper();
        $res = $mapper->checkTypeGroupFor('oneof(string,int)', "this is string");
        $this->assertTrue(is_string($res));
        $this->assertEquals("this is string", $res);

        $res = $mapper->checkTypeGroupFor('oneof(Car,Atom)', new Car("3", true));
        $this->assertInstanceOf(Car::class, $res);

        $res = $mapper->checkTypeGroupFor('oneof(Car,Atom)[]', [
            new Car("3", true),
            new Atom(34)
        ]);
        $this->assertInstanceOf(Car::class, $res[0]);
        $this->assertInstanceOf(Atom::class, $res[1]);

        $res = $mapper->checkTypeGroupFor('oneof(int,DaysEnum)', "Monday", [
            'multitypetest\model\DaysEnum::checkValue DaysEnum'
        ]);
        $this->assertEquals("Monday", $res);

        $res = $mapper->checkTypeGroupFor('oneof(int,DaysEnum)[]', ["Monday", "Tuesday"], [
            'multitypetest\model\DaysEnum::checkValue DaysEnum[]'
        ]);
        $this->assertTrue(is_array($res));
        $this->assertEquals("Monday", $res[0]);
        $this->assertEquals("Tuesday", $res[1]);

        $res = $mapper->checkTypeGroupFor('oneof(DateTime,null)', null);
        $this->assertTrue(is_null($res));

        $res = $mapper->checkTypeGroupFor('anyof(string,DateTime)[]', [null, null], [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime'
        ]);
        $this->assertTrue(is_array($res));
        $this->assertTrue(is_null($res[0]));
        $this->assertTrue(is_null($res[1]));

        $res = $mapper->checkTypeGroupFor('anyof(string,DateTime)[]', ["some string"], [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTimeArray DateTime[]'
        ]);
        $this->assertTrue(is_array($res));
        $this->assertEquals("some string", $res[0]);

        $res = $mapper->checkTypeGroupFor('oneof(string,DateTime)[]', [new \DateTime("2022-06-10")], [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTimeArray DateTime[]'
        ]);
        $this->assertTrue(is_array($res));
        $this->assertEquals('Fri, 10 Jun 2022 00:00:00 GMT', $res[0]);

        $res = $mapper->checkTypeGroupFor('oneof(string,DateTime)[]', [new \DateTime("2022-06-10")], [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime'
        ]);
        $this->assertTrue(is_array($res));
        $this->assertEquals('Fri, 10 Jun 2022 00:00:00 GMT', $res[0]);

        $res = $mapper->checkTypeGroupFor('oneof(DateTime,null)', null, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime'
        ]);
        $this->assertTrue(is_null($res));
    }

    public function testCheckTypeGroupFailure() {
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage("Unable to map Type: Vehicle on: oneof(Atom,Car)");
        $mapper = new JsonMapper();

        $mapper->checkTypeGroupFor('oneof(Atom,Car)', new Vehicle("6"));
    }

    public function testCheckTypeGroupFailure2() {
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage("Unable to map Type: ((DaysEnum,string),string)[] on: oneof(int,DaysEnum)[]");
        $mapper = new JsonMapper();

        $mapper->checkTypeGroupFor('oneof(int,DaysEnum)[]', ["Monday", "string"], [
            'multitypetest\model\DaysEnum::checkValue DaysEnum'
        ]);
    }

    /**
     * This is a test for protected method JsonMapper->getType
     */
    public function testGetTypeOfSimpleValues()
    {
        $mapper = new MultiTypeJsonMapper();
        $value = "this is string";
        $this->assertEquals('string', $mapper->getType($value));
        $value = "23";
        $this->assertEquals('string', $mapper->getType($value));
        $value = 23.98;
        $this->assertEquals('float', $mapper->getType($value));
        $value = 23;
        $this->assertEquals('int', $mapper->getType($value));
        $value = false;
        $this->assertEquals('bool', $mapper->getType($value));
        $value = [];
        $this->assertEquals('array', $mapper->getType($value));
        $value = [false, true];
        $this->assertEquals('bool[]', $mapper->getType($value));
        $value = ["key1" => 23, "key2" => 34];
        $this->assertEquals('array<string,int>', $mapper->getType($value));
        $value = ["key1" => 23, "key2" => 34.9];
        $this->assertEquals('array<string,(float,int)>', $mapper->getType($value));
        $value = [false, true, null, 23];
        $this->assertEquals('(bool,int,null)[]', $mapper->getType($value));
        $value = [null, null];
        $this->assertEquals('null[]', $mapper->getType($value));

        $value = ["key1" => 23, "key2" => [34, 46]];
        $this->assertEquals('array<string,(int,int[])>', $mapper->getType($value));
        $value = [23, [34, "46"], [[true, "46"]]];
        $this->assertEquals('((bool,string)[][],(int,string)[],int)[]', $mapper->getType($value));
        $value = ["key1" => ["string", 2.3], "key2" => [21.3, "some"]];
        $this->assertEquals('array<string,(float,string)[]>', $mapper->getType($value));
        $value = [["key1" => ["some string"]], ["key1" => [false]]];
        $this->assertEquals('(array<string,bool[]>,array<string,string[]>)[]', $mapper->getType($value));
        $value = [["key1" => ["some string"]], ["key1" => ["false"]]];
        $this->assertEquals('array<string,string[]>[]', $mapper->getType($value));
        $value = ["key" => [["some string"]], ["key" => ["some string"]]];
        $this->assertEquals('array<string,(array<string,string[]>,string[][])>', $mapper->getType($value));
        $value = ["key" => [["key" => 23]], [["key" => 34]]];
        $this->assertEquals('array<string,array<string,int>[]>', $mapper->getType($value));
    }

    /**
     * This is a test for protected method JsonMapper->getType
     */
    public function testGetTypeOfComplexValues()
    {
        $mapper = new MultiTypeJsonMapper();
        $value = new \DateTime();
        $this->assertEquals('DateTime', $mapper->getType($value));
        $value = new Car("3", true);
        $this->assertEquals('Car', $mapper->getType($value));
        $value = [new \DateTime(), new \DateTime()];
        $this->assertEquals('DateTime[]', $mapper->getType($value));
        $value = [new Car("3", true), new \DateTime()];
        $this->assertEquals('(Car,DateTime)[]', $mapper->getType($value));
        $value = [new Car("3", true), true, new Car("6", false)];
        $this->assertEquals('(Car,bool)[]', $mapper->getType($value));
        $value = ["key1" => true, "key2" => new Car("6", false)];
        $this->assertEquals('array<string,(Car,bool)>', $mapper->getType($value));
        $value = [new Car("3", true), new Atom(6), null];
        $this->assertEquals('(Atom,Car,null)[]', $mapper->getType($value));
    }

    /**
     * This is a test for protected method JsonMapper->getType
     */
    public function testGetTypeWithFactoryMethods()
    {
        $mapper = new MultiTypeJsonMapper();
        // a value that did not require factory methods
        $value = "this is string";
        $this->assertEquals('string', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toSimpleDate DateTime',
            'multitypetest\model\DateTimeHelper::toSimpleDateArray DateTime[]'
        ]));
        $this->assertTrue(is_string($value));
        $this->assertEquals("this is string", $value);

        // a string value that is also an enum
        $value = "Friday";
        $this->assertEquals('(DaysEnum,string)', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toSimpleDate DateTime',
            'multitypetest\model\DaysEnum::checkValue DaysEnum'
        ]));
        $this->assertTrue(is_string($value));
        $this->assertEquals("Friday", $value);

        // a string value that can be in 2 Enums
        $value = "December";
        $this->assertEquals('(DaysEnum,MonthNameEnum,string)', $mapper->getType($value, [
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum',
            'multitypetest\model\DaysEnum::checkValue DaysEnum'
        ]));
        $this->assertTrue(is_string($value));
        $this->assertEquals("December", $value);

        // an int value that can be also be an Enum
        $value = 12;
        $this->assertEquals('(MonthNumberEnum,int)', $mapper->getType($value, [
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum',
            'multitypetest\model\MonthNumberEnum::checkValue MonthNumberEnum'
        ]));
        $this->assertTrue(is_int($value));
        $this->assertEquals(12, $value);

        // an int array which can also be Enum array
        $value = [12,1];
        $this->assertEquals('(((MonthNumberEnum[],int))[],MonthNumberEnum[])', $mapper->getType($value, [
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum',
            'multitypetest\model\MonthNumberEnum::checkValue MonthNumberEnum[]'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals(12, $value[0]);
        $this->assertEquals(1, $value[1]);

        // an int 2D array which can also be Enum 2D array
        $value = [[12,1]];
        $this->assertEquals('(((((MonthNumberEnum[][],int))[],MonthNumberEnum[][]))[],MonthNumberEnum[][])', $mapper->getType($value, [
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum',
            'multitypetest\model\MonthNumberEnum::checkValue MonthNumberEnum[][]'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertTrue(is_array($value[0]));
        $this->assertEquals(12, $value[0][0]);
        $this->assertEquals(1, $value[0][1]);

        // an int array whose inner values can be also be Enum
        $value = [12,1];
        $this->assertEquals('(((MonthNumberEnum,int))[],MonthNumberEnum)', $mapper->getType($value, [
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum',
            'multitypetest\model\MonthNumberEnum::checkValue MonthNumberEnum'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals(12, $value[0]);
        $this->assertEquals(1, $value[1]);

        // an array whose inner values can be also be Enum
        $value = [12,"1"];
        $this->assertEquals('((MonthNumberEnum,int),string)[]', $mapper->getType($value, [
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum',
            'multitypetest\model\MonthNumberEnum::checkValue MonthNumberEnum'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals(12, $value[0]);
        $this->assertEquals("1", $value[1]);

        // an array whose inner values can be also be Enum of 2 types
        $value = [12,"January"];
        $this->assertEquals('((MonthNameEnum,string),(MonthNumberEnum,int))[]', $mapper->getType($value, [
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum',
            'multitypetest\model\MonthNumberEnum::checkValue MonthNumberEnum'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals(12, $value[0]);
        $this->assertEquals("January", $value[1]);

        // a type that require factory methods, can be mapped by both factory methods
        // mapped by first one
        $value = new \DateTime("2022-06-10");
        $this->assertEquals('DateTime', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toSimpleDate DateTime',
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime'
        ]));
        $this->assertTrue(is_string($value));
        $this->assertEquals("2022-06-10", $value);

        // a type that require factory methods, can be mapped by both factory methods
        // mapped by first one
        $value = new \DateTime("2022-06-10");
        $this->assertEquals('DateTime', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime',
            'multitypetest\model\DateTimeHelper::toSimpleDate DateTime'
        ]));
        $this->assertTrue(is_string($value));
        $this->assertEquals("Fri, 10 Jun 2022 00:00:00 GMT", $value);

        // a datetime array, whose inner items can be mapped by both factory methods, mapped by first one
        $value = [new \DateTime("2022-06-10"), new \DateTime("2022-06-10")];
        $this->assertEquals('DateTime[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toSimpleDate DateTime',
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertTrue(is_string($value[0]));
        $this->assertEquals("2022-06-10", $value[0]);

        // a datetime array, can be mapped by both factory methods
        $value = [new \DateTime("2022-06-10"), new \DateTime("2022-06-10")];
        $this->assertEquals('DateTime[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTimeArray DateTime[]',
            'multitypetest\model\DateTimeHelper::toSimpleDateArray DateTime[]'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals("Fri, 10 Jun 2022 00:00:00 GMT", $value[0]);
        $this->assertEquals("Fri, 10 Jun 2022 00:00:00 GMT", $value[1]);

        // a datetime array, inner item can be mapped by 1st factory method, while
        // outer array will be mapped by 2nd factory method
        $value = [new \DateTime("2022-06-10"), new \DateTime("2022-06-10")];
        $this->assertEquals('DateTime[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime',
            'multitypetest\model\DateTimeHelper::toSimpleDateArray DateTime[]'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals("2022-06-10", $value[0]);
        $this->assertEquals("2022-06-10", $value[1]);

        // a datetime mixed array
        $value = [new \DateTime("2022-06-10"), ["key" => new \DateTime("2022-06-10")]];
        $this->assertEquals('((DateTime[],array<string,DateTime>),DateTime)[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime',
            'multitypetest\model\DateTimeHelper::toSimpleDateArray DateTime[]'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals("Fri, 10 Jun 2022 00:00:00 GMT", $value[0]);
        $this->assertTrue(is_array($value[1]));
        $this->assertEquals("Fri, 10 Jun 2022 00:00:00 GMT", $value[1]["key"]);

        // a datetime mixed array,
        $value = [new \DateTime("2022-06-10"), ["key" => new \DateTime("2022-06-10")]];
        $this->assertEquals('(DateTime,array<string,DateTime>)[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime',
            'multitypetest\model\DateTimeHelper::toSimpleDateArray array<string,DateTime>'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals("Fri, 10 Jun 2022 00:00:00 GMT", $value[0]);
        $this->assertTrue(is_array($value[1]));
        $this->assertEquals("2022-06-10", $value[1]["key"]);

        // a datetime and enum array
        $value = [new \DateTime("2022-06-10"), "December"];
        $this->assertEquals('((MonthNameEnum,string),DateTime)[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime',
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertEquals("Fri, 10 Jun 2022 00:00:00 GMT", $value[0]);
        $this->assertEquals("December", $value[1]);

        // a datetime and enum null value
        $value = null;
        $this->assertEquals('(DateTime,MonthNameEnum,null)', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime',
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum'
        ]));
        $this->assertTrue(is_null($value));

        // a datetime null values array
        $value = [null,null];
        $this->assertEquals('((DateTime,null))[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertTrue(is_null($value[0]));
        $this->assertTrue(is_null($value[1]));

        // a datetime and enum null mix array
        $value = [null,"some string"];
        $this->assertEquals('((DateTime,MonthNameEnum,null),string)[]', $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTime DateTime',
            'multitypetest\model\MonthNameEnum::checkValue MonthNameEnum'
        ]));
        $this->assertTrue(is_array($value));
        $this->assertTrue(is_null($value[0]));
        $this->assertEquals('some string', $value[1]);
    }

    /**
     * This is a test for protected method JsonMapper->checkForType
     */
    public function testGetTypeFailure()
    {
        $this->expectException(JsonMapperException::class);
        $this->expectExceptionMessage("Provided factory methods are not callable with the value of Type: DateTime\nmultitypetest\model\DateTimeHelper::toRfc1123DateTimeArray: ");
        $mapper = new MultiTypeJsonMapper();
        $value = new \DateTime();
        $mapper->getType($value, [
            'multitypetest\model\DateTimeHelper::toRfc1123DateTimeArray DateTime',
        ]);
    }

    /**
     * This is a test for protected method JsonMapper->checkForType
     */
    public function testCheckForSimpleTypes()
    {
        $mapper = new MultiTypeJsonMapper();
        $this->assertTrue($mapper->checkForType('oneof(string,int)', 'string'));
        $this->assertTrue($mapper->checkForType('oneof(string, anyof(bool, int))', 'int'));
        $this->assertTrue($mapper->checkForType('oneof(string,int)[]', 'int[]'));
        $this->assertFalse($mapper->checkForType('oneof(string,int)[]', 'array<string,int>'));
        $this->assertTrue($mapper->checkForType('array<string,oneof(string,int,bool)>', 'array<string,int>'));
        $this->assertTrue($mapper->checkForType('array<string,oneof(string,int,bool)>', 'array<string,(bool,int)>'));
        $this->assertTrue($mapper->checkForType('oneof(string,int,bool)[]', '(bool,int)[]'));
        $this->assertTrue($mapper->checkForType('oneof(string,anyof(int,bool))[]', '(bool,int)[]'));
        $this->assertTrue($mapper->checkForType('oneof(string,anyof(int,bool)[])', '(bool,int)[]'));
        $this->assertFalse($mapper->checkForType('oneof(string,anyof(int,bool[]))', '(bool,int)[]'));
        $this->assertTrue($mapper->checkForType('oneof(string,anyof(int,bool[]))', 'bool[]'));

        $this->assertTrue($mapper->checkForType('oneof(anyof(a,oneof(a[],b)[]),anyof(a,b,c)[])', '(a,b)[]'));
        $this->assertTrue($mapper->checkForType('oneof(anyof(a,oneof(a[],b)),anyof(a,b,c)[])', '((a,b)[],c[])'));
        $this->assertTrue($mapper->checkForType('oneof(anyof(a,oneof(a[],b)),anyof(a,b,c)[])', '(c,c[])'));
        $this->assertTrue($mapper->checkForType('oneof(anyof(a,b),anyof(a,b,c)[])', '(b,c)'));
        $this->assertFalse($mapper->checkForType('oneof(anyof(a,b),anyof(a,b,c)[])[]', '(b,c)'));
        $this->assertFalse($mapper->checkForType('oneof(anyof(a,b),anyof(a,b,c)[])[]', '(b,c)[]'));

    }

    /**
     * This is a test for protected method JsonMapper->checkForType
     */
    public function testCheckForComplexTypes()
    {
        $mapper = new MultiTypeJsonMapper();

        $this->assertTrue($mapper->checkForType('oneof(Car,anyof(Atom,null)[])', 'Atom[]'));
        $this->assertTrue($mapper->checkForType('oneof(Car,anyof(Atom,null)[])', 'Car'));

        $this->assertTrue($mapper->checkForType('oneof(Car,anyof(Atom,null))[]', '(Atom,Car,null)[]'));
        $this->assertTrue($mapper->checkForType('oneof(Car,anyof(Atom,null))[]', '(Atom,null)[]'));
        $this->assertFalse($mapper->checkForType('oneof(Car[],anyof(Atom,null))[]', '(Atom,Car,null)[]'));
        $this->assertFalse($mapper->checkForType('oneof(Car,oneof(Atom,Orbit)[])[]', '(Atom,null)[]'));
        $this->assertTrue($mapper->checkForType('oneof(Car,oneof(Atom,Orbit,null)[])', '(Atom,null)[]'));
        $this->assertTrue($mapper->checkForType('oneof(oneof(Atom,Orbit)[],oneof(Atom,Orbit,null)[])', '(Atom,null)[]'));

        $this->assertTrue($mapper->checkForType('array<string,oneof(Car,anyof(Atom,null))>', 'array<string,(Atom,Car,null)>'));
        $this->assertTrue($mapper->checkForType('array<string,oneof(Car,anyof(Atom,null))>', 'array<string,(Atom,null)>'));
        $this->assertFalse($mapper->checkForType('array<string,oneof(Car[],anyof(Atom,null))>', 'array<string,(Atom,Car,null)>'));
        $this->assertFalse($mapper->checkForType('array<string,oneof(Car,oneof(Atom,Orbit)[])>', 'array<string,(Atom,null)>'));
        $this->assertTrue($mapper->checkForType('oneof(Car,array<string,oneof(Atom,Orbit,null)>)', 'array<string,(Atom,null)>'));
        $this->assertTrue($mapper->checkForType('oneof(array<string,oneof(Atom,Orbit)>,array<string,oneof(Atom,Orbit,null)>)', 'array<string,(Atom,null)>'));
        $this->assertTrue($mapper->checkForType('array<string,anyOf(Postman,Person,float,null)[]>', 'array<string,(Person,float)[]>'));
    }

    public function testDiscriminatorOneOf_SimpleCases_Success()
    {
        $mapper = new JsonMapper();
        $json = '{"run":true,"type":"Hunter"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter},Deer{Hunted})',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Lion', $res);

        $json = '{"run":true,"kind":"Hunted"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{kind}(Lion{Hunter},Deer{Hunted})',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Deer', $res);
    }

    public function testDiscriminatorOneOf_SimpleCases_Failure()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { Deer and Lion } on: {"run":true,"type":"Hunter"}');
        $mapper = new JsonMapper();
        $json = '{"run":true,"type":"Hunter"}';
        $mapper->mapFor(
            json_decode($json),
            'oneOf{kind}(Lion{Hunter},Deer{Hunted})',
            'multitypetest\model'
        );
    }

    public function testDiscriminatorOneOf_InnerArrayCases_Success()
    {
        $mapper = new JsonMapper();
        $json = '[{"run":true,"type":"Hunted"},{"run":true,"type":"Hunted"}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter}[],Deer{Hunted}[])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Deer', $res[0]);
        $this->assertInstanceOf('\multitypetest\model\Deer', $res[1]);

        $json = '{"key1":{"run":true,"type":"Hunter"},"key2":{"run":true,"type":"Hunter"}}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(array<string,Lion{Hunter}>,array<string,Deer{Hunted}>)',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Lion', $res['key1']);
        $this->assertInstanceOf('\multitypetest\model\Lion', $res['key2']);
    }

    public function testDiscriminatorOneOf_InnerArrayCases_Failure()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('We could not match any acceptable type from (Lion{Hunter}[],Deer{Hunted}[]){type} on: [{"run":true,"type":"Hunted"},{"run":true,"type":"Hunter"}]');
        $mapper = new JsonMapper();
        $json = '[{"run":true,"type":"Hunted"},{"run":true,"type":"Hunter"}]';
        $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter}[],Deer{Hunted}[])',
            'multitypetest\model'
        );
    }

    public function testDiscriminatorOneOf_OuterArrayCases_Success()
    {
        $mapper = new JsonMapper();
        $json = '[{"run":true,"type":"Hunter"},{"run":true,"type":"Hunted"}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter},Deer{Hunted})[]',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Lion', $res[0]);
        $this->assertInstanceOf('\multitypetest\model\Deer', $res[1]);

        $json = '{"key1":{"run":true,"type":"Hunter"},"key2":{"run":true,"type":"Hunted"}}';
        $res = $mapper->mapFor(
            json_decode($json),
            'array<string,oneOf{type}(Lion{Hunter},Deer{Hunted})>',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Lion', $res['key1']);
        $this->assertInstanceOf('\multitypetest\model\Deer', $res['key2']);
    }

    public function testDiscriminatorOneOf_OuterArrayCases_Failure()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage('There are more than one matching types i.e. { Deer and Lion } on: {"run":true}');
        $mapper = new JsonMapper();
        $json = '[{"run":true,"type":"Hunter"},{"run":true}]';
        $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter},Deer{Hunted})[]',
            'multitypetest\model'
        );
    }

    public function testDiscriminatorOneOf_MultiLevel_Success()
    {
        $mapper = new JsonMapper();
        $json = '[{"run":true,"type":"Hunter","kind":"Small"},{"run":true,"type":"Hunt","kind":"Big"}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(oneOf{type}(Lion{Hunter},Deer{Hunted})[],oneOf{kind}(Lion{Big},Deer{Small})[])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Deer', $res[0]);
        $this->assertInstanceOf('\multitypetest\model\Lion', $res[1]);

        $json = '[{"run":true,"type":"Hunter","kind":"Small"},{"run":true,"type":"Hunted","kind":"Big"}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'anyOf(oneOf{type}(Lion{Hunter},Deer{Hunted})[],oneOf{kind}(Lion{Big},Deer{Small})[])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Lion', $res[0]);
        $this->assertInstanceOf('\multitypetest\model\Deer', $res[1]);
    }

    public function testDiscriminatorOneOf_MultiLevel_Failure()
    {
        $this->expectException(OneOfValidationException::class);
        $this->expectExceptionMessage(
            'There are more than one matching types i.e. { oneOf{kind}(Lion{Big},Deer{Small})[] and ' .
            'oneOf{type}(Lion{Hunter},Deer{Hunted})[] } on: [{"run":true,"type":"Hunter","kind":"Small"},' .
            '{"run":true,"type":"Hunted","kind":"Big"}]'
        );
        $mapper = new JsonMapper();
        $json = '[{"run":true,"type":"Hunter","kind":"Small"},{"run":true,"type":"Hunted","kind":"Big"}]';
        $mapper->mapFor(
            json_decode($json),
            'oneOf(oneOf{type}(Lion{Hunter},Deer{Hunted})[],oneOf{kind}(Lion{Big},Deer{Small})[])',
            'multitypetest\model'
        );
    }

    public function testDiscriminatorOneOf_EdgeCase_SpecialCharsInDiscValue()
    {
        $mapper = new JsonMapper();
        $mapper->discriminatorSubs = [
            'Val1' => "This, is a value\n >)]} #@** %20",
            'Val2' => 'This, is a value >)]} $#@** %20'
        ];
        $json = '{"run":true,"type":"This, is a value\n >)]} #@** %20"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter},Deer{Val1})',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Deer', $res);

        $json = '[{"run":true},{"run":true,"type":"This, is a value >)]} $#@** %20"}]';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter}[],Deer{Val2}[])',
            'multitypetest\model'
        );
        $this->assertTrue(is_array($res));
        $this->assertInstanceOf('\multitypetest\model\Deer', $res[0]);
        $this->assertInstanceOf('\multitypetest\model\Deer', $res[1]);
    }

    public function testDiscriminatorOneOf_EdgeCase_SpecialCharsInDiscField()
    {
        $mapper = new JsonMapper();
        $mapper->discriminatorSubs = [
            'type' => 'oneOf{type}(Lion{Hunter},Deer{Hunted})'
        ];
        $json = '{"run":true,"oneOf{type}(Lion{Hunter},Deer{Hunted})":"Hunted"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter},Deer{Hunted})',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Deer', $res);
    }

    public function testDiscriminatorOneOf_EdgeCase_OafFormatInDiscValue()
    {
        $mapper = new JsonMapper();
        $mapper->discriminatorSubs = [
            'type' => 'animal type'
        ];
        $json = '{"run":true,"animal type":"Hunted"}';
        $res = $mapper->mapFor(
            json_decode($json),
            'oneOf{type}(Lion{Hunter},Deer{Hunted})',
            'multitypetest\model'
        );
        $this->assertInstanceOf('\multitypetest\model\Deer', $res);
    }
}
