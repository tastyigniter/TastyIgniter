<?php

use apimatic\jsonmapper\JsonMapperException;
use apimatic\jsonmapper\JsonMapper;

class JsonMapperCommentsDiscardedException extends JsonMapper
{
    /**
     * @throws JsonMapperException
     */
    function __construct($config)
    {
        $this->config = $config;

        $this->zendOptimizerPlusExtensionLoaded = true;

        parent::__construct();
    }
}
?>