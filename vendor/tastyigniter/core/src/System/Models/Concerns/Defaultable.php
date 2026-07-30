<?php

declare(strict_types=1);

namespace Igniter\System\Models\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;

trait Defaultable
{
    public static array $defaultModels = [];

    public static function bootDefaultable(): void
    {
        static::extend(function(self $model) {
            $model->mergeCasts([$model->defaultableGetColumn() => 'boolean']);

            if ($model->getGuarded() || $model->getFillable()) {
                $model->mergeFillable([$model->defaultableGetColumn()]);
            }
        });

        static::created(function(self $model) {
            if ($model->isDefault()) {
                $model->makeDefault();
            }
        });

        static::saved(function(self $model) {
            if ($model->wasChanged($model->defaultableGetColumn()) && $model->isDefault()) {
                $model->makeDefault();
            }
        });
    }

    public static function updateDefault(mixed $id): bool
    {
        /** @var static $model */
        return ($model = static::firstWhere((new static)->defaultableKeyName(), $id)) && $model->makeDefault();
    }

    public static function getDefaultKey(): mixed
    {
        return ($default = static::getDefault())
            ? $default->{$default->defaultableKeyName()} : null;
    }

    public static function getDefault(): ?static
    {
        if (array_key_exists(static::class, static::$defaultModels)) {
            return static::$defaultModels[static::class];
        }

        /** @var static $defaultModel */
        if (!$defaultModel = (new static)->defaultableFindQuery()->applyDefaultable()->first()) {
            /** @var static $defaultModel */
            if ($defaultModel = (new static)->defaultableFindQuery()->first()) {
                $defaultModel->makeDefault();
            }
        }

        return static::$defaultModels[static::class] = $defaultModel;
    }

    public static function clearDefaultModel(): void
    {
        unset(static::$defaultModels[static::class]);
    }

    public static function clearDefaultModels(): void
    {
        static::$defaultModels = [];
    }

    public function makeDefault(): bool
    {
        if ($this->defaultableUsesSwitchable() && !$this->{$this->switchableGetColumn()}) {
            throw ValidationException::withMessages([$this->switchableGetColumn() => sprintf(
                lang('igniter::admin.alert_error_set_default'), $this->defaultableName(),
            )]);
        }

        static::withoutTimestamps(function() {
            $this->defaultable()
                ->where($this->defaultableGetColumn(), '!=', 0)
                ->update([$this->defaultableGetColumn() => 0]);

            $this->defaultable()
                ->where($this->defaultableKeyName(), $this->{$this->defaultableKeyName()})
                ->update([$this->defaultableGetColumn() => 1]);
        });

        return true;
    }

    public function isDefault(): bool
    {
        return (bool)$this->{$this->defaultableGetColumn()};
    }

    public function defaultableGetColumn(): string
    {
        if (defined(static::class.'::DEFAULTABLE_COLUMN')) {
            return static::DEFAULTABLE_COLUMN;
        }

        return 'is_default';
    }

    public function defaultableName(): string
    {
        return $this->name;
    }

    public function defaultableKeyName(): string
    {
        return $this->getKeyName();
    }

    public function defaultable(): Builder
    {
        return static::query();
    }

    public function scopeWhereIsDefault(Builder $query): Builder
    {
        return $this->scopeApplyDefaultable($query);
    }

    public function scopeWhereNotDefault(Builder $query): Builder
    {
        return $this->scopeApplyDefaultable($query, false);
    }

    public function scopeApplyDefaultable(Builder $query, bool $default = true): Builder
    {
        return $default
            ? $query->where($this->qualifyColumn($this->defaultableGetColumn()), true)
            : $query->where($this->qualifyColumn($this->defaultableGetColumn()), '!=', true);
    }

    protected function defaultableUsesSwitchable(): bool
    {
        return in_array(Switchable::class, class_uses_recursive(static::class));
    }

    protected function defaultableFindQuery(): Builder|static
    {
        $query = static::query();
        if ($this->defaultableUsesSwitchable()) {
            $query->whereIsEnabled();
        }

        return $query;
    }
}
