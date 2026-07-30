<?php

declare(strict_types=1);

namespace Igniter\Flame\Currency\Contracts;

interface CurrencyInterface
{
    public function getId(): ?int;

    public function getName(): ?string;

    public function getCode(): ?string;

    public function getSymbol(): ?string;

    public function getSymbolPosition(): ?bool;

    public function getFormat(): string;

    public function getRate(): ?float;

    public function isEnabled(): bool;

    public function updateRate($rate);
}
