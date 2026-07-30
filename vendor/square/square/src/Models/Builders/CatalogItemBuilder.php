<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CatalogItem;

/**
 * Builder for model CatalogItem
 *
 * @see CatalogItem
 */
class CatalogItemBuilder
{
    /**
     * @var CatalogItem
     */
    private $instance;

    private function __construct(CatalogItem $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new catalog item Builder object.
     */
    public static function init(): self
    {
        return new self(new CatalogItem());
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
        return $this;
    }

    /**
     * Sets description field.
     */
    public function description(?string $value): self
    {
        $this->instance->setDescription($value);
        return $this;
    }

    /**
     * Unsets description field.
     */
    public function unsetDescription(): self
    {
        $this->instance->unsetDescription();
        return $this;
    }

    /**
     * Sets abbreviation field.
     */
    public function abbreviation(?string $value): self
    {
        $this->instance->setAbbreviation($value);
        return $this;
    }

    /**
     * Unsets abbreviation field.
     */
    public function unsetAbbreviation(): self
    {
        $this->instance->unsetAbbreviation();
        return $this;
    }

    /**
     * Sets label color field.
     */
    public function labelColor(?string $value): self
    {
        $this->instance->setLabelColor($value);
        return $this;
    }

    /**
     * Unsets label color field.
     */
    public function unsetLabelColor(): self
    {
        $this->instance->unsetLabelColor();
        return $this;
    }

    /**
     * Sets available online field.
     */
    public function availableOnline(?bool $value): self
    {
        $this->instance->setAvailableOnline($value);
        return $this;
    }

    /**
     * Unsets available online field.
     */
    public function unsetAvailableOnline(): self
    {
        $this->instance->unsetAvailableOnline();
        return $this;
    }

    /**
     * Sets available for pickup field.
     */
    public function availableForPickup(?bool $value): self
    {
        $this->instance->setAvailableForPickup($value);
        return $this;
    }

    /**
     * Unsets available for pickup field.
     */
    public function unsetAvailableForPickup(): self
    {
        $this->instance->unsetAvailableForPickup();
        return $this;
    }

    /**
     * Sets available electronically field.
     */
    public function availableElectronically(?bool $value): self
    {
        $this->instance->setAvailableElectronically($value);
        return $this;
    }

    /**
     * Unsets available electronically field.
     */
    public function unsetAvailableElectronically(): self
    {
        $this->instance->unsetAvailableElectronically();
        return $this;
    }

    /**
     * Sets category id field.
     */
    public function categoryId(?string $value): self
    {
        $this->instance->setCategoryId($value);
        return $this;
    }

    /**
     * Unsets category id field.
     */
    public function unsetCategoryId(): self
    {
        $this->instance->unsetCategoryId();
        return $this;
    }

    /**
     * Sets tax ids field.
     */
    public function taxIds(?array $value): self
    {
        $this->instance->setTaxIds($value);
        return $this;
    }

    /**
     * Unsets tax ids field.
     */
    public function unsetTaxIds(): self
    {
        $this->instance->unsetTaxIds();
        return $this;
    }

    /**
     * Sets modifier list info field.
     */
    public function modifierListInfo(?array $value): self
    {
        $this->instance->setModifierListInfo($value);
        return $this;
    }

    /**
     * Unsets modifier list info field.
     */
    public function unsetModifierListInfo(): self
    {
        $this->instance->unsetModifierListInfo();
        return $this;
    }

    /**
     * Sets variations field.
     */
    public function variations(?array $value): self
    {
        $this->instance->setVariations($value);
        return $this;
    }

    /**
     * Unsets variations field.
     */
    public function unsetVariations(): self
    {
        $this->instance->unsetVariations();
        return $this;
    }

    /**
     * Sets product type field.
     */
    public function productType(?string $value): self
    {
        $this->instance->setProductType($value);
        return $this;
    }

    /**
     * Sets skip modifier screen field.
     */
    public function skipModifierScreen(?bool $value): self
    {
        $this->instance->setSkipModifierScreen($value);
        return $this;
    }

    /**
     * Unsets skip modifier screen field.
     */
    public function unsetSkipModifierScreen(): self
    {
        $this->instance->unsetSkipModifierScreen();
        return $this;
    }

    /**
     * Sets item options field.
     */
    public function itemOptions(?array $value): self
    {
        $this->instance->setItemOptions($value);
        return $this;
    }

    /**
     * Unsets item options field.
     */
    public function unsetItemOptions(): self
    {
        $this->instance->unsetItemOptions();
        return $this;
    }

    /**
     * Sets image ids field.
     */
    public function imageIds(?array $value): self
    {
        $this->instance->setImageIds($value);
        return $this;
    }

    /**
     * Unsets image ids field.
     */
    public function unsetImageIds(): self
    {
        $this->instance->unsetImageIds();
        return $this;
    }

    /**
     * Sets sort name field.
     */
    public function sortName(?string $value): self
    {
        $this->instance->setSortName($value);
        return $this;
    }

    /**
     * Unsets sort name field.
     */
    public function unsetSortName(): self
    {
        $this->instance->unsetSortName();
        return $this;
    }

    /**
     * Sets description html field.
     */
    public function descriptionHtml(?string $value): self
    {
        $this->instance->setDescriptionHtml($value);
        return $this;
    }

    /**
     * Unsets description html field.
     */
    public function unsetDescriptionHtml(): self
    {
        $this->instance->unsetDescriptionHtml();
        return $this;
    }

    /**
     * Sets description plaintext field.
     */
    public function descriptionPlaintext(?string $value): self
    {
        $this->instance->setDescriptionPlaintext($value);
        return $this;
    }

    /**
     * Initializes a new catalog item object.
     */
    public function build(): CatalogItem
    {
        return CoreHelper::clone($this->instance);
    }
}
