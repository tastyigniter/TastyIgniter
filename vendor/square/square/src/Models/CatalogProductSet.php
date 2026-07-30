<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a collection of catalog objects for the purpose of applying a
 * `PricingRule`. Including a catalog object will include all of its subtypes.
 * For example, including a category in a product set will include all of its
 * items and associated item variations in the product set. Including an item in
 * a product set will also include its item variations.
 */
class CatalogProductSet implements \JsonSerializable
{
    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $productIdsAny = [];

    /**
     * @var array
     */
    private $productIdsAll = [];

    /**
     * @var array
     */
    private $quantityExact = [];

    /**
     * @var array
     */
    private $quantityMin = [];

    /**
     * @var array
     */
    private $quantityMax = [];

    /**
     * @var array
     */
    private $allProducts = [];

    /**
     * Returns Name.
     * User-defined name for the product set. For example, "Clearance Items"
     * or "Winter Sale Items".
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * User-defined name for the product set. For example, "Clearance Items"
     * or "Winter Sale Items".
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * User-defined name for the product set. For example, "Clearance Items"
     * or "Winter Sale Items".
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Product Ids Any.
     * Unique IDs for any `CatalogObject` included in this product set. Any
     * number of these catalog objects can be in an order for a pricing rule to apply.
     *
     * This can be used with `product_ids_all` in a parent `CatalogProductSet` to
     * match groups of products for a bulk discount, such as a discount for an
     * entree and side combo.
     *
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     *
     * Max: 500 catalog object IDs.
     *
     * @return string[]|null
     */
    public function getProductIdsAny(): ?array
    {
        if (count($this->productIdsAny) == 0) {
            return null;
        }
        return $this->productIdsAny['value'];
    }

    /**
     * Sets Product Ids Any.
     * Unique IDs for any `CatalogObject` included in this product set. Any
     * number of these catalog objects can be in an order for a pricing rule to apply.
     *
     * This can be used with `product_ids_all` in a parent `CatalogProductSet` to
     * match groups of products for a bulk discount, such as a discount for an
     * entree and side combo.
     *
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     *
     * Max: 500 catalog object IDs.
     *
     * @maps product_ids_any
     *
     * @param string[]|null $productIdsAny
     */
    public function setProductIdsAny(?array $productIdsAny): void
    {
        $this->productIdsAny['value'] = $productIdsAny;
    }

    /**
     * Unsets Product Ids Any.
     * Unique IDs for any `CatalogObject` included in this product set. Any
     * number of these catalog objects can be in an order for a pricing rule to apply.
     *
     * This can be used with `product_ids_all` in a parent `CatalogProductSet` to
     * match groups of products for a bulk discount, such as a discount for an
     * entree and side combo.
     *
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     *
     * Max: 500 catalog object IDs.
     */
    public function unsetProductIdsAny(): void
    {
        $this->productIdsAny = [];
    }

    /**
     * Returns Product Ids All.
     * Unique IDs for any `CatalogObject` included in this product set.
     * All objects in this set must be included in an order for a pricing rule to apply.
     *
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     *
     * Max: 500 catalog object IDs.
     *
     * @return string[]|null
     */
    public function getProductIdsAll(): ?array
    {
        if (count($this->productIdsAll) == 0) {
            return null;
        }
        return $this->productIdsAll['value'];
    }

    /**
     * Sets Product Ids All.
     * Unique IDs for any `CatalogObject` included in this product set.
     * All objects in this set must be included in an order for a pricing rule to apply.
     *
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     *
     * Max: 500 catalog object IDs.
     *
     * @maps product_ids_all
     *
     * @param string[]|null $productIdsAll
     */
    public function setProductIdsAll(?array $productIdsAll): void
    {
        $this->productIdsAll['value'] = $productIdsAll;
    }

    /**
     * Unsets Product Ids All.
     * Unique IDs for any `CatalogObject` included in this product set.
     * All objects in this set must be included in an order for a pricing rule to apply.
     *
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     *
     * Max: 500 catalog object IDs.
     */
    public function unsetProductIdsAll(): void
    {
        $this->productIdsAll = [];
    }

    /**
     * Returns Quantity Exact.
     * If set, there must be exactly this many items from `products_any` or `products_all`
     * in the cart for the discount to apply.
     *
     * Cannot be combined with either `quantity_min` or `quantity_max`.
     */
    public function getQuantityExact(): ?int
    {
        if (count($this->quantityExact) == 0) {
            return null;
        }
        return $this->quantityExact['value'];
    }

