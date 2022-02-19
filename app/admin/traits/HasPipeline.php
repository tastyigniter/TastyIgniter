<?php

namespace Admin\Traits;

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

    public function callPipeline($callingContext, $payload)
    {
        $pipes = collect(self::$registeredPipelines)
            ->filter(function ($pipelines, $context) use ($callingContext) {
                if (!in_array($context, ['*', $callingContext])) {
                    return [];
                }

                return $pipelines;
            })
            ->filter()
            ->flatten()
            ->values();

        if (empty($pipes)) {
            return $payload;
        }

        return app(Pipeline::class)
            ->send($payload)
            ->through($pipes)
            ->thenReturn();
    }

    // register a pipeline by * for all contexts
    // or by classname (eg Admin\Widgets\Lists::class)
    public static function registerPipeline($context, $pipelineClass)
    {
        if (!array_get(self::$registeredPipelines, $context, false)) {
            self::$registeredPipelines[$context] = [];
        }

        self::$registeredPipelines[$context] = $pipelineClass;
    }
}
