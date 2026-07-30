<?php

declare(strict_types=1);

namespace Igniter\Local\Contracts;

interface WorkingHourInterface
{
    public function getDay();

    public function getOpen();

    public function getClose();

    public function isEnabled();
}
