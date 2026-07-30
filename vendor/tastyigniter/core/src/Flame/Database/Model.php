<?php

declare(strict_types=1);

namespace Igniter\Flame\Database;

use Closure;
use Exception;
use Igniter\Flame\Database\Concerns\HasAttributes;
use Igniter\Flame\Database\Concerns\HasRelationships;
use Igniter\Flame\Database\Traits\HasQueryModifier;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Flame\Traits\ExtendableTrait;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Override;

/**
 * Model Class
 */
abstract class Model extends EloquentModel
{
    use EventEmitter;
    use ExtendableTrait;
    use HasAttributes;
    use HasQueryModifier;
    use HasRelationships;

    /**
     * @var array Make the model's attributes public so actions can modify them.
     */
    protected $attributes = [];

    public $timestamps = false;

    protected $guarded = [];

    /**
     * The storage format of the model's time columns.
     * @var string
     */
    protected $timeFormat;

    /**
     * The attributes that should be cast to native types.
     * New Custom types: serialize, time
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * @var array The array of models booted events.
     */
    protected static $eventsBooted = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->addObservableEvents(['fetching', 'fetched']);
        $this->bootNicerEvents();
        $this->extendableConstruct();
        $this->fill($attributes);

        if (!in_array('time', self::$primitiveCastTypes)) {
            self::$primitiveCastTypes[] = 'time';
            self::$primitiveCastTypes[] = 'serialize';
        }
    }

    /**
     * Create a new model and return the instance.
     *
     * @param array $attributes
     *
     * @return EloquentModel|static
     */
    public static function make($attributes = [])
    {
        return new static($attributes);
    }

    /**
     * Reloads the model attributes from the database.
     * @return EloquentModel|static
     */
    public function reload()
    {
        return $this->refresh();
    }

    /**
     * Reloads the model relationship cache.
     *
     * @param string $relationName
     */
    public function reloadRelations($relationName = null): void
    {
        if (!$relationName) {
            $this->setRelations([]);
        } else {
            unset($this->relations[$relationName]);
        }
    }

    /**
     * Extend this object properties upon construction.
     */
    public static function extend(callable $callback): void
    {
        self::extendableExtendCallback($callback);
    }

    public static function implement(string|array $class): void
    {
        self::extendableExtendCallback(function($instance) use ($class) {
            $instance->implement = array_unique(array_merge($instance->implement, (array)$class));
        });
    }

    /**
     * Bind some nicer events to this model, in the format of method overrides.
     */
    protected function bootNicerEvents()
    {
        $class = static::class;

        if (isset(static::$eventsBooted[$class])) {
            return;
        }

        $radicals = ['creat', 'sav', 'updat', 'delet', 'fetch'];
        $hooks = ['before' => 'ing', 'after' => 'ed'];

        foreach ($radicals as $radical) {
            foreach ($hooks as $hook => $event) {
                $eventMethod = $radical.$event; // saving / saved
                $method = $hook.ucfirst($radical); // beforeSave / afterSave
                if ($radical !== 'fetch') {
                    $method .= 'e';
                }

                self::$eventMethod(function(Model $model) use ($method) {
                    $model->fireEvent('model.'.$method);

                    if ($model->methodExists($method)) {
                        return $model->$method();
                    }
                });
            }
        }

        // Hook to boot events
        static::registerModelEvent('booted', function(Model $model) {
            $model->fireEvent('model.afterBoot');

            return $model->afterBoot();
        });

        static::$eventsBooted[$class] = true;
    }

    /**
     * Remove all of the event listeners for the model
     * Also flush registry of models that had events booted
     * Allows painless unit testing.
     * @override
     */
    #[Override]
    public static function flushEventListeners(): void
    {
        parent::flushEventListeners();
        static::$eventsBooted = [];
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param array $attributes
     *
     * @return EloquentModel|static
     */
    #[Override]
    public function newFromBuilder($attributes = [], $connection = null)
    {
        $instance = $this->newInstance([], true);

        if ($instance->fireModelEvent('fetching') === false) {
            return $instance;
        }

        $instance->setRawAttributes((array)$attributes, true);

        $instance->setConnection($connection ?: $this->getConnectionName());

        $instance->fireModelEvent('fetched', false);
        $instance->fireModelEvent('retrieved', false);

        return $instance;
    }

    /**
     * Handle the "booted" model event
     */
    protected function afterBoot() {}

    /**
     * Handle the "creating" model event
     */
    protected function beforeCreate() {}

    /**
     * Handle the "created" model event
     */
    protected function afterCreate() {}

    /**
     * Handle the "updating" model event
     */
    protected function beforeUpdate() {}

    /**
     * Handle the "updated" model event
     */
    protected function afterUpdate() {}

    /**
     * Handle the "saving" model event
     */
    protected function beforeSave() {}

    /**
     * Handle the "saved" model event
     */
    protected function afterSave() {}

    /**
     * Handle the "deleting" model event
     */
    protected function beforeDelete() {}

    /**
     * Handle the "deleted" model event
     */
    protected function afterDelete() {}

    /**
     * Handle the "fetching" model event
     */
    protected function beforeFetch() {}

    /**
     * Handle the "fetched" model event
     */
    protected function afterFetch() {}

    /**
     * Create a new native event for handling beforeFetch().
     *
     * @param Closure|string $callback
     */
    public static function fetching($callback): void
    {
        static::registerModelEvent('fetching', $callback);
    }

    /**
     * Create a new native event for handling afterFetch().
     *
     * @param Closure|string $callback
     */
    public static function fetched($callback): void
    {
        static::registerModelEvent('fetched', $callback);
    }

    //
    // Overrides
    //

    public function isRelationPurgeable($name)
    {
        $purgeableAttributes = [];
        if (method_exists($this, 'getPurgeableAttributes')) {
            $purgeableAttributes = $this->getPurgeableAttributes($name);
        }

        return in_array($name, $purgeableAttributes);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return Builder
     */
    #[Override]
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Get the default foreign key name for the model.
     * @return string
     */
    #[Override]
    public function getForeignKey()
    {
        return Str::snake(Str::singular(str_replace('_model', '', class_basename($this)))).'_id';
    }

    //
    // Magic
    //

    #[Override]
    public function __get($key)
    {
        return $this->extendableGet($key);
    }

    #[Override]
    public function __set($key, $value)
    {
        $this->extendableSet($key, $value);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param string $method
     *
     * @return mixed
     */
    #[Override]
    public function __call($method, $parameters)
    {
        if ($this->hasRelation($method)) {
            return $this->handleRelation($method);
        }

        return $this->extendableCall($method, $parameters);
    }

    //
    // Pivot
    //
    /**
     * Create a generic pivot model instance.
     * @param string $table
     * @param bool $exists
     * @param string|null $using
     * @return Pivot|\Illuminate\Database\Eloquent\Relations\Pivot
     */
    #[Override]
    public function newPivot(EloquentModel $parent, array $attributes, $table, $exists, $using = null)
    {
        return $using
            ? $using::fromRawAttributes($parent, $attributes, $table, $exists)
            : Pivot::fromAttributes($parent, $attributes, $table, $exists);
    }

    /**
     * Create a pivot model instance specific to a relation.
     * @param string $relationName
     * @param string $table
     * @param bool $exists
     * @return null|Pivot|\Illuminate\Database\Eloquent\Relations\Pivot
     */
    public function newRelationPivot($relationName, EloquentModel $parent, array $attributes, $table, $exists)
    {
        $definition = $this->getRelationDefinition($relationName);

        if (!is_null($definition) && array_key_exists('pivotModel', $definition)) {
            return $this->newPivot($parent, $attributes, $table, $exists, $definition['pivotModel']);
        }

        return null;
    }

    //
    // Saving
    //
    /**
     * Save the model to the database. Is used by {@link save()}
     *
     * @param array $options
     *
     * @return bool
     * @throws Exception
     */
    protected function saveInternal($options = [])
    {
        // Event
        if ($this->fireEvent('model.saveInternal', [$this->attributes, $options], true) === false) {
            return false;
        }

        // Save the record
        $result = parent::save($options);

        // Halted by event
        if ($result === false) {
            return false;
        }

        // If there is nothing to update, Eloquent will not fire afterSave(),
        // events should still fire for consistency.
        if ($result === null) {
            $this->fireModelEvent('updated', false);
            $this->fireModelEvent('saved', false);
        }

        return $result;
    }

    /**
     * Save the model to the database.
     *
     * @return bool
     * @throws Exception
     */
    #[Override]
    public function save(?array $options = null)
    {
        return $this->saveInternal(['force' => false] + (array)$options);
    }

    /**
     * Save the model and all of its relationships.
     *
     * @param array $options
     *
     * @return bool
     * @throws Exception
     */
    #[Override]
    public function push($options = null)
    {
        $always = Arr::get($options, 'always', false);

        if (!$this->save() && !$always) {
            return false;
        }

        foreach ($this->relations as $name => $models) {
            if (!$this->isRelationPushable($name)) {
                continue;
            }

            if ($models instanceof EloquentCollection) {
                $models = $models->all();
            } elseif ($models instanceof EloquentModel) {
                $models = [$models];
            }

            foreach (array_filter($models) as $model) {
                if (!$model->push($options)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Pushes the first level of relations even if the parent
     * model has no changes.
     *
     * @param array $options
     * @param string $sessionKey
     *
     * @return bool
     */
    public function alwaysPush($options = null, $sessionKey = null)
    {
        return $this->push(['always' => true] + (array)$options);
    }

    /**
     * Perform the actual delete query on this model instance.
     * @return void
     */
    #[Override]
    protected function performDeleteOnModel()
    {
        $this->performDeleteOnRelations();
        $this->setKeysForSaveQuery($this->newQueryWithoutScopes())->delete(); // @phpstan-ignore-line
    }

    /**
     * Locates relations with delete flag and cascades the delete event.
     * @return void
     */
    protected function performDeleteOnRelations()
    {
        $definitions = $this->getRelationDefinitions();
        foreach ($definitions as $type => $relations) {
            /*
             * Hard 'delete' definition
             */
            foreach ($relations as $name => $options) {
                if (!Arr::get($options, 'delete', false)) {
                    continue;
                }

                $relation = $this->{$name};

                if ($relation instanceof EloquentModel) {
                    $relation->forceDelete();
                } elseif ($relation instanceof EloquentCollection) {
                    $relation->each(function($model) {
                        $model->forceDelete();
                    });
                }
            }

            /*
             * Belongs-To-Many should clean up after itself always
             */
            if ($type == 'belongsToMany') {
                foreach ($relations as $name => $options) {
                    if (Arr::get($options, 'delete', Arr::get($options, 'detach', true))) {
                        $this->{$name}()->detach();
                    }
                }
            }
        }
    }
}
