<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic\Concerns;

trait HidesAttributes
{
    /**
     * The attributes that should be hidden for serialization.
     */
    protected array $hidden = [];

    /**
     * The attributes that should be visible in serialization.
     */
    protected array $visible = [];

    /**
     * Get the hidden attributes for the model.
     */
    public function getHidden(): array
    {
        return $this->hidden;
    }

    /**
     * Set the hidden attributes for the model.
     */
    public function setHidden(array $hidden): self
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Add hidden attributes for the model.
     */
    public function addHidden(array|string|null $attributes = null): void
    {
        $this->hidden = array_merge(
            $this->hidden, is_array($attributes) ? $attributes : func_get_args()
        );
    }

    /**
     * Get the visible attributes for the model.
     */
    public function getVisible(): array
    {
        return $this->visible;
    }

    /**
     * Set the visible attributes for the model.
     */
    public function setVisible(array $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Add visible attributes for the model.
     */
    public function addVisible(array|string|null $attributes = null): void
    {
        $this->visible = array_merge(
            $this->visible, is_array($attributes) ? $attributes : func_get_args()
        );
    }

    /**
     * Make the given, typically hidden, attributes visible.
     */
    public function makeVisible(array|string $attributes): self
    {
        $this->hidden = array_diff($this->hidden, (array)$attributes);

        if (!empty($this->visible)) {
            $this->addVisible($attributes);
        }

        return $this;
    }

    /**
     * Make the given, typically visible, attributes hidden.
     */
    public function makeHidden(array|string $attributes): self
    {
        $attributes = (array)$attributes;

        $this->visible = array_diff($this->visible, $attributes);

        $this->hidden = array_unique(array_merge($this->hidden, $attributes));

        return $this;
    }
}
