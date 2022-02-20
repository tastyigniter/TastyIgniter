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

    public function caller($caller = null)
    {
        if (is_null($caller)) {
            return $this->caller;
        }

        $this->caller = $caller;
        return $this;
    }

    public function context($context = null)
    {
        if (is_null($context)) {
            return $this->context;
        }

        $this->context = $context;
        return $this;
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