    /**
     * Sets Quantity Exact.
     * If set, there must be exactly this many items from `products_any` or `products_all`
     * in the cart for the discount to apply.
     *
     * Cannot be combined with either `quantity_min` or `quantity_max`.
     *
     * @maps quantity_exact
     */
    public function setQuantityExact(?int $quantityExact): void
    {
        $this->quantityExact['value'] = $quantityExact;
    }

    /**
     * Unsets Quantity Exact.
     * If set, there must be exactly this many items from `products_any` or `products_all`
     * in the cart for the discount to apply.
     *
     * Cannot be combined with either `quantity_min` or `quantity_max`.
     */
    public function unsetQuantityExact(): void
    {
        $this->quantityExact = [];
    }

    /**
     * Returns Quantity Min.
     * If set, there must be at least this many items from `products_any` or `products_all`
     * in a cart for the discount to apply. See `quantity_exact`. Defaults to 0 if
     * `quantity_exact`, `quantity_min` and `quantity_max` are all unspecified.
     */
    public function getQuantityMin(): ?int
    {
        if (count($this->quantityMin) == 0) {
            return null;
        }
        return $this->quantityMin['value'];
    }

    /**
     * Sets Quantity Min.
     * If set, there must be at least this many items from `products_any` or `products_all`
     * in a cart for the discount to apply. See `quantity_exact`. Defaults to 0 if
     * `quantity_exact`, `quantity_min` and `quantity_max` are all unspecified.
     *
     * @maps quantity_min
     */
    public function setQuantityMin(?int $quantityMin): void
    {
        $this->quantityMin['value'] = $quantityMin;
    }

    /**
     * Unsets Quantity Min.
     * If set, there must be at least this many items from `products_any` or `products_all`
     * in a cart for the discount to apply. See `quantity_exact`. Defaults to 0 if
     * `quantity_exact`, `quantity_min` and `quantity_max` are all unspecified.
     */
    public function unsetQuantityMin(): void
    {
        $this->quantityMin = [];
    }

    /**
     * Returns Quantity Max.
     * If set, the pricing rule will apply to a maximum of this many items from
     * `products_any` or `products_all`.
     */
    public function getQuantityMax(): ?int
    {
        if (count($this->quantityMax) == 0) {
            return null;
        }
        return $this->quantityMax['value'];
    }

    /**
     * Sets Quantity Max.
     * If set, the pricing rule will apply to a maximum of this many items from
     * `products_any` or `products_all`.
     *
     * @maps quantity_max
     */
    public function setQuantityMax(?int $quantityMax): void
    {
        $this->quantityMax['value'] = $quantityMax;
    }

    /**
     * Unsets Quantity Max.
     * If set, the pricing rule will apply to a maximum of this many items from
     * `products_any` or `products_all`.
     */
    public function unsetQuantityMax(): void
    {
        $this->quantityMax = [];
    }

    /**
     * Returns All Products.
     * If set to `true`, the product set will include every item in the catalog.
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     */
    public function getAllProducts(): ?bool
    {
        if (count($this->allProducts) == 0) {
            return null;
        }
        return $this->allProducts['value'];
    }

    /**
     * Sets All Products.
     * If set to `true`, the product set will include every item in the catalog.
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     *
     * @maps all_products
     */
    public function setAllProducts(?bool $allProducts): void
    {
        $this->allProducts['value'] = $allProducts;
    }

    /**
     * Unsets All Products.
     * If set to `true`, the product set will include every item in the catalog.
     * Only one of `product_ids_all`, `product_ids_any`, or `all_products` can be set.
     */
    public function unsetAllProducts(): void
    {
        $this->allProducts = [];
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
        if (!empty($this->name)) {
            $json['name']            = $this->name['value'];
        }
        if (!empty($this->productIdsAny)) {
            $json['product_ids_any'] = $this->productIdsAny['value'];
        }
        if (!empty($this->productIdsAll)) {
            $json['product_ids_all'] = $this->productIdsAll['value'];
        }
        if (!empty($this->quantityExact)) {
            $json['quantity_exact']  = $this->quantityExact['value'];
        }
        if (!empty($this->quantityMin)) {
            $json['quantity_min']    = $this->quantityMin['value'];
        }
        if (!empty($this->quantityMax)) {
            $json['quantity_max']    = $this->quantityMax['value'];
        }
        if (!empty($this->allProducts)) {
            $json['all_products']    = $this->allProducts['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
