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
    private $extra;

    public function __construct($caller, $context, $extra = null)
    {
        $this->caller = $caller;
        $this->context = $context;
        $this->extra = $extra;
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

    public function extra()
    {
        return $this->extra;
    }
}
