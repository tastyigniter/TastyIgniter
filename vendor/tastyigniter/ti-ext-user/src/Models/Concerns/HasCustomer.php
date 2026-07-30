<?php

declare(strict_types=1);

namespace Igniter\User\Models\Concerns;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Relations\BelongsTo;
use Igniter\Flame\Database\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

trait HasCustomer
{
    public function scopeApplyCustomer(Builder $query, $customerId): Builder
    {
        if ($customerId instanceof Model) {
            $customerId = $customerId->getKey();
        }

        $qualifiedColumnName = $this->getCustomerRelationObject()->getQualifiedForeignKeyName();

        if ($this->customerIsSingleRelationType()) {
            return $query->where($qualifiedColumnName, $customerId);
        }

        return $query->whereHas($this->getCustomerRelationName(), fn(Builder $query) => $query->where($qualifiedColumnName, $customerId));
    }

    protected function getCustomerRelationName(): string
    {
        if (defined(static::class.'::CUSTOMER_RELATION')) {
            return static::CUSTOMER_RELATION;
        }

        return 'customer';
    }

    protected function getCustomerRelationObject(): BelongsTo|HasMany
    {
        $relationName = $this->getCustomerRelationName();

        return $this->{$relationName}();
    }

    protected function customerIsSingleRelationType(): bool
    {
        $relationType = $this->getRelationType($this->getCustomerRelationName());

        return in_array($relationType, ['hasOne', 'belongsTo', 'morphOne']);
    }
}
