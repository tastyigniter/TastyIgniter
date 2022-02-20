<?php

namespace Admin\Classes;

/**
 * Pipeline Payload 'helper' passed to external extensions
 */
class PipelinePayload
{
    private $caller;
    private $context;
    private $data;

    public function __construct($caller, $context)
    {
        $this->caller = $caller;
        $this->context = $context;
    }

    public function caller()
    {
        return $this->caller;
    }

    public function context()
    {
        return $this->context;
    }

    public function data($data = null)
    {
        if (is_null($data)) {
            return $this->data;
        }

        $this->data = $data;
        return $this;
    }
}
