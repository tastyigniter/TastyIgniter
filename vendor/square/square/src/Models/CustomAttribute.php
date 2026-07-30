<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A custom attribute value. Each custom attribute value has a corresponding
 * `CustomAttributeDefinition` object.
 */
class CustomAttribute implements \JsonSerializable
{
    /**
     * @var array
     */
    private $key = [];

    /**
     * @var array
     */
    private $value = [];

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var string|null
     */
    private $visibility;

    /**
     * @var CustomAttributeDefinition|null
     */
    private $definition;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * Returns Key.
     * The identifier
     * of the custom attribute definition and its corresponding custom attributes. This value
     * can be a simple key, which is the key that is provided when the custom attribute definition
     * is created, or a qualified key, if the requesting
     * application is not the definition owner. The qualified key consists of the application ID
     * of the custom attribute definition owner
     * followed by the simple key that was provided when the definition was created. It has the
     * format application_id:simple key.
     *
     * The value for a simple key can contain up to 60 alphanumeric characters, periods (.),
     * underscores (_), and hyphens (-).
     */
    public function getKey(): ?string
    {
        if (count($this->key) == 0) {
            return null;
        }
        return $this->key['value'];
    }

    /**
     * Sets Key.
     * The identifier
     * of the custom attribute definition and its corresponding custom attributes. This value
     * can be a simple key, which is the key that is provided when the custom attribute definition
     * is created, or a qualified key, if the requesting
     * application is not the definition owner. The qualified key consists of the application ID
     * of the custom attribute definition owner
     * followed by the simple key that was provided when the definition was created. It has the
     * format application_id:simple key.
     *
     * The value for a simple key can contain up to 60 alphanumeric characters, periods (.),
     * underscores (_), and hyphens (-).
     *
     * @maps key
     */
    public function setKey(?string $key): void
    {
        $this->key['value'] = $key;
    }

    /**
     * Unsets Key.
     * The identifier
     * of the custom attribute definition and its corresponding custom attributes. This value
     * can be a simple key, which is the key that is provided when the custom attribute definition
     * is created, or a qualified key, if the requesting
     * application is not the definition owner. The qualified key consists of the application ID
     * of the custom attribute definition owner
     * followed by the simple key that was provided when the definition was created. It has the
     * format application_id:simple key.
     *
     * The value for a simple key can contain up to 60 alphanumeric characters, periods (.),
     * underscores (_), and hyphens (-).
     */
    public function unsetKey(): void
    {
        $this->key = [];
    }

    /**
     * Returns Value.
     * The value assigned to the custom attribute. It is validated against the custom
     * attribute definition's schema on write operations. For more information about custom
     * attribute values,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview).
     *
     * @return mixed
     */
    public function getValue()
    {
        if (count($this->value) == 0) {
            return null;
        }
        return $this->value['value'];
    }

    /**
     * Sets Value.
     * The value assigned to the custom attribute. It is validated against the custom
     * attribute definition's schema on write operations. For more information about custom
     * attribute values,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview).
     *
     * @maps value
     *
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value['value'] = $value;
    }

    /**
     * Unsets Value.
     * The value assigned to the custom attribute. It is validated against the custom
     * attribute definition's schema on write operations. For more information about custom
     * attribute values,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview).
     */
    public function unsetValue(): void
    {
        $this->value = [];
    }

    /**
     * Returns Version.
     * Read only. The current version of the custom attribute. This field is incremented when the custom
     * attribute is changed.
     * When updating an existing custom attribute value, you can provide this field
     * and specify the current version of the custom attribute to enable
     * [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/optimistic-concurrency).
     * This field can also be used to enforce strong consistency for reads. For more information about
     * strong consistency for reads,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview).
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * Read only. The current version of the custom attribute. This field is incremented when the custom
     * attribute is changed.
     * When updating an existing custom attribute value, you can provide this field
     * and specify the current version of the custom attribute to enable
     * [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/optimistic-concurrency).
     * This field can also be used to enforce strong consistency for reads. For more information about
     * strong consistency for reads,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview).
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Visibility.
     * The level of permission that a seller or other applications requires to
     * view this custom attribute definition.
     * The `Visibility` field controls who can read and write the custom attribute values
     * and custom attribute definition.
     */
    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    /**
     * Sets Visibility.
     * The level of permission that a seller or other applications requires to
     * view this custom attribute definition.
     * The `Visibility` field controls who can read and write the custom attribute values
     * and custom attribute definition.
     *
     * @maps visibility
     */
    public function setVisibility(?string $visibility): void
    {
        $this->visibility = $visibility;
    }

    /**
     * Returns Definition.
     * Represents a definition for custom attribute values. A custom attribute definition
     * specifies the key, visibility, schema, and other properties for a custom attribute.
     */
    public function getDefinition(): ?CustomAttributeDefinition
    {
        return $this->definition;
    }

    /**
     * Sets Definition.
     * Represents a definition for custom attribute values. A custom attribute definition
     * specifies the key, visibility, schema, and other properties for a custom attribute.
     *
     * @maps definition
     */
    public function setDefinition(?CustomAttributeDefinition $definition): void
    {
        $this->definition = $definition;
    }

    /**
     * Returns Updated At.
     * The timestamp that indicates when the custom attribute was created or was most recently
     * updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp that indicates when the custom attribute was created or was most recently
     * updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Created At.
     * The timestamp that indicates when the custom attribute was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp that indicates when the custom attribute was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
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
        if (!empty($this->key)) {
            $json['key']        = $this->key['value'];
        }
        if (!empty($this->value)) {
            $json['value']      = $this->value['value'];
        }
        if (isset($this->version)) {
            $json['version']    = $this->version;
        }
        if (isset($this->visibility)) {
            $json['visibility'] = $this->visibility;
        }
        if (isset($this->definition)) {
            $json['definition'] = $this->definition;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at'] = $this->updatedAt;
        }
        if (isset($this->createdAt)) {
            $json['created_at'] = $this->createdAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
