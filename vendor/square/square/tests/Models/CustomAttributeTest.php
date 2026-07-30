<?php

namespace Square\Tests;

use Square\Models\CustomAttribute;

use PHPUnit\Framework\TestCase;

class CustomAttributeTest extends TestCase
{
    public function testJsonSerializeString(){
        $model = new CustomAttribute();
        $model->setKey('test-string-attribute');
        $model->setValue('hello world');
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-string-attribute',
            'value' => 'hello world',
        ];
        $this->assertEquals($result, $expected);
    }

    public function testJsonSerializeNumber(){
        $model = new CustomAttribute();
        $model->setKey('test-number-attribute');
        $model->setValue('-12.345');
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-number-attribute',
            'value' => '-12.345',
        ];
        $this->assertEquals($result, $expected);
    }

    public function testJsonSerializeBool(){
        $model = new CustomAttribute();
        $model->setKey('test-boolean-attribute');
        $model->setValue(true);
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-boolean-attribute',
            'value' => true,
        ];
        $this->assertEquals($result, $expected);
    }

    public function testJsonSerializePhone(){
        $model = new CustomAttribute();
        $model->setKey('test-phone-attribute');
        $model->setValue('+16175551212');
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-phone-attribute',
            'value' => '+16175551212',
        ];
        $this->assertEquals($result, $expected);
    }
  
    public function testJsonSerializeEmail(){
        $model = new CustomAttribute();
        $model->setKey('test-email-attribute');
        $model->setValue('example@squareup.com');
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-email-attribute',
            'value' => 'example@squareup.com',
        ];
        $this->assertEquals($result, $expected);
    }
  
    public function testJsonSerializeDate(){
        $model = new CustomAttribute();
        $model->setKey('test-date-attribute');
        $model->setValue('2020-02-08');
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-date-attribute',
            'value' => '2020-02-08',
        ];
        $this->assertEquals($result, $expected);
    }

    public function testJsonSerializeDateTime(){
        $model = new CustomAttribute();
        $model->setKey('test-datetime-attribute');
        $model->setValue('2020-02-08T09:30:26.123');
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-datetime-attribute',
            'value' => '2020-02-08T09:30:26.123',
        ];
        $this->assertEquals($result, $expected);
    }

    public function testJsonSerializeDuration(){
        $model = new CustomAttribute();
        $model->setKey('test-duration-attribute');
        $model->setValue('P3Y6M4DT12H30M5S');
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-duration-attribute',
            'value' => 'P3Y6M4DT12H30M5S',
        ];
        $this->assertEquals($result, $expected);
    }

    public function testJsonSerializeAddress(){
        $model = new CustomAttribute();
        $model->setKey('test-address-attribute');
        $model->setValue([
            'first_name' => 'Elmo',
            'address_line_1' => '123 Sesame St.',
            'locality' => 'San Francisco',
            'administrative_district_level_1' => 'CA',
            'postal_code' => '12345',
            'country' => 'US',
        ]);
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-address-attribute',
            'value' => [
                'first_name' => 'Elmo',
                'address_line_1' => '123 Sesame St.',
                'locality' => 'San Francisco',
                'administrative_district_level_1' => 'CA',
                'postal_code' => '12345',
                'country' => 'US',
            ],
        ];
        $this->assertEquals($result, $expected);
    }
  
    public function testJsonSerializeSelection(){
        $model = new CustomAttribute();
        $model->setKey('test-selection-attribute');
        $model->setValue(['a740bb60-1002-4a4f-8280-914eb351f53d', '5ce4be85-16e6-4038-92a8-b7e7aef1c752']);
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-selection-attribute',
            'value' => ['a740bb60-1002-4a4f-8280-914eb351f53d', '5ce4be85-16e6-4038-92a8-b7e7aef1c752'],
        ];
        $this->assertEquals($result, $expected);
    }
}