<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Fixtures;

use Igniter\Automation\Classes\BaseCondition;
use Override;

class TestCondition extends BaseCondition
{
    #[Override]
    public function conditionDetails(): array
    {
        return [
            'name' => 'Test Action',
            'description' => 'Test Action description',
        ];
    }

    #[Override]
    public function isTrue(&$params): bool
    {
        return false;
    }
}
