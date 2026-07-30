<?php

namespace Stevebauman\Purify\Casts;

abstract class Caster
{
    /**
     * The name of the config to use for purification.
     *
     * @var string|null
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param string|null $config
     */
    public function __construct($config = null)
    {
        $this->config = $config;
    }
}
