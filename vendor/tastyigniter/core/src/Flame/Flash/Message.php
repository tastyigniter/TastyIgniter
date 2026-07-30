<?php

declare(strict_types=1);

namespace Igniter\Flame\Flash;

use AllowDynamicProperties;
use ArrayAccess;
use Override;

#[AllowDynamicProperties]
class Message implements ArrayAccess
{
    /** The title of the message. */
    public ?string $title = null;

    /** The body of the message. */
    public ?string $message = null;

    /** The message level. */
    public string $level = 'info';

    /** Whether the message should auto-hide. */
    public bool $important = false;

    /** Whether the message is an overlay. */
    public bool $overlay = false;

    /** The action URL for the message. */
    public ?string $actionUrl = null;

    /** The action text for the message. */
    public ?string $actionText = null;

    /**
     * Create a new message instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->update($attributes);
    }

    /**
     * Update the attributes.
     */
    public function update(array $attributes = []): self
    {
        $attributes = array_filter($attributes);

        foreach ($attributes as $key => $attribute) {
            $this->$key = $attribute;
        }

        return $this;
    }

    /**
     * Whether the given offset exists.
     */
    #[Override]
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->$offset);
    }

    /**
     * Fetch the offset.
     */
    #[Override]
    public function offsetGet(mixed $offset): mixed
    {
        return $this->$offset;
    }

    /**
     * Assign the offset.
     */
    #[Override]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    /**
     * Unset the offset.
     */
    #[Override]
    public function offsetUnset(mixed $offset): void
    {
        $this->$offset = null;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'level' => $this->level,
            'important' => $this->important,
            'overlay' => $this->overlay,
            'actionUrl' => $this->actionUrl,
            'actionText' => $this->actionText,
        ];
    }
}
