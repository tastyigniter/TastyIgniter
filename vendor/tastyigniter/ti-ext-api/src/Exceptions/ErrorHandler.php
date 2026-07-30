<?php

declare(strict_types=1);

namespace Igniter\Api\Exceptions;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ErrorHandler
{
    /**
     * User defined replacements to merge with defaults.
     *
     * @var array
     */
    protected $replacements = [];

    /**
     * @param bool $debug
     */
    public function __construct(
        protected ExceptionHandler $parentHandler,
        protected array $format,
        protected $debug,
    ) {
        if (method_exists($this->parentHandler, 'renderable')) {
            $this->parentHandler->renderable(fn(Throwable $ex): ?Response => $this->render(request(), $ex));
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     */
    public function render($request, Throwable $e): ?Response
    {
        if (!$request->routeIs('igniter.api.*.*')) {
            return null;
        }

        // Convert Eloquent's 500 ModelNotFoundException into a 404 NotFoundHttpException
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if ($e instanceof ValidationException) {
            $e = new ValidationHttpException($e->errors(), $e);
        }

        return $this->genericResponse($e);
    }

    /**
     * Handle a generic error response if there is no handler available.
     *
     * @throws Throwable
     */
    protected function genericResponse(Throwable $exception): Response
    {
        $replacements = $this->prepareReplacements($exception);

        $response = $this->format;

        array_walk_recursive($response, function(&$value, $key) use ($replacements): void {
            if (Str::startsWith($value, ':') && isset($replacements[$value])) {
                $value = $replacements[$value];
            }
        });

        $response = $this->recursivelyRemoveEmptyReplacements($response);

        return new Response($response, $this->getStatusCode($exception), $this->getHeaders($exception));
    }

    /**
     * Get the status code from the exception.
     *
     * @return int
     */
    protected function getStatusCode(Throwable $exception)
    {
        // By default throw 500
        $statusCode = $exception->getCode() ?: 500;
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
        }

        // Be extra defensive
        if (!is_numeric($statusCode) || $statusCode < 100 || $statusCode > 599) {
            $statusCode = 500;
        }

        return $statusCode;
    }

    /**
     * Get the headers from the exception.
     */
    protected function getHeaders(Throwable $exception): array
    {
        return $exception instanceof HttpExceptionInterface ? $exception->getHeaders() : [];
    }

    /**
     * Prepare the replacements array by gathering the keys and values.
     */
    protected function prepareReplacements(Throwable $exception): array
    {
        $statusCode = $this->getStatusCode($exception);
        $message = $exception->getMessage();

        if ($message === '' || $message === '0') {
            $message = sprintf('%d %s', $statusCode, Response::$statusTexts[$statusCode]);
        }

        $replacements = [
            ':message' => $message,
            ':status_code' => $statusCode,
        ];

        if ($exception instanceof ResourceException && $exception->hasErrors()) {
            $replacements[':errors'] = $exception->errors();
        }

        if ($code = $exception->getCode()) {
            $replacements[':code'] = $code;
        }

        if ($this->debug) {
            $replacements[':debug'] = [
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'class' => $exception::class,
                'trace' => explode("\n", $exception->getTraceAsString()),
            ];

            // Attach trace of previous exception, if exists
            if (!is_null($exception->getPrevious())) {
                $currentTrace = $replacements[':debug']['trace'];

                $replacements[':debug']['trace'] = [
                    'previous' => explode("\n", $exception->getPrevious()->getTraceAsString()),
                    'current' => $currentTrace,
                ];
            }
        }

        return array_merge($replacements, $this->replacements);
    }

    /**
     * Recursively remove any empty replacement values in the response array.
     */
    protected function recursivelyRemoveEmptyReplacements(array $input): array
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = $this->recursivelyRemoveEmptyReplacements($value);
            }
        }

        return array_filter($input, function($value): bool {
            if (is_string($value)) {
                return !Str::startsWith($value, ':');
            }

            return true;
        });
    }
}
