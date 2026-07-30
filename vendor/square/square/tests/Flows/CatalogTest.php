<?php

namespace Square\Tests;

use Core\Types\CallbackCatcher;

use Square\APIException;
use Square\APIHelper;
use Square\Exceptions;
use \Square\Models\CatalogItem;
use \Square\Models\CatalogItemVariation;
use \Square\Models\CatalogImage;
use \Square\Models\CatalogObject;
use \Square\Models\CatalogObjectType;
use \Square\Models\CreateCatalogImageRequest;
use \Square\Models\DeleteCatalogObjectResponse;
use \Square\Models\RetrieveCatalogObjectResponse;
use \Square\Models\UpsertCatalogObjectResponse;
use \Square\Models\UpsertCatalogObjectRequest;
use Square\Utils\FileWrapper;

use PHPUnit\Framework\TestCase;

class CatalogTest extends TestCase
{

    /**
     * @var \Square\Apis\CatalogApi Controller instance
     */
    protected static $controller;

    /**
     * @var CallbackCatcher Callback
     */
    protected static $httpResponse;

    /**
     * Setup test class
     */
    public static function setUpBeforeClass(): void
    {
        self::$httpResponse = new CallbackCatcher();
        self::$controller = ClientFactory::create(self::$httpResponse)->getCatalogApi();
    }


    // public function testFileUpload()
    // {
    //     $imageData = new CatalogImage();
    //     $imageData->setCaption("Image for File Upload Test");
    //     $imageData->setName('New Image');

    //     $image = new CatalogObject("IMAGE", "#java_sdk_test");
    //     $image->setImageData($imageData);

    //     $request = new CreateCatalogImageRequest(uniqid());
    //     $request->setImage($image);

    //     $imageFile = FileWrapper::createFromPath(
    //         __DIR__ . './../Resources/square.png',
    //         'image/png'
    //     );

    //     $response = self::$controller->createCatalogImage($request, $imageFile);

    //     // Log errors array if reponse->isError() returns true
    //     fwrite(STDERR, print_r($response, $response->isError()));

    //     $this->assertTrue($response->isSuccess());
    //     $this->assertNotNull($response->getResult()->getImage()->getImageData()->getUrl());

    //     self::$controller->deleteCatalogObject($response->getResult()->getImage()->getId());
    // }

    public function testUpsertCatalogObject()
    {
        $body_idempotencyKey = uniqid();
        $body_object_type = CatalogObjectType::ITEM;
        $body_object_id = '#Cocoa';
        $body_object = new CatalogObject(
            $body_object_type,
            $body_object_id
        );
        $body_object->setItemData(new CatalogItem);
        $body_object->getItemData()->setName('Cocoa');
        $body_object->getItemData()->setDescription('Hot chocolate');
        $body_object->getItemData()->setAbbreviation('Ch');
        
        $variation_object_type = CatalogObjectType::ITEM_VARIATION;
        $variation_object_id = '#Small';
        $variation_object = new CatalogObject(
            $variation_object_type,
            $variation_object_id
        );
        $variation_object->setItemVariationData(new CatalogItemVariation);
        $variation_object->getItemVariationData()->setItemId($body_object_id);
        $variation_object->getItemVariationData()->setName('Small');
        $variation_object->getItemVariationData()->setPricingType('VARIABLE_PRICING');
        
        $body_object->getItemData()->setVariations([$variation_object]);
        $body = new UpsertCatalogObjectRequest(
            $body_idempotencyKey,
            $body_object
        );

        $result = self::$controller->upsertCatalogObject($body);

        // Assert is succeess and of correct type before retrieving response object
        $this->assertTrue($result->isSuccess());
        $this->assertTrue($result->getResult() instanceof UpsertCatalogObjectResponse);

        // Retrieve response object
        $resultCatalogObject = $result->getResult()->getCatalogObject();

        $this->assertEquals($body->getObject()->getType(), $resultCatalogObject->getType());
        $this->assertEquals($body->getObject()->getItemData()->getName(), $resultCatalogObject->getItemData()->getName());
        $this->assertEquals($body->getObject()->getItemData()->getDescription(), $resultCatalogObject->getItemData()->getDescription());
        $this->assertEquals($body->getObject()->getItemData()->getAbbreviation(), $resultCatalogObject->getItemData()->getAbbreviation());

        return $result->getResult()->getCatalogObject()->getId();
    }

    /**
     * @depends testUpsertCatalogObject
     */
    public function testRetrieveCatalogObject($catalogObjectId) 
    {
        $result = self::$controller->retrieveCatalogObject($catalogObjectId,false);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue($result->getResult() instanceof RetrieveCatalogObjectResponse);

        return $catalogObjectId;
    }
    
    /**
     * @depends testRetrieveCatalogObject
     */
    public function deleteCatalogObject($catalogObjectId) 
    {
        $result = self::$controller->deleteCatalogObject($catalogObjectId);

        $this->assertTrue($result->isSuccess());
        $this->assertTrue($result->getResult() instanceof DeleteCatalogObjectResponse);
        $this->assertTrue(in_array($catalogObjectId, $result->getResult()->getDeletedObjectIds()));
    }
}