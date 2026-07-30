<?php

declare(strict_types=1);

namespace Square\Models;

use Square\ApiHelper;
use stdClass;

/**
 * Represents a definition for custom attribute values. A custom attribute definition
 * specifies the key, visibility, schema, and other properties for a custom attribute.
 */
class CustomAttributeDefinition implements \JsonSerializable
{
    /**
     * @var array
     */
    private $key = [];

    /**
     * @var array
     */
    private $schema = [];

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var array
     */
    private $description = [];

    /**
     * @var string|null
     */
    private $visibility;

    /**
     * @var int|null
     */
    private $version;

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
     *
     * This field can not be changed
     * after the custom attribute definition is created. This field is required when creating
     * a definition and must be unique per application, seller, and resource type.
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
     * This field can not be changed
     * after the custom attribute definition is created. This field is required when creating
     * a definition and must be unique per application, seller, and resource type.
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
     *
     * This field can not be changed
     * after the custom attribute definition is created. This field is required when creating
     * a definition and must be unique per application, seller, and resource type.
     */
    public function unsetKey(): void
    {
        $this->key = [];
    }

    /**
     * Returns Schema.
     * The JSON schema for the custom attribute definition, which determines the data type of the
     * corresponding custom attributes. For more information,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview). This field is required when creating a definition.
     *
     * @return mixed
     */
    public function getSchema()
    {
        if (count($this->schema) == 0) {
            return null;
        }
        return $this->schema['value'];
    }

    /**
     * Sets Schema.
     * The JSON schema for the custom attribute definition, which determines the data type of the
     * corresponding custom attributes. For more information,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview). This field is required when creating a definition.
     *
     * @maps schema
     *
     * @param mixed $schema
     */
    public function setSchema($schema): void
    {
        $this->schema['value'] = $schema;
    }

    /**
     * Unsets Schema.
     * The JSON schema for the custom attribute definition, which determines the data type of the
     * corresponding custom attributes. For more information,
     * see [Custom Attributes Overview](https://developer.squareup.
     * com/docs/devtools/customattributes/overview). This field is required when creating a definition.
     */
    public function unsetSchema(): void
    {
        $this->schema = [];
    }

    /**
     * Returns Name.
     * The name of the custom attribute definition for API and seller-facing UI purposes. The name must
     * be unique within the seller and application pair. This field is required if the
     * `visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
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
     * The name of the custom attribute definition for API and seller-facing UI purposes. The name must
     * be unique within the seller and application pair. This field is required if the
     * `visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the custom attribute definition for API and seller-facing UI purposes. The name must
     * be unique within the seller and application pair. This field is required if the
     * `visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     */
    public function unsetName(): void
    {
        $this->name = [];
    }

    /**
     * Returns Description.
     * Seller-oriented description of the custom attribute definition, including any constraints
     * that the seller should observe. May be displayed as a tooltip in Square UIs. This field is
     * required if the `visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     */
    public function getDescription(): ?string
    {
        if (count($this->description) == 0) {
            return null;
        }
        return $this->description['value'];
    }

    /**
     * Sets Description.
     * Seller-oriented description of the custom attribute definition, including any constraints
     * that the seller should observe. May be displayed as a tooltip in Square UIs. This field is
     * required if the `visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description['value'] = $description;
    }

    /**
     * Unsets Description.
     * Seller-oriented description of the custom attribute definition, including any constraints
     * that the seller should observe. May be displayed as a tooltip in Square UIs. This field is
     * required if the `visibility` field is `VISIBILITY_READ_ONLY` or `VISIBILITY_READ_WRITE_VALUES`.
     */
    public function unsetDescription(): void
    {
        $this->description = [];
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
     * Returns Version.
     * Read only. The current version of the custom attribute definition.
     * The value is incremented each time the custom attribute definition is updated.
     * When updating a custom attribute definition, you can provide this field
     * and specify the current version of the custom attribute definition to enable
     * [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/optimistic-concurrency).
     *
     * On writes, this field must be set to the latest version. Stale writes are rejected.
     *
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
     * Read only. The current version of the custom attribute definition.
     * The value is incremented each time the custom attribute definition is updated.
     * When updating a custom attribute definition, you can provide this field
     * and specify the current version of the custom attribute definition to enable
     * [optimistic concurrency](https://developer.squareup.com/docs/build-basics/common-api-
     * patterns/optimistic-concurrency).
     *
     * On writes, this field must be set to the latest version. Stale writes are rejected.
     *
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
     * Returns Updated At.
     * The timestamp that indicates when the custom attribute definition was created or most recently
     * updated,
     * in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp that indicates when the custom attribute definition was created or most recently
     * updated,
     * in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Created At.
     * The timestamp that indicates when the custom attribute definition was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp that indicates when the custom attribute definition was created, in RFC 3339 format.
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
            $json['key']         = $this->key['value'];
        }
        if (!empty($this->schema)) {
            $json['schema']      = ApiHelper::decodeJson($this->schema['value'], 'schema');
        }
        if (!empty($this->name)) {
            $json['name']        = $this->name['value'];
        }
        if (!empty($this->description)) {
            $json['description'] = $this->description['value'];
        }
        if (isset($this->visibility)) {
            $json['visibility']  = $this->visibility;
        }
        if (isset($this->version)) {
            $json['version']     = $this->version;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']  = $this->updatedAt;
        }
        if (isset($this->createdAt)) {
            $json['created_at']  = $this->createdAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
