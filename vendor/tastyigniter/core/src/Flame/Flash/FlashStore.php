<?php

declare(strict_types=1);

namespace Igniter\Flame\Flash;

use Illuminate\Session\Store;
use Illuminate\Support\Collection;

class FlashStore
{
    /**
     * Create a new session store instance.
     */
    public function __construct(protected Store $session) {}

    /**
     * Flash a message to the session.
     */
    public function flash(string $name, Collection $data): void
    {
        $this->session->flash($name, $data);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->session->get($key, $default);
    }

    public function forget(string $key): void
    {
        $this->session->forget($key);
    }
}
