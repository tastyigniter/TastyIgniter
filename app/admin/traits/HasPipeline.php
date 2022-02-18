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
        $payloadClass = (new \ReflectionClass(self::class))->getName();

        $pipes = collect(self::$registeredPipelines)
                    ->filter(function ($contexts, $klass) use ($payloadClass, $callingContext) {
                        if (! in_array($klass, ['*', $payloadClass])) {
                            return [];
                        }

                        return $contexts->filter(function ($pipelines, $pipelineContext) use ($callingContext) {
                            if (! in_array($pipelineContext, ['*', $callingContext])) {
                                return [];
                            }

                            return $pipelines;
                        });
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

    // register a pipeline by * for all classes
    // or by classname (eg Admin\Widgets\Lists::class)
    public static function registerPipeline($klass, $context, $pipelineClass)
    {
        if (! array_get(self::$registeredPipelines, $klass, false)) {
            self::$registeredPipelines[$klass] = [];
        }

        if (! array_get(self::$registeredPipelines[$klass], $context, false)) {
            self::$registeredPipelines[$klass][$context] = [];
        }

        self::$registeredPipelines[$klass][$context] = $pipelineClass;
    }
}
