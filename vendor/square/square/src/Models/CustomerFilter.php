<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the filtering criteria in a [search query]($m/CustomerQuery) that defines how to filter
 * customer profiles returned in [SearchCustomers]($e/Customers/SearchCustomers) results.
 */
class CustomerFilter implements \JsonSerializable
{
    /**
     * @var CustomerCreationSourceFilter|null
     */
    private $creationSource;

    /**
     * @var TimeRange|null
     */
    private $createdAt;

    /**
     * @var TimeRange|null
     */
    private $updatedAt;

    /**
     * @var CustomerTextFilter|null
     */
    private $emailAddress;

    /**
     * @var CustomerTextFilter|null
     */
    private $phoneNumber;

    /**
     * @var CustomerTextFilter|null
     */
    private $referenceId;

    /**
     * @var FilterValue|null
     */
    private $groupIds;

    /**
     * @var CustomerCustomAttributeFilters|null
     */
    private $customAttribute;

    /**
     * @var FilterValue|null
     */
    private $segmentIds;

    /**
     * Returns Creation Source.
     * The creation source filter.
     *
     * If one or more creation sources are set, customer profiles are included in,
     * or excluded from, the result if they match at least one of the filter criteria.
     */
    public function getCreationSource(): ?CustomerCreationSourceFilter
    {
        return $this->creationSource;
    }

    /**
     * Sets Creation Source.
     * The creation source filter.
     *
     * If one or more creation sources are set, customer profiles are included in,
     * or excluded from, the result if they match at least one of the filter criteria.
     *
     * @maps creation_source
     */
    public function setCreationSource(?CustomerCreationSourceFilter $creationSource): void
    {
        $this->creationSource = $creationSource;
    }

    /**
     * Returns Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getCreatedAt(): ?TimeRange
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps created_at
     */
    public function setCreatedAt(?TimeRange $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     */
    public function getUpdatedAt(): ?TimeRange
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * Represents a generic time range. The start and end values are
     * represented in RFC 3339 format. Time ranges are customized to be
     * inclusive or exclusive based on the needs of a particular endpoint.
     * Refer to the relevant endpoint-specific documentation to determine
     * how time ranges are handled.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?TimeRange $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Email Address.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     */
    public function getEmailAddress(): ?CustomerTextFilter
    {
        return $this->emailAddress;
    }

    /**
     * Sets Email Address.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     *
     * @maps email_address
     */
    public function setEmailAddress(?CustomerTextFilter $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Returns Phone Number.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     */
    public function getPhoneNumber(): ?CustomerTextFilter
    {
        return $this->phoneNumber;
    }

    /**
     * Sets Phone Number.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?CustomerTextFilter $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Returns Reference Id.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     */
    public function getReferenceId(): ?CustomerTextFilter
    {
        return $this->referenceId;
    }

    /**
     * Sets Reference Id.
     * A filter to select customers based on exact or fuzzy matching of
     * customer attributes against a specified query. Depending on the customer attributes,
     * the filter can be case-sensitive. This filter can be exact or fuzzy, but it cannot be both.
     *
     * @maps reference_id
     */
    public function setReferenceId(?CustomerTextFilter $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    /**
     * Returns Group Ids.
     * A filter to select resources based on an exact field value. For any given
     * value, the value can only be in one property. Depending on the field, either
     * all properties can be set or only a subset will be available.
     *
     * Refer to the documentation of the field.
     */
    public function getGroupIds(): ?FilterValue
    {
        return $this->groupIds;
    }

    /**
     * Sets Group Ids.
     * A filter to select resources based on an exact field value. For any given
     * value, the value can only be in one property. Depending on the field, either
     * all properties can be set or only a subset will be available.
     *
     * Refer to the documentation of the field.
     *
     * @maps group_ids
     */
    public function setGroupIds(?FilterValue $groupIds): void
    {
        $this->groupIds = $groupIds;
    }

    /**
     * Returns Custom Attribute.
     * The custom attribute filters in a set of [customer filters]($m/CustomerFilter) used in a search
     * query. Use this filter
     * to search based on [custom attributes]($m/CustomAttribute) that are assigned to customer profiles.
     * For more information, see
     * [Search by custom attribute](https://developer.squareup.com/docs/customers-api/use-the-api/search-
     * customers#search-by-custom-attribute).
     */
    public function getCustomAttribute(): ?CustomerCustomAttributeFilters
    {
        return $this->customAttribute;
    }

    /**
     * Sets Custom Attribute.
     * The custom attribute filters in a set of [customer filters]($m/CustomerFilter) used in a search
     * query. Use this filter
     * to search based on [custom attributes]($m/CustomAttribute) that are assigned to customer profiles.
     * For more information, see
     * [Search by custom attribute](https://developer.squareup.com/docs/customers-api/use-the-api/search-
     * customers#search-by-custom-attribute).
     *
     * @maps custom_attribute
     */
    public function setCustomAttribute(?CustomerCustomAttributeFilters $customAttribute): void
    {
        $this->customAttribute = $customAttribute;
    }

    /**
     * Returns Segment Ids.
     * A filter to select resources based on an exact field value. For any given
     * value, the value can only be in one property. Depending on the field, either
     * all properties can be set or only a subset will be available.
     *
     * Refer to the documentation of the field.
     */
    public function getSegmentIds(): ?FilterValue
    {
        return $this->segmentIds;
    }

    /**
     * Sets Segment Ids.
     * A filter to select resources based on an exact field value. For any given
     * value, the value can only be in one property. Depending on the field, either
     * all properties can be set or only a subset will be available.
     *
     * Refer to the documentation of the field.
     *
     * @maps segment_ids
     */
    public function setSegmentIds(?FilterValue $segmentIds): void
    {
        $this->segmentIds = $segmentIds;
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
        if (isset($this->creationSource)) {
            $json['creation_source']  = $this->creationSource;
        }
        if (isset($this->createdAt)) {
            $json['created_at']       = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']       = $this->updatedAt;
        }
        if (isset($this->emailAddress)) {
            $json['email_address']    = $this->emailAddress;
        }
        if (isset($this->phoneNumber)) {
            $json['phone_number']     = $this->phoneNumber;
        }
        if (isset($this->referenceId)) {
            $json['reference_id']     = $this->referenceId;
        }
        if (isset($this->groupIds)) {
            $json['group_ids']        = $this->groupIds;
        }
        if (isset($this->customAttribute)) {
            $json['custom_attribute'] = $this->customAttribute;
        }
        if (isset($this->segmentIds)) {
            $json['segment_ids']      = $this->segmentIds;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
