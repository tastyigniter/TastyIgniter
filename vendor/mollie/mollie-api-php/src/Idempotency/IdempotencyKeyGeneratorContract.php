<?php
namespace Mollie\Api\Idempotency;

interface IdempotencyKeyGeneratorContract
{
    public function generate();
}
