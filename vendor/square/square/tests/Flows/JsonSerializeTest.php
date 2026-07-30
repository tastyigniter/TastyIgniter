<?php

namespace Square\Tests;

use Square\Models\Address;
use PHPUnit\Framework\TestCase;

class JsonSerializeTest extends TestCase
{
    public function testSerialize()
    {
        $address = new Address;
        $address->setAddressLine1("500 Electric Ave");
        $address->setAddressLine2("Suite 600");
        $address->setLocality("New York");
        $address->setAdministrativeDistrictLevel1("NY");
        $address->setPostalCode("10003");
        $address->setCountry("US");

        $this->assertEquals(
            '{"address_line_1":"500 Electric Ave","address_line_2":"Suite 600","locality":"New York","administrative_district_level_1":"NY","postal_code":"10003","country":"US"}',
            \json_encode($address)
        );
    }
}