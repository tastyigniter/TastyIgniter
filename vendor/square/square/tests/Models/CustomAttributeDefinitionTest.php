<?php

namespace Square\Tests;

use Square\Models\CustomAttributeDefinition;
use Square\Models\CustomAttributeDefinitionVisibility;

use PHPUnit\Framework\TestCase;

class CustomAttributeDefinitionTest extends TestCase
{
    public function testJsonSerializeStringDefinition(){
        $schema = array(
            '$ref' => 'https://developer-production-s.squarecdn.com/schemas/v1/common.json#squareup.common.String'
        );
        $model = new CustomAttributeDefinition();
        $model->setKey('test-string-attribute');
        $model->setSchema($schema);
        $model->setName('Test String Attribute');
        $model->setDescription('This is a test');
        $model->setVisibility(CustomAttributeDefinitionVisibility::VISIBILITY_READ_WRITE_VALUES);
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-string-attribute',
            'schema' => $schema,
            'name' => 'Test String Attribute',
            'description' => 'This is a test',
            'visibility' => 'VISIBILITY_READ_WRITE_VALUES',
        ];
        $this->assertEquals($result, $expected);
    }

    public function testJsonSerializeSelectionDefinition(){
        $schema = array(
            '$schema' => 'https://developer-production-s.squarecdn.com/meta-schemas/v1/selection.json',
            'items' => [
                'enum' => [
                    'b17bb293-c44a-4622-b995-cd18ea44775e',
                    '2d7f100b-03c4-463d-a2a1-a7679eddf9d6',
                    'bda8cd16-50b2-48b6-974a-c6272a47cf77'
                ],
                'names' => [
                    'Red',
                    'Blue',
                    'Yellow'
                ]
            ],
            'maxItems' => 2,
            'uniqueItems' => true,
            'type' => 'array',
        );
        $model = new CustomAttributeDefinition();
        $model->setKey('test-selection-attribute');
        $model->setSchema($schema);
        $model->setName('Test Selection Attribute');
        $model->setDescription('This is a test');
        $model->setVisibility(CustomAttributeDefinitionVisibility::VISIBILITY_READ_WRITE_VALUES);
        $result = $model->jsonSerialize();
        $expected = [
            'key' => 'test-selection-attribute',
            'schema' => $schema,
            'name' => 'Test Selection Attribute',
            'description' => 'This is a test',
            'visibility' => 'VISIBILITY_READ_WRITE_VALUES',
        ];
        $this->assertEquals($result, $expected);
    }
}