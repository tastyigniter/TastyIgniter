<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The wrapper object for the catalog entries of a given object type.
 *
 * Depending on the `type` attribute value, a `CatalogObject` instance assumes a type-specific data to
 * yield the corresponding type of catalog object.
 *
 * For example, if `type=ITEM`, the `CatalogObject` instance must have the ITEM-specific data set on
 * the `item_data` attribute. The resulting `CatalogObject` instance is also a `CatalogItem` instance.
 *
 * In general, if `type=<OBJECT_TYPE>`, the `CatalogObject` instance must have the `<OBJECT_TYPE>`-
 * specific data set on the `<object_type>_data` attribute. The resulting `CatalogObject` instance is
 * also a `Catalog<ObjectType>` instance.
 *
 * For a more detailed discussion of the Catalog data model, please see the
 * [Design a Catalog](https://developer.squareup.com/docs/catalog-api/design-a-catalog) guide.
 */
class CatalogObject implements \JsonSerializable
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var array
     */
    private $isDeleted = [];

    /**
     * @var array
     */
    private $customAttributeValues = [];

    /**
     * @var array
     */
    private $catalogV1Ids = [];

    /**
     * @var array
     */
    private $presentAtAllLocations = [];

    /**
     * @var array
     */
    private $presentAtLocationIds = [];

    /**
     * @var array
     */
    private $absentAtLocationIds = [];

    /**
     * @var CatalogItem|null
     */
    private $itemData;

    /**
     * @var CatalogCategory|null
     */
    private $categoryData;

    /**
     * @var CatalogItemVariation|null
     */
    private $itemVariationData;

    /**
     * @var CatalogTax|null
     */
    private $taxData;

    /**
     * @var CatalogDiscount|null
     */
    private $discountData;

    /**
     * @var CatalogModifierList|null
     */
    private $modifierListData;

    /**
     * @var CatalogModifier|null
     */
    private $modifierData;

    /**
     * @var CatalogTimePeriod|null
     */
    private $timePeriodData;

    /**
     * @var CatalogProductSet|null
     */
    private $productSetData;

    /**
     * @var CatalogPricingRule|null
     */
    private $pricingRuleData;

    /**
     * @var CatalogImage|null
     */
    private $imageData;

    /**
     * @var CatalogMeasurementUnit|null
     */
    private $measurementUnitData;

    /**
     * @var CatalogSubscriptionPlan|null
     */
    private $subscriptionPlanData;

    /**
     * @var CatalogItemOption|null
     */
    private $itemOptionData;

    /**
     * @var CatalogItemOptionValue|null
     */
    private $itemOptionValueData;

    /**
     * @var CatalogCustomAttributeDefinition|null
     */
    private $customAttributeDefinitionData;

    /**
     * @var CatalogQuickAmountsSettings|null
     */
    private $quickAmountsSettingsData;

    /**
     * @param string $type
     * @param string $id
     */
    public function __construct(string $type, string $id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Returns Type.
     * Possible types of CatalogObjects returned from the catalog, each
     * containing type-specific properties in the `*_data` field corresponding to the specfied object type.
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * Possible types of CatalogObjects returned from the catalog, each
     * containing type-specific properties in the `*_data` field corresponding to the specfied object type.
     *
     * @required
     * @maps type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Id.
     * An identifier to reference this object in the catalog. When a new `CatalogObject`
     * is inserted, the client should set the id to a temporary identifier starting with
     * a "`#`" character. Other objects being inserted or updated within the same request
     * may use this identifier to refer to the new object.
     *
     * When the server receives the new object, it will supply a unique identifier that
     * replaces the temporary identifier for all future references.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * An identifier to reference this object in the catalog. When a new `CatalogObject`
     * is inserted, the client should set the id to a temporary identifier starting with
     * a "`#`" character. Other objects being inserted or updated within the same request
     * may use this identifier to refer to the new object.
     *
     * When the server receives the new object, it will supply a unique identifier that
     * replaces the temporary identifier for all future references.
     *
     * @required
     * @maps id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Updated At.
     * Last modification [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * in RFC 3339 format, e.g., `"2016-08-15T23:59:33.123Z"`
     * would indicate the UTC time (denoted by `Z`) of August 15, 2016 at 23:59:33 and 123 milliseconds.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * Last modification [timestamp](https://developer.squareup.com/docs/build-basics/working-with-dates)
     * in RFC 3339 format, e.g., `"2016-08-15T23:59:33.123Z"`
     * would indicate the UTC time (denoted by `Z`) of August 15, 2016 at 23:59:33 and 123 milliseconds.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Version.
     * The version of the object. When updating an object, the version supplied
     * must match the version in the database, otherwise the write will be rejected as conflicting.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The version of the object. When updating an object, the version supplied
     * must match the version in the database, otherwise the write will be rejected as conflicting.
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Is Deleted.
     * If `true`, the object has been deleted from the database. Must be `false` for new objects
     * being inserted. When deleted, the `updated_at` field will equal the deletion time.
     */
    public function getIsDeleted(): ?bool
    {
        if (count($this->isDeleted) == 0) {
            return null;
        }
        return $this->isDeleted['value'];
    }

    /**
     * Sets Is Deleted.
     * If `true`, the object has been deleted from the database. Must be `false` for new objects
     * being inserted. When deleted, the `updated_at` field will equal the deletion time.
     *
     * @maps is_deleted
     */
    public function setIsDeleted(?bool $isDeleted): void
    {
        $this->isDeleted['value'] = $isDeleted;
    }

    /**
     * Unsets Is Deleted.
     * If `true`, the object has been deleted from the database. Must be `false` for new objects
     * being inserted. When deleted, the `updated_at` field will equal the deletion time.
     */
    public function unsetIsDeleted(): void
    {
        $this->isDeleted = [];
    }

    /**
     * Returns Custom Attribute Values.
     * A map (key-value pairs) of application-defined custom attribute values. The value of a key-value
     * pair
     * is a [CatalogCustomAttributeValue](entity:CatalogCustomAttributeValue) object. The key is the `key`
     * attribute
     * value defined in the associated [CatalogCustomAttributeDefinition](entity:
     * CatalogCustomAttributeDefinition)
     * object defined by the application making the request.
     *
     * If the `CatalogCustomAttributeDefinition` object is
     * defined by another application, the `CatalogCustomAttributeDefinition`'s key attribute value is
     * prefixed by
     * the defining application ID. For example, if the `CatalogCustomAttributeDefinition` has a `key`
     * attribute of
     * `"cocoa_brand"` and the defining application ID is `"abcd1234"`, the key in the map is `"abcd1234:
     * cocoa_brand"`
     * if the application making the request is different from the application defining the custom
     * attribute definition.
     * Otherwise, the key used in the map is simply `"cocoa_brand"`.
     *
     * Application-defined custom attributes are set at a global (location-independent) level.
     * Custom attribute values are intended to store additional information about a catalog object
     * or associations with an entity in another system. Do not use custom attributes
     * to store any sensitive information (personally identifiable information, card details, etc.).
     *
     * @return array<string,CatalogCustomAttributeValue>|null
     */
    public function getCustomAttributeValues(): ?array
    {
        if (count($this->customAttributeValues) == 0) {
            return null;
        }
        return $this->customAttributeValues['value'];
    }

    /**
     * Sets Custom Attribute Values.
     * A map (key-value pairs) of application-defined custom attribute values. The value of a key-value
     * pair
     * is a [CatalogCustomAttributeValue](entity:CatalogCustomAttributeValue) object. The key is the `key`
     * attribute
     * value defined in the associated [CatalogCustomAttributeDefinition](entity:
     * CatalogCustomAttributeDefinition)
     * object defined by the application making the request.
     *
     * If the `CatalogCustomAttributeDefinition` object is
     * defined by another application, the `CatalogCustomAttributeDefinition`'s key attribute value is
     * prefixed by
     * the defining application ID. For example, if the `CatalogCustomAttributeDefinition` has a `key`
     * attribute of
     * `"cocoa_brand"` and the defining application ID is `"abcd1234"`, the key in the map is `"abcd1234:
     * cocoa_brand"`
     * if the application making the request is different from the application defining the custom
     * attribute definition.
     * Otherwise, the key used in the map is simply `"cocoa_brand"`.
     *
     * Application-defined custom attributes are set at a global (location-independent) level.
     * Custom attribute values are intended to store additional information about a catalog object
     * or associations with an entity in another system. Do not use custom attributes
     * to store any sensitive information (personally identifiable information, card details, etc.).
     *
     * @maps custom_attribute_values
     *
     * @param array<string,CatalogCustomAttributeValue>|null $customAttributeValues
     */
    public function setCustomAttributeValues(?array $customAttributeValues): void
    {
        $this->customAttributeValues['value'] = $customAttributeValues;
    }

    /**
     * Unsets Custom Attribute Values.
     * A map (key-value pairs) of application-defined custom attribute values. The value of a key-value
     * pair
     * is a [CatalogCustomAttributeValue](entity:CatalogCustomAttributeValue) object. The key is the `key`
     * attribute
     * value defined in the associated [CatalogCustomAttributeDefinition](entity:
     * CatalogCustomAttributeDefinition)
     * object defined by the application making the request.
     *
     * If the `CatalogCustomAttributeDefinition` object is
     * defined by another application, the `CatalogCustomAttributeDefinition`'s key attribute value is
     * prefixed by
     * the defining application ID. For example, if the `CatalogCustomAttributeDefinition` has a `key`
     * attribute of
     * `"cocoa_brand"` and the defining application ID is `"abcd1234"`, the key in the map is `"abcd1234:
     * cocoa_brand"`
     * if the application making the request is different from the application defining the custom
     * attribute definition.
     * Otherwise, the key used in the map is simply `"cocoa_brand"`.
     *
     * Application-defined custom attributes are set at a global (location-independent) level.
     * Custom attribute values are intended to store additional information about a catalog object
     * or associations with an entity in another system. Do not use custom attributes
     * to store any sensitive information (personally identifiable information, card details, etc.).
     */
    public function unsetCustomAttributeValues(): void
    {
        $this->customAttributeValues = [];
    }

    /**
     * Returns Catalog V1 Ids.
     * The Connect v1 IDs for this object at each location where it is present, where they
     * differ from the object's Connect V2 ID. The field will only be present for objects that
     * have been created or modified by legacy APIs.
     *
     * @return CatalogV1Id[]|null
     */
    public function getCatalogV1Ids(): ?array
    {
        if (count($this->catalogV1Ids) == 0) {
            return null;
        }
        return $this->catalogV1Ids['value'];
    }

    /**
     * Sets Catalog V1 Ids.
     * The Connect v1 IDs for this object at each location where it is present, where they
     * differ from the object's Connect V2 ID. The field will only be present for objects that
     * have been created or modified by legacy APIs.
     *
     * @maps catalog_v1_ids
     *
     * @param CatalogV1Id[]|null $catalogV1Ids
     */
    public function setCatalogV1Ids(?array $catalogV1Ids): void
    {
        $this->catalogV1Ids['value'] = $catalogV1Ids;
    }

    /**
     * Unsets Catalog V1 Ids.
     * The Connect v1 IDs for this object at each location where it is present, where they
     * differ from the object's Connect V2 ID. The field will only be present for objects that
     * have been created or modified by legacy APIs.
     */
    public function unsetCatalogV1Ids(): void
    {
        $this->catalogV1Ids = [];
    }

    /**
     * Returns Present at All Locations.
     * If `true`, this object is present at all locations (including future locations), except where
     * specified in
     * the `absent_at_location_ids` field. If `false`, this object is not present at any locations
     * (including future locations),
     * except where specified in the `present_at_location_ids` field. If not specified, defaults to `true`.
     */
    public function getPresentAtAllLocations(): ?bool
    {
        if (count($this->presentAtAllLocations) == 0) {
            return null;
        }
        return $this->presentAtAllLocations['value'];
    }

    /**
     * Sets Present at All Locations.
     * If `true`, this object is present at all locations (including future locations), except where
     * specified in
     * the `absent_at_location_ids` field. If `false`, this object is not present at any locations
     * (including future locations),
     * except where specified in the `present_at_location_ids` field. If not specified, defaults to `true`.
     *
     * @maps present_at_all_locations
     */
    public function setPresentAtAllLocations(?bool $presentAtAllLocations): void
    {
        $this->presentAtAllLocations['value'] = $presentAtAllLocations;
    }

    /**
     * Unsets Present at All Locations.
     * If `true`, this object is present at all locations (including future locations), except where
     * specified in
     * the `absent_at_location_ids` field. If `false`, this object is not present at any locations
     * (including future locations),
     * except where specified in the `present_at_location_ids` field. If not specified, defaults to `true`.
     */
    public function unsetPresentAtAllLocations(): void
    {
        $this->presentAtAllLocations = [];
    }

    /**
     * Returns Present at Location Ids.
     * A list of locations where the object is present, even if `present_at_all_locations` is `false`.
     * This can include locations that are deactivated.
     *
     * @return string[]|null
     */
    public function getPresentAtLocationIds(): ?array
    {
        if (count($this->presentAtLocationIds) == 0) {
            return null;
        }
        return $this->presentAtLocationIds['value'];
    }

    /**
     * Sets Present at Location Ids.
     * A list of locations where the object is present, even if `present_at_all_locations` is `false`.
     * This can include locations that are deactivated.
     *
     * @maps present_at_location_ids
     *
     * @param string[]|null $presentAtLocationIds
     */
    public function setPresentAtLocationIds(?array $presentAtLocationIds): void
    {
        $this->presentAtLocationIds['value'] = $presentAtLocationIds;
    }

    /**
     * Unsets Present at Location Ids.
     * A list of locations where the object is present, even if `present_at_all_locations` is `false`.
     * This can include locations that are deactivated.
     */
    public function unsetPresentAtLocationIds(): void
    {
        $this->presentAtLocationIds = [];
    }

    /**
     * Returns Absent at Location Ids.
     * A list of locations where the object is not present, even if `present_at_all_locations` is `true`.
     * This can include locations that are deactivated.
     *
     * @return string[]|null
     */
    public function getAbsentAtLocationIds(): ?array
    {
        if (count($this->absentAtLocationIds) == 0) {
            return null;
        }
        return $this->absentAtLocationIds['value'];
    }

    /**
     * Sets Absent at Location Ids.
     * A list of locations where the object is not present, even if `present_at_all_locations` is `true`.
     * This can include locations that are deactivated.
     *
     * @maps absent_at_location_ids
     *
     * @param string[]|null $absentAtLocationIds
     */
    public function setAbsentAtLocationIds(?array $absentAtLocationIds): void
    {
        $this->absentAtLocationIds['value'] = $absentAtLocationIds;
    }

    /**
     * Unsets Absent at Location Ids.
     * A list of locations where the object is not present, even if `present_at_all_locations` is `true`.
     * This can include locations that are deactivated.
     */
    public function unsetAbsentAtLocationIds(): void
    {
        $this->absentAtLocationIds = [];
    }

    /**
     * Returns Item Data.
     * A [CatalogObject]($m/CatalogObject) instance of the `ITEM` type, also referred to as an item, in the
     * catalog.
     */
    public function getItemData(): ?CatalogItem
    {
        return $this->itemData;
    }

    /**
     * Sets Item Data.
     * A [CatalogObject]($m/CatalogObject) instance of the `ITEM` type, also referred to as an item, in the
     * catalog.
     *
     * @maps item_data
     */
    public function setItemData(?CatalogItem $itemData): void
    {
        $this->itemData = $itemData;
    }

    /**
     * Returns Category Data.
     * A category to which a `CatalogItem` instance belongs.
     */
    public function getCategoryData(): ?CatalogCategory
    {
        return $this->categoryData;
    }

    /**
     * Sets Category Data.
     * A category to which a `CatalogItem` instance belongs.
     *
     * @maps category_data
     */
    public function setCategoryData(?CatalogCategory $categoryData): void
    {
        $this->categoryData = $categoryData;
    }

    /**
     * Returns Item Variation Data.
     * An item variation, representing a product for sale, in the Catalog object model. Each
     * [item]($m/CatalogItem) must have at least one
     * item variation and can have at most 250 item variations.
     *
     * An item variation can be sellable, stockable, or both if it has a unit of measure for its count for
     * the sold number of the variation, the stocked
     * number of the variation, or both. For example, when a variation representing wine is stocked and
     * sold by the bottle, the variation is both
     * stockable and sellable. But when a variation of the wine is sold by the glass, the sold units cannot
     * be used as a measure of the stocked units. This by-the-glass
     * variation is sellable, but not stockable. To accurately keep track of the wine's inventory count at
     * any time, the sellable count must be
     * converted to stockable count. Typically, the seller defines this unit conversion. For example, 1
     * bottle equals 5 glasses. The Square API exposes
     * the `stockable_conversion` property on the variation to specify the conversion. Thus, when two
     * glasses of the wine are sold, the sellable count
     * decreases by 2, and the stockable count automatically decreases by 0.4 bottle according to the
     * conversion.
     */
    public function getItemVariationData(): ?CatalogItemVariation
    {
        return $this->itemVariationData;
    }

    /**
     * Sets Item Variation Data.
     * An item variation, representing a product for sale, in the Catalog object model. Each
     * [item]($m/CatalogItem) must have at least one
     * item variation and can have at most 250 item variations.
     *
     * An item variation can be sellable, stockable, or both if it has a unit of measure for its count for
     * the sold number of the variation, the stocked
     * number of the variation, or both. For example, when a variation representing wine is stocked and
     * sold by the bottle, the variation is both
     * stockable and sellable. But when a variation of the wine is sold by the glass, the sold units cannot
     * be used as a measure of the stocked units. This by-the-glass
     * variation is sellable, but not stockable. To accurately keep track of the wine's inventory count at
     * any time, the sellable count must be
     * converted to stockable count. Typically, the seller defines this unit conversion. For example, 1
     * bottle equals 5 glasses. The Square API exposes
     * the `stockable_conversion` property on the variation to specify the conversion. Thus, when two
     * glasses of the wine are sold, the sellable count
     * decreases by 2, and the stockable count automatically decreases by 0.4 bottle according to the
     * conversion.
     *
     * @maps item_variation_data
     */
    public function setItemVariationData(?CatalogItemVariation $itemVariationData): void
    {
        $this->itemVariationData = $itemVariationData;
    }

    /**
     * Returns Tax Data.
     * A tax applicable to an item.
     */
    public function getTaxData(): ?CatalogTax
    {
        return $this->taxData;
    }

    /**
     * Sets Tax Data.
     * A tax applicable to an item.
     *
     * @maps tax_data
     */
    public function setTaxData(?CatalogTax $taxData): void
    {
        $this->taxData = $taxData;
    }

    /**
     * Returns Discount Data.
     * A discount applicable to items.
     */
    public function getDiscountData(): ?CatalogDiscount
    {
        return $this->discountData;
    }

    /**
     * Sets Discount Data.
     * A discount applicable to items.
     *
     * @maps discount_data
     */
    public function setDiscountData(?CatalogDiscount $discountData): void
    {
        $this->discountData = $discountData;
    }

    /**
     * Returns Modifier List Data.
     * A list of modifiers applicable to items at the time of sale.
     *
     * For example, a "Condiments" modifier list applicable to a "Hot Dog" item
     * may contain "Ketchup", "Mustard", and "Relish" modifiers.
     * Use the `selection_type` field to specify whether or not multiple selections from
     * the modifier list are allowed.
     */
    public function getModifierListData(): ?CatalogModifierList
    {
        return $this->modifierListData;
    }

    /**
     * Sets Modifier List Data.
     * A list of modifiers applicable to items at the time of sale.
     *
     * For example, a "Condiments" modifier list applicable to a "Hot Dog" item
     * may contain "Ketchup", "Mustard", and "Relish" modifiers.
     * Use the `selection_type` field to specify whether or not multiple selections from
     * the modifier list are allowed.
     *
     * @maps modifier_list_data
     */
    public function setModifierListData(?CatalogModifierList $modifierListData): void
    {
        $this->modifierListData = $modifierListData;
    }

    /**
     * Returns Modifier Data.
     * A modifier applicable to items at the time of sale.
     */
    public function getModifierData(): ?CatalogModifier
    {
        return $this->modifierData;
    }

    /**
     * Sets Modifier Data.
     * A modifier applicable to items at the time of sale.
     *
     * @maps modifier_data
     */
    public function setModifierData(?CatalogModifier $modifierData): void
    {
        $this->modifierData = $modifierData;
    }

    /**
     * Returns Time Period Data.
     * Represents a time period - either a single period or a repeating period.
     */
    public function getTimePeriodData(): ?CatalogTimePeriod
    {
        return $this->timePeriodData;
    }

    /**
     * Sets Time Period Data.
     * Represents a time period - either a single period or a repeating period.
     *
     * @maps time_period_data
     */
    public function setTimePeriodData(?CatalogTimePeriod $timePeriodData): void
    {
        $this->timePeriodData = $timePeriodData;
    }

    /**
     * Returns Product Set Data.
     * Represents a collection of catalog objects for the purpose of applying a
     * `PricingRule`. Including a catalog object will include all of its subtypes.
     * For example, including a category in a product set will include all of its
     * items and associated item variations in the product set. Including an item in
     * a product set will also include its item variations.
     */
    public function getProductSetData(): ?CatalogProductSet
    {
        return $this->productSetData;
    }

    /**
     * Sets Product Set Data.
     * Represents a collection of catalog objects for the purpose of applying a
     * `PricingRule`. Including a catalog object will include all of its subtypes.
     * For example, including a category in a product set will include all of its
     * items and associated item variations in the product set. Including an item in
     * a product set will also include its item variations.
     *
     * @maps product_set_data
     */
    public function setProductSetData(?CatalogProductSet $productSetData): void
    {
        $this->productSetData = $productSetData;
    }

    /**
     * Returns Pricing Rule Data.
     * Defines how discounts are automatically applied to a set of items that match the pricing rule
     * during the active time period.
     */
    public function getPricingRuleData(): ?CatalogPricingRule
    {
        return $this->pricingRuleData;
    }

    /**
     * Sets Pricing Rule Data.
     * Defines how discounts are automatically applied to a set of items that match the pricing rule
     * during the active time period.
     *
     * @maps pricing_rule_data
     */
    public function setPricingRuleData(?CatalogPricingRule $pricingRuleData): void
    {
        $this->pricingRuleData = $pricingRuleData;
    }

    /**
     * Returns Image Data.
     * An image file to use in Square catalogs. It can be associated with
     * `CatalogItem`, `CatalogItemVariation`, `CatalogCategory`, and `CatalogModifierList` objects.
     * Only the images on items and item variations are exposed in Dashboard.
     * Only the first image on an item is displayed in Square Point of Sale (SPOS).
     * Images on items and variations are displayed through Square Online Store.
     * Images on other object types are for use by 3rd party application developers.
     */
    public function getImageData(): ?CatalogImage
    {
        return $this->imageData;
    }

    /**
     * Sets Image Data.
     * An image file to use in Square catalogs. It can be associated with
     * `CatalogItem`, `CatalogItemVariation`, `CatalogCategory`, and `CatalogModifierList` objects.
     * Only the images on items and item variations are exposed in Dashboard.
     * Only the first image on an item is displayed in Square Point of Sale (SPOS).
     * Images on items and variations are displayed through Square Online Store.
     * Images on other object types are for use by 3rd party application developers.
     *
     * @maps image_data
     */
    public function setImageData(?CatalogImage $imageData): void
    {
        $this->imageData = $imageData;
    }

    /**
     * Returns Measurement Unit Data.
     * Represents the unit used to measure a `CatalogItemVariation` and
     * specifies the precision for decimal quantities.
     */
    public function getMeasurementUnitData(): ?CatalogMeasurementUnit
    {
        return $this->measurementUnitData;
    }

    /**
     * Sets Measurement Unit Data.
     * Represents the unit used to measure a `CatalogItemVariation` and
     * specifies the precision for decimal quantities.
     *
     * @maps measurement_unit_data
     */
    public function setMeasurementUnitData(?CatalogMeasurementUnit $measurementUnitData): void
    {
        $this->measurementUnitData = $measurementUnitData;
    }

    /**
     * Returns Subscription Plan Data.
     * Describes a subscription plan. For more information, see
     * [Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-
     * plan).
     */
    public function getSubscriptionPlanData(): ?CatalogSubscriptionPlan
    {
        return $this->subscriptionPlanData;
    }

    /**
     * Sets Subscription Plan Data.
     * Describes a subscription plan. For more information, see
     * [Set Up and Manage a Subscription Plan](https://developer.squareup.com/docs/subscriptions-api/setup-
     * plan).
     *
     * @maps subscription_plan_data
     */
    public function setSubscriptionPlanData(?CatalogSubscriptionPlan $subscriptionPlanData): void
    {
        $this->subscriptionPlanData = $subscriptionPlanData;
    }

    /**
     * Returns Item Option Data.
     * A group of variations for a `CatalogItem`.
     */
    public function getItemOptionData(): ?CatalogItemOption
    {
        return $this->itemOptionData;
    }

    /**
     * Sets Item Option Data.
     * A group of variations for a `CatalogItem`.
     *
     * @maps item_option_data
     */
    public function setItemOptionData(?CatalogItemOption $itemOptionData): void
    {
        $this->itemOptionData = $itemOptionData;
    }

    /**
     * Returns Item Option Value Data.
     * An enumerated value that can link a
     * `CatalogItemVariation` to an item option as one of
     * its item option values.
     */
    public function getItemOptionValueData(): ?CatalogItemOptionValue
    {
        return $this->itemOptionValueData;
    }

    /**
     * Sets Item Option Value Data.
     * An enumerated value that can link a
     * `CatalogItemVariation` to an item option as one of
     * its item option values.
     *
     * @maps item_option_value_data
     */
    public function setItemOptionValueData(?CatalogItemOptionValue $itemOptionValueData): void
    {
        $this->itemOptionValueData = $itemOptionValueData;
    }

    /**
     * Returns Custom Attribute Definition Data.
     * Contains information defining a custom attribute. Custom attributes are
     * intended to store additional information about a catalog object or to associate a
     * catalog object with an entity in another system. Do not use custom attributes
     * to store any sensitive information (personally identifiable information, card details, etc.).
     * [Read more about custom attributes](https://developer.squareup.com/docs/catalog-api/add-custom-
     * attributes)
     */
    public function getCustomAttributeDefinitionData(): ?CatalogCustomAttributeDefinition
    {
        return $this->customAttributeDefinitionData;
    }

    /**
     * Sets Custom Attribute Definition Data.
     * Contains information defining a custom attribute. Custom attributes are
     * intended to store additional information about a catalog object or to associate a
     * catalog object with an entity in another system. Do not use custom attributes
     * to store any sensitive information (personally identifiable information, card details, etc.).
     * [Read more about custom attributes](https://developer.squareup.com/docs/catalog-api/add-custom-
     * attributes)
     *
     * @maps custom_attribute_definition_data
     */
    public function setCustomAttributeDefinitionData(
        ?CatalogCustomAttributeDefinition $customAttributeDefinitionData
    ): void {
        $this->customAttributeDefinitionData = $customAttributeDefinitionData;
    }

    /**
     * Returns Quick Amounts Settings Data.
     * A parent Catalog Object model represents a set of Quick Amounts and the settings control the amounts.
     */
    public function getQuickAmountsSettingsData(): ?CatalogQuickAmountsSettings
    {
        return $this->quickAmountsSettingsData;
    }

    /**
     * Sets Quick Amounts Settings Data.
     * A parent Catalog Object model represents a set of Quick Amounts and the settings control the amounts.
     *
     * @maps quick_amounts_settings_data
     */
    public function setQuickAmountsSettingsData(?CatalogQuickAmountsSettings $quickAmountsSettingsData): void
    {
        $this->quickAmountsSettingsData = $quickAmountsSettingsData;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        $json['type']                                 = $this->type;
        $json['id']                                   = $this->id;
        if (isset($this->updatedAt)) {
            $json['updated_at']                       = $this->updatedAt;
        }
        if (isset($this->version)) {
            $json['version']                          = $this->version;
        }
        if (!empty($this->isDeleted)) {
            $json['is_deleted']                       = $this->isDeleted['value'];
        }
        if (!empty($this->customAttributeValues)) {
            $json['custom_attribute_values']          = $this->customAttributeValues['value'];
        }
        if (!empty($this->catalogV1Ids)) {
            $json['catalog_v1_ids']                   = $this->catalogV1Ids['value'];
        }
        if (!empty($this->presentAtAllLocations)) {
            $json['present_at_all_locations']         = $this->presentAtAllLocations['value'];
        }
        if (!empty($this->presentAtLocationIds)) {
            $json['present_at_location_ids']          = $this->presentAtLocationIds['value'];
        }
        if (!empty($this->absentAtLocationIds)) {
            $json['absent_at_location_ids']           = $this->absentAtLocationIds['value'];
        }
        if (isset($this->itemData)) {
            $json['item_data']                        = $this->itemData;
        }
        if (isset($this->categoryData)) {
            $json['category_data']                    = $this->categoryData;
        }
        if (isset($this->itemVariationData)) {
            $json['item_variation_data']              = $this->itemVariationData;
        }
        if (isset($this->taxData)) {
            $json['tax_data']                         = $this->taxData;
        }
        if (isset($this->discountData)) {
            $json['discount_data']                    = $this->discountData;
        }
        if (isset($this->modifierListData)) {
            $json['modifier_list_data']               = $this->modifierListData;
        }
        if (isset($this->modifierData)) {
            $json['modifier_data']                    = $this->modifierData;
        }
        if (isset($this->timePeriodData)) {
            $json['time_period_data']                 = $this->timePeriodData;
        }
        if (isset($this->productSetData)) {
            $json['product_set_data']                 = $this->productSetData;
        }
        if (isset($this->pricingRuleData)) {
            $json['pricing_rule_data']                = $this->pricingRuleData;
        }
        if (isset($this->imageData)) {
            $json['image_data']                       = $this->imageData;
        }
        if (isset($this->measurementUnitData)) {
            $json['measurement_unit_data']            = $this->measurementUnitData;
        }
        if (isset($this->subscriptionPlanData)) {
            $json['subscription_plan_data']           = $this->subscriptionPlanData;
        }
        if (isset($this->itemOptionData)) {
            $json['item_option_data']                 = $this->itemOptionData;
        }
        if (isset($this->itemOptionValueData)) {
            $json['item_option_value_data']           = $this->itemOptionValueData;
        }
        if (isset($this->customAttributeDefinitionData)) {
            $json['custom_attribute_definition_data'] = $this->customAttributeDefinitionData;
        }
        if (isset($this->quickAmountsSettingsData)) {
            $json['quick_amounts_settings_data']      = $this->quickAmountsSettingsData;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
