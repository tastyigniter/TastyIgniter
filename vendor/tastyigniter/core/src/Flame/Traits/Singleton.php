<?php

declare(strict_types=1);

namespace Igniter\Flame\Traits;

/**
 * Singleton trait.
 *
 * Allows a simple interface for treating a class as a singleton.
 * Usage: myObject::instance()
 *
 * @deprecated remove in v5
 * @codeCoverageIgnore
 */
trait Singleton
{
    protected static $instance;

    /**
     * Create a new instance of this singleton.
     */
    final public static function instance()
    {
        return static::$instance ?? (static::$instance = new static);
    }

    /**
     * Forget this singleton's instance if it exists
     */
    final public static function forgetInstance(): void
    {
        static::$instance = null;
    }

    /**
     * Constructor.
     */
    final protected function __construct()
    {
        $this->initialize();
    }

    /**
     * Initialize the singleton free from constructor parameters.
     */
    protected function initialize() {}

    public function __clone()
    {
        trigger_error('Cloning '.self::class.' is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Unserializing '.self::class.' is not allowed.', E_USER_ERROR);
    }
}
