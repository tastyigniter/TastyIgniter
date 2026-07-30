<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a Square Online site, which is an online store for a Square seller.
 */
class Site implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $siteTitle = [];

    /**
     * @var array
     */
    private $domain = [];

    /**
     * @var array
     */
    private $isPublished = [];

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * Returns Id.
     * The Square-assigned ID of the site.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the site.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Site Title.
     * The title of the site.
     */
    public function getSiteTitle(): ?string
    {
        if (count($this->siteTitle) == 0) {
            return null;
        }
        return $this->siteTitle['value'];
    }

    /**
     * Sets Site Title.
     * The title of the site.
     *
     * @maps site_title
     */
    public function setSiteTitle(?string $siteTitle): void
    {
        $this->siteTitle['value'] = $siteTitle;
    }

    /**
     * Unsets Site Title.
     * The title of the site.
     */
    public function unsetSiteTitle(): void
    {
        $this->siteTitle = [];
    }

    /**
     * Returns Domain.
     * The domain of the site (without the protocol). For example, `mysite1.square.site`.
     */
    public function getDomain(): ?string
    {
        if (count($this->domain) == 0) {
            return null;
        }
        return $this->domain['value'];
    }

    /**
     * Sets Domain.
     * The domain of the site (without the protocol). For example, `mysite1.square.site`.
     *
     * @maps domain
     */
    public function setDomain(?string $domain): void
    {
        $this->domain['value'] = $domain;
    }

    /**
     * Unsets Domain.
     * The domain of the site (without the protocol). For example, `mysite1.square.site`.
     */
    public function unsetDomain(): void
    {
        $this->domain = [];
    }

    /**
     * Returns Is Published.
     * Indicates whether the site is published.
     */
    public function getIsPublished(): ?bool
    {
        if (count($this->isPublished) == 0) {
            return null;
        }
        return $this->isPublished['value'];
    }

    /**
     * Sets Is Published.
     * Indicates whether the site is published.
     *
     * @maps is_published
     */
    public function setIsPublished(?bool $isPublished): void
    {
        $this->isPublished['value'] = $isPublished;
    }

    /**
     * Unsets Is Published.
     * Indicates whether the site is published.
     */
    public function unsetIsPublished(): void
    {
        $this->isPublished = [];
    }

    /**
     * Returns Created At.
     * The timestamp of when the site was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp of when the site was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp of when the site was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp of when the site was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
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
        if (isset($this->id)) {
            $json['id']           = $this->id;
        }
        if (!empty($this->siteTitle)) {
            $json['site_title']   = $this->siteTitle['value'];
        }
        if (!empty($this->domain)) {
            $json['domain']       = $this->domain['value'];
        }
        if (!empty($this->isPublished)) {
            $json['is_published'] = $this->isPublished['value'];
        }
        if (isset($this->createdAt)) {
            $json['created_at']   = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']   = $this->updatedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
