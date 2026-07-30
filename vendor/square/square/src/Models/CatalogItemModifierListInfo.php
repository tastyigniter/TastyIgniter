<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Options to control the properties of a `CatalogModifierList` applied to a `CatalogItem` instance.
 */
class CatalogItemModifierListInfo implements \JsonSerializable
{
    /**
     * @var string
     */
    private $modifierListId;

    /**
     * @var array
     */
    private $modifierOverrides = [];

    /**
     * @var array
     */
    private $minSelectedModifiers = [];

    /**
     * @var array
     */
    private $maxSelectedModifiers = [];

    /**
     * @var array
     */
    private $enabled = [];

    /**
     * @param string $modifierListId
     */
    public function __construct(string $modifierListId)
    {
        $this->modifierListId = $modifierListId;
    }

    /**
     * Returns Modifier List Id.
     * The ID of the `CatalogModifierList` controlled by this `CatalogModifierListInfo`.
     */
    public function getModifierListId(): string
    {
        return $this->modifierListId;
    }

    /**
     * Sets Modifier List Id.
     * The ID of the `CatalogModifierList` controlled by this `CatalogModifierListInfo`.
     *
     * @required
     * @maps modifier_list_id
     */
    public function setModifierListId(string $modifierListId): void
    {
        $this->modifierListId = $modifierListId;
    }

    /**
     * Returns Modifier Overrides.
     * A set of `CatalogModifierOverride` objects that override whether a given `CatalogModifier` is
     * enabled by default.
     *
     * @return CatalogModifierOverride[]|null
     */
    public function getModifierOverrides(): ?array
    {
        if (count($this->modifierOverrides) == 0) {
            return null;
        }
        return $this->modifierOverrides['value'];
    }

    /**
     * Sets Modifier Overrides.
     * A set of `CatalogModifierOverride` objects that override whether a given `CatalogModifier` is
     * enabled by default.
     *
     * @maps modifier_overrides
     *
     * @param CatalogModifierOverride[]|null $modifierOverrides
     */
    public function setModifierOverrides(?array $modifierOverrides): void
    {
        $this->modifierOverrides['value'] = $modifierOverrides;
    }

    /**
     * Unsets Modifier Overrides.
     * A set of `CatalogModifierOverride` objects that override whether a given `CatalogModifier` is
     * enabled by default.
     */
    public function unsetModifierOverrides(): void
    {
        $this->modifierOverrides = [];
    }

    /**
     * Returns Min Selected Modifiers.
     * If 0 or larger, the smallest number of `CatalogModifier`s that must be selected from this
     * `CatalogModifierList`.
     */
    public function getMinSelectedModifiers(): ?int
    {
        if (count($this->minSelectedModifiers) == 0) {
            return null;
        }
        return $this->minSelectedModifiers['value'];
    }

    /**
     * Sets Min Selected Modifiers.
     * If 0 or larger, the smallest number of `CatalogModifier`s that must be selected from this
     * `CatalogModifierList`.
     *
     * @maps min_selected_modifiers
     */
    public function setMinSelectedModifiers(?int $minSelectedModifiers): void
    {
        $this->minSelectedModifiers['value'] = $minSelectedModifiers;
    }

    /**
     * Unsets Min Selected Modifiers.
     * If 0 or larger, the smallest number of `CatalogModifier`s that must be selected from this
     * `CatalogModifierList`.
     */
    public function unsetMinSelectedModifiers(): void
    {
        $this->minSelectedModifiers = [];
    }

    /**
     * Returns Max Selected Modifiers.
     * If 0 or larger, the largest number of `CatalogModifier`s that can be selected from this
     * `CatalogModifierList`.
     */
    public function getMaxSelectedModifiers(): ?int
    {
        if (count($this->maxSelectedModifiers) == 0) {
            return null;
        }
        return $this->maxSelectedModifiers['value'];
    }

    /**
     * Sets Max Selected Modifiers.
     * If 0 or larger, the largest number of `CatalogModifier`s that can be selected from this
     * `CatalogModifierList`.
     *
     * @maps max_selected_modifiers
     */
    public function setMaxSelectedModifiers(?int $maxSelectedModifiers): void
    {
        $this->maxSelectedModifiers['value'] = $maxSelectedModifiers;
    }

    /**
     * Unsets Max Selected Modifiers.
     * If 0 or larger, the largest number of `CatalogModifier`s that can be selected from this
     * `CatalogModifierList`.
     */
    public function unsetMaxSelectedModifiers(): void
    {
        $this->maxSelectedModifiers = [];
    }

    /**
     * Returns Enabled.
     * If `true`, enable this `CatalogModifierList`. The default value is `true`.
     */
    public function getEnabled(): ?bool
    {
        if (count($this->enabled) == 0) {
            return null;
        }
        return $this->enabled['value'];
    }

    /**
     * Sets Enabled.
     * If `true`, enable this `CatalogModifierList`. The default value is `true`.
     *
     * @maps enabled
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->enabled['value'] = $enabled;
    }

    /**
     * Unsets Enabled.
     * If `true`, enable this `CatalogModifierList`. The default value is `true`.
     */
    public function unsetEnabled(): void
    {
        $this->enabled = [];
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
        $json['modifier_list_id']           = $this->modifierListId;
        if (!empty($this->modifierOverrides)) {
            $json['modifier_overrides']     = $this->modifierOverrides['value'];
        }
        if (!empty($this->minSelectedModifiers)) {
            $json['min_selected_modifiers'] = $this->minSelectedModifiers['value'];
        }
        if (!empty($this->maxSelectedModifiers)) {
            $json['max_selected_modifiers'] = $this->maxSelectedModifiers['value'];
        }
        if (!empty($this->enabled)) {
            $json['enabled']                = $this->enabled['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
