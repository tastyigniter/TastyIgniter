<?php

namespace Admin\Traits;

use Admin\Classes\PipelinePayload;
use Illuminate\Pipeline\Pipeline;

/**
 * Has Pipeline Trait Class
 */
trait HasPipeline
{
    /**
     * @var array of registered pipelines
     */
    protected static $registeredPipelines = [];

    public function callPipeline($caller, $callingContext, $data, $extra = null)
    {
        $pipes = self::$registeredPipelines;

        if (!count($pipes)) {
            return $data;
        }

        if (!is_string($caller)) {
            $caller = get_class($caller);
        }

        $payload = (new PipelinePayload($caller, $callingContext, $extra))
            ->data($data);

        $pipelineResponse = app(Pipeline::class)
            ->send($payload)
            ->through($pipes)
            ->thenReturn();

        return $pipelineResponse->data();
    }

    public static function registerPipeline($pipelineClass)
    {
        self::$registeredPipelines[] = $pipelineClass;
    }
}
