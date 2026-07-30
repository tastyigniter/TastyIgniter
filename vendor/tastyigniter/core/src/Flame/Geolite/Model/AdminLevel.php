<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite\Model;

use Override;
use Stringable;

readonly class AdminLevel implements Stringable
{
    public function __construct(
        private int $level,
        private string $name,
        private ?string $code = null
    ) {}

    /**
     * Returns the administrative level.
     *
     * @return int Level number [1,5]
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * Returns the administrative level name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the administrative level short name.
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Returns a string with the administrative level name.
     */
    #[Override]
    public function __toString(): string
    {
        return $this->getName();
    }
}
