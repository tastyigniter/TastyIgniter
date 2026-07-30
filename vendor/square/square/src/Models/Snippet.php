<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents the snippet that is added to a Square Online site. The snippet code is injected into the
 * `head` element of all pages on the site, except for checkout pages.
 */
class Snippet implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var string|null
     */
    private $siteId;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /**
     * Returns Id.
     * The Square-assigned ID for the snippet.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID for the snippet.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Site Id.
     * The ID of the site that contains the snippet.
     */
    public function getSiteId(): ?string
    {
        return $this->siteId;
    }

    /**
     * Sets Site Id.
     * The ID of the site that contains the snippet.
     *
     * @maps site_id
     */
    public function setSiteId(?string $siteId): void
    {
        $this->siteId = $siteId;
    }

    /**
     * Returns Content.
     * The snippet code, which can contain valid HTML, JavaScript, or both.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Sets Content.
     * The snippet code, which can contain valid HTML, JavaScript, or both.
     *
     * @required
     * @maps content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Returns Created At.
     * The timestamp of when the snippet was initially added to the site, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp of when the snippet was initially added to the site, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp of when the snippet was last updated on the site, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp of when the snippet was last updated on the site, in RFC 3339 format.
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
            $json['id']         = $this->id;
        }
        if (isset($this->siteId)) {
            $json['site_id']    = $this->siteId;
        }
        $json['content']        = $this->content;
        if (isset($this->createdAt)) {
            $json['created_at'] = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at'] = $this->updatedAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
