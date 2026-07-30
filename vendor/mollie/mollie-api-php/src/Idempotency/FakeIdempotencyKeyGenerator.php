<?php

declare(strict_types=1);

namespace Mollie\Api\Idempotency;

class FakeIdempotencyKeyGenerator implements IdempotencyKeyGeneratorContract
{
    /** @var string */
    private $fakeKey;

    public function setFakeKey($fakeKey)
    {
        $this->fakeKey = $fakeKey;
    }

    public function generate()
    {
        return $this->fakeKey;
    }
}
