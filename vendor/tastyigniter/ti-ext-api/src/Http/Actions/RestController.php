<?php

declare(strict_types=1);

namespace Igniter\Api\Http\Actions;

use Igniter\Admin\Traits\FormModelWidget;
use Igniter\Api\Classes\AbstractRepository;
use Igniter\Api\Classes\ApiController;
use Igniter\Api\Exceptions\ValidationHttpException;
use Igniter\Api\Traits\RestExtendable;
use Igniter\Flame\Database\Model;
use Igniter\System\Classes\ControllerAction;
use Illuminate\Database\Eloquent\Model as IlluminateModel;
use Illuminate\Validation\ValidationException;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rest Controller Action
 */
class RestController extends ControllerAction
{
    use FormModelWidget;
    use RestExtendable;

    protected null|Model|IlluminateModel $model = null;

    protected array $requiredProperties = ['restConfig'];

    /** Configuration values that must exist when applying the primary config file. - model: Class name for the model */
    protected array $requiredConfig = ['actions', 'repository', 'transformer'];

    /** @param ApiController $controller */
    public function __construct(protected $controller)
    {
        parent::__construct($controller);

        $this->setConfig($controller->restConfig, $this->requiredConfig);

        $this->mergeAllowedActions();
    }

    /**
     * Display the records.
     */
    public function index(): Response
    {
        $requestQuery = $this->validateRequest('query');

        $options = array_merge($this->getActionOptions(), $requestQuery);

        $records = $this->makeRepository('query')->findAll($options);

        $fractal = $this->controller->fractal()
            ->collection($records)
            ->transformWith($this->createTransformer())
            ->paginateWith(new IlluminatePaginatorAdapter($records))
            ->withResourceName($this->getResourceKey());

        return response()->json($fractal->toArray());
    }

    /**
     * Store a newly created record using post data.
     */
    public function store(): Response
    {
        $repository = $this->makeRepository('create');

        $this->model = $repository->createModel();

        $request = $this->validateRequest('all');

        $model = $repository->create($this->model, $request);

        $response = $this->controller->fractal()
            ->item($model)
            ->transformWith($this->createTransformer())
            ->withResourceName($this->getResourceKey())
            ->toArray();

        return response()->json($response)->setStatusCode(201);
    }

    /**
     * Display the specified record.
     */
    public function show(int $recordId): Response
    {
        $this->validateRequest('query');

        $result = $this->makeRepository('query')->find($recordId);

        $response = $this->controller->fractal()
            ->item($result)
            ->transformWith($this->createTransformer())
            ->withResourceName($this->getResourceKey())
            ->toArray();

        return response()->json($response);
    }

    /**
     * Update the specified record in using post data.
     */
    public function update(int $recordId): Response
    {
        $repository = $this->makeRepository('update');

        $this->model = $repository->find($recordId);

        $request = $this->validateRequest('all');

        $result = $this->makeRepository('update')->update($this->model, $request);

        $response = $this->controller->fractal()
            ->item($result)
            ->transformWith($this->createTransformer())
            ->withResourceName($this->getResourceKey())
            ->toArray();

        return response()->json($response);
    }

    /**
     * Remove the specified record.
     */
    public function destroy(int $recordId): Response
    {
        $this->makeRepository('delete')->delete($recordId);

        return response()->json()->setStatusCode(204);
    }

    public function getActionOptions(): array
    {
        return array_get($this->getConfig('actions'), $this->controller->getAction(), []);
    }

    //
    //
    //

    protected function mergeAllowedActions()
    {
        $actions = array_get($this->config, 'actions', []);

        $this->controller->allowedActions = array_merge(
            $this->controller->allowedActions, $actions,
        );
    }

    protected function createTransformer(): TransformerAbstract
    {
        $transformerClass = $this->getConfig('transformer');

        return new $transformerClass;
    }

    protected function validateRequest(string $requestMethod): array
    {
        $requestData = request()->$requestMethod();

        try {
            if ($requestMethod === 'query') {
                return $this->controller->restValidateQuery($requestData);
            }

            if ($requestClass = $this->getConfig('request')) {
                $request = app()->make($requestClass);

                return $request->$requestMethod();
            }

            return $this->controller->restValidate($requestData);
        } catch (ValidationException $ex) {
            throw new ValidationHttpException($ex->errors(), $ex);
        }
    }

    protected function makeRepository(string $context): AbstractRepository
    {
        $repository = app()->make($this->getConfig('repository'));

        $methodName = studly_case('bind_'.$context.'_events');
        if (method_exists($this, $methodName)) {
            $this->{$methodName}($repository);
        }

        return $repository;
    }

    protected function bindQueryEvents(AbstractRepository $repository): void
    {
        $repository->bindEvent('repository.extendQuery', function($query): void {
            $this->controller->restExtendQuery($query);
        });
    }

    protected function bindCreateEvents(AbstractRepository $repository): void
    {
        $repository->bindEvent('repository.beforeCreate', function($model): void {
            $this->controller->restBeforeSave($model);
            $this->controller->restBeforeCreate($model);
        });

        $repository->bindEvent('repository.afterCreate', function($model): void {
            $this->controller->restAfterSave($model);
            $this->controller->restAfterCreate($model);
        });
    }

    protected function bindUpdateEvents(AbstractRepository $repository): void
    {
        $repository->bindEvent('repository.beforeUpdate', function($model): void {
            $this->controller->restBeforeSave($model);
            $this->controller->restAfterUpdate($model);
        });

        $repository->bindEvent('repository.afterUpdate', function($model): void {
            $this->controller->restAfterSave($model);
            $this->controller->restAfterUpdate($model);
        });
    }

    protected function bindDeleteEvents(AbstractRepository $repository): void
    {
        $repository->bindEvent('repository.afterDelete', function($model): void {
            $this->controller->restAfterDelete($model);
        });
    }

    protected function getResourceKey(): string
    {
        return $this->getConfig('resourceKey', strtolower(class_basename($this->controller)));
    }
}
